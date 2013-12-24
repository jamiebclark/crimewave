<?php
App::uses('StatMod', 'Lib');

class Obstacle extends AppModel {
	public $name = 'Obstacle';
	public $actsAs = array(
		'TurnTrack',
		'Layout.FieldOrder' => array(
			'orderField' => 'order',
			'subKeyFields' => array('job_id')
		)
	);
	public $hasMany = array(
		'ObstacleAttributeCheck',
	);
	public $belongsTo = array('Job');
	public $hasAndBelongsToMany = array(
		'Attribute' => array(
			'joinTable' => 'obstacle_attribute_checks',
		),
		'Character', 
		'CharacterType'
	);
	
	public $order = array(
		'Obstacle.job_id' => 'ASC',
		'Obstacle.order' => 'ASC',
	);
	
	public function afterAdvanceTurn($id) {
		$result = $this->find('first', array(
			'contain' => array(
				'Job',
				'ObstacleAttributeCheck' => array('Attribute'),
				'Character' => array('CharacterAttribute'),
			),
			'conditions' => array($this->escapeField('id') => $id)
		));
		
		//Checks logic to see if the turn succeeds
		$checkResult = $this->checkResult($result);
		if ($checkResult === true) {
			if ($this->checkComplete($result)) {
				$this->setComplete($id, true);
			}
		} else if ($checkResult === false) {
			$this->setComplete($id, false);
		}
		
		return parent::afterAdvanceTurn($id);
	}
	
	//Checks to see if an Obstacle has been completed yet
	private function checkComplete($result) {
		if ($result[$this->alias]['minutes'] >= $result[$this->alias]['total_length']) {
			return true;
		} else {
			return false;
		}
	}
	
	private function setComplete($id, $success = true) {
		$this->updateAll(array(
			$this->escapeField('success') => $success,
			$this->escapeField('completed') => 1,
			$this->escapeField('stopped') => sprintf('"%s"', $this->getTurnDateTime()),
		), array(
			$this->escapeField('id') => $id,
		));	
	}
	
	/**
	 * This is the main logic of the Obstacle, checking if it was successfully completed
	 *
	 **/
	private function checkResult($result) {
		$success = false;
		if (empty($result['ObstacleAttributeCheck'])) {
			return true;
		}
		$level = $result['Job']['level'];
		CakeLog::write('story', sprintf('Checking Level %s Obstacle: %s', $level, $result['Obstacle']['title']));
		if ($result['Obstacle']['minutes'] < $result['Obstacle']['total_length']) {
			CakeLog::write('story', sprintf('Working %d out of %s minutes', $result['Obstacle']['minutes'], $result['Obstacle']['total_length']));
			return null;
		}
		
		foreach ($result['ObstacleAttributeCheck'] as $obstacleAttributeCheck) {
			$obstacleValue = $obstacleAttributeCheck['value'];
			$attributeId = $obstacleAttributeCheck['Attribute']['id'];
			$attributeTitle = $obstacleAttributeCheck['Attribute']['title'];
			
			CakeLog::write('story', sprintf('Checking Attribute %s', $attributeTitle));
			
			if (empty($result['Character'])) {
				CakeLog::write('story', 'No character is found, failing check');
				return false;
			}
			//Checks each character against the Obstacle Attribute
			foreach ($result['Character'] as $character) {
				$characterLevel = $character['level'];
				CakeLog::write('story', sprintf('Checking Level %s Character %s for Attribute %s', 
					$characterLevel, $character['name'], $attributeTitle));
				foreach ($character['CharacterAttribute'] as $characterAttribute) {
					if ($characterAttribute['attribute_id'] == $attributeId) {
						$characterValue = $characterAttribute['value'];
						CakeLog::write('story', sprintf('Attribute: %s - Obstacle: %s:%s --- Character: %s:%s', 
							$attributeTitle,
							$result['Obstacle']['title'],
							$obstacleValue,
							$character['name'],
							$characterValue
						));
						
						$characterValue = $this->getAttackValue($characterValue, array(
							StatMod::getLevelModifier($characterLevel)
						));
						$obstacleValue = $this->getAttackValue($obstacleValue, array(
							StatMod::getLevelModifier($level)
						));
						
						CakeLog::write('story', sprintf('Obstacle: %s =/= Character: %s', $obstacleValue, $characterValue));
						$success = $characterValue > $obstacleValue;
						if (!$success) {
							CakeLog::write('story', 'Character fails attempt');
							break 3;
						} else {
							CakeLog::write('story', 'Character succeeds attempt');
						}
					}
				}
			}
		}
		return $success;
	}
	
	private function getAttackValue($baseValue, $modifiers = array()) {
		$val = array(StatMod::rollDice(1,20));
		$val[] = StatMod::getModifier($baseValue);
		if (!empty($modifiers)) {
			if (is_numeric($modifiers)) {
				$val[] = $modifiers;
			} else {
				foreach ($modifiers as $modifier) {
					if (is_array($modifier)) {
						list($attr, $split, $shift) = $modifier + array(0, 1, 0);
						$modifier = StatMod::getModifier($attr, $split, $shift);
					}
					$val[] = $modifier;
				}
			}
		}
		CakeLog::write('story', implode(' + ', $val));
		return array_sum($val);
	}
	
	public function updateResetTurn($id) {
		return $this->updateAll(array(
			$this->escapeField('completed') => 'NULL',
			$this->escapeField('success') => 'NULL',
			$this->escapeField('started') => 'NULL',
			$this->escapeField('stopped') => 'NULL',
			$this->escapeField('minutes') => '0',
		), array(
			$this->escapeField('id') => $id,
		));
	}
}
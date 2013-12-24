<?php
class TurnTrackBehavior extends ModelBehavior {
	public $name = 'TimeTrack';
	
	private $_currentDateTime = null;
	private $_resetTurn = false;
	
	/**
	 * Returns the current date time of the game
	 *
	 * @return string date/time string
	 **/
	public function getTurnDateTime($Model) {
		return $this->_currentDateTime;
	}
	
	/**
	 * Advances a date/time by the amount of mintues per turn and then updates the internal date/time variable
	 **/
	public function advanceTurnDateTime($Model, $dateTime) {
		$newDate = date('Y-m-d H:i:s', strtotime(sprintf('%s + %d minutes', $dateTime, MINUTES_PER_TURN)));
		return $this->setTurnDateTime($newDate);
	}

	/**
	 * Sets the current date/time variable
	 **/
	public function setTurnDateTime($Model, $dateTime) {
		$this->_currentDateTime = $dateTime;
	}
	
	/**
	 * Performs the logic that happens every time a turn is advanced for a specific model ID
	 **/
	public function advanceTurn($Model, $id) {
		if (!empty($this->_resetTurn) && method_exists($Model, 'updateResetTurn')) {
			$Model->updateResetTurn($id);
		}
		if (!$Model->beforeAdvanceTurn($id)) {
			return false;
		}
		
		$dateTime = $this->getTurnDateTime($Model);

		if (empty($dateTime)) {
			throw new Exception('Cannot advance turn. Internal date has not been set yet');
		}
		
		CakeLog::write('story', sprintf('Advancing turn in %s ID#%d to %s', $Model->alias, $id, $dateTime));
		$Model->updateTimer($id);
		
		$Model->afterAdvanceTurn($id);
		return null;
	}
	
	public function beforeAdvanceTurn($Model, $id) {
		return true;
	}
	
	public function afterAdvanceTurn($Model, $id) {
		return true;
	}
	
	public function updateTimer($Model, $id) {
		return $Model->updateAll(array(
			$Model->escapeField('minutes') => sprintf('IF(%s IS NULL, %d, %s + %d)', 
				$Model->escapeField('minutes'), MINUTES_PER_TURN,
				$Model->escapeField('minutes'), MINUTES_PER_TURN),
		), array(
			$Model->escapeField($Model->primaryKey) => $id,
		));
	}
	
	public function setStarted($Model, $id, $value) {
		return $this->setDate($Model, $id, 'started', $value);
	}

	public function setCompleted($Model, $id, $value) {
		return $this->setDate($Model, $id, 'stopped', $value);
	}
	
	public function setDate($Model, $id, $field, $value) {
		return $Model->updateAll(array(
			$Model->escapeField($field) => date('"Y-m-d H:i:s"', strtotime($value)),
		), array(
			$Model->escapeField($Model->primaryKey) => $id
		));
	}
	
	public function resetTurn($val = true) {
		$this->_resetTurn = $val;
	}

}
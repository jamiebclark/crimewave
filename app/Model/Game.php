<?php
class Game extends AppModel {
	public $name = 'Game';
	public $actsAs = array('TurnTrack');
	public $hasMany = array('Job');
	public $belongsTo = array('World');
	public $hasAndBelongsToMany = array('Player');
	
	public function findTime($id) {
		$result = $this->read('datetime', $id);
		return $result[$this->alias]['datetime'];
	}
	
	public function beforeAdvanceTurn($id) {
		CakeLog::write('story', '----------------------------------------------');
		$result = $this->read(null, $id);
		$result = $result[$this->alias];
		$newDate = date('Y-m-d H:i:s', strtotime(sprintf('%s + %d minutes', $result['datetime'], MINUTES_PER_TURN)));
		$this->setTurnDateTime($newDate);

		if ($result['started'] < $result['datetime']) {
			$this->setStarted($id, 'started', $newDate);
		}
		return parent::beforeAdvanceTurn($id);
	}

	public function afterAdvanceTurn($id) {
		//Advances all the current turns
		$jobs = $this->Job->find('all', array(
			'link' => array('Game'),
			'conditions' => array(
				'Game.id' => $id,
				'OR' => array(
					'Job.started <=' => $this->getTurnDateTime(),
					'Job.started' => null,
				),
				'Job.stopped IS NULL',
			)
		));
		CakeLog::write('story', 'Found ' . count($jobs) . ' active jobs');
		foreach ($jobs as $job) {
			$this->Job->advanceTurn($job['Job']['id']);
		}
	}
	
	public function updateTimer($id) {
		$this->updateAll(array(
			$this->escapeField('datetime') => sprintf('DATE_ADD(%s, INTERVAL %d MINUTE)', $this->escapeField('datetime'), MINUTES_PER_TURN),
		), array(
			$this->escapeField('id') => $id
		));
		
		return parent::updateTimer($id);
	}
	
	public function updateResetTurn($id) {
		CakeLog::write('story', "Resetting Jobs in Game ID $id");
		$jobs = $this->Job->find('list', array(
			'conditions' => array('Job.game_id' => $id)
		));
		foreach ($jobs as $jobId => $jobTitle) {
			$this->Job->updateResetTurn($id);
		}
	}
}
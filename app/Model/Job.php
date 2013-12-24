<?php
class Job extends AppModel {
	public $name = 'Job';
	public $actsAs = array('TurnTrack');
	public $hasMany = array('Obstacle');
	public $belongsTo = array('Game', 'Location', 'JobTemplate');
	
	#region Getters and Setters
	//Sets the Job as having been completed
	public function setCompleted($id, $date = null) {
		$result = $this->read(null, $id);
		$result = $result[$this->alias];
		$gameTime = $this->Game->findTime($result['game_id']);
		if (empty($result['started']) || $gameTime < $result['started']) {
			return false;
		}
		return parent::setCompleted($id, $gameTime);
	}
	
	public function setSuccess($id, $success = 1) {
		return $this->updateAll(array(
			$this->escapeField('success') => $success,
		), array(
			$this->escapeField($this->primaryKey) => $id
		));
	}
	#endregion
	
	public function advanceTurn($id) {
		$result = $this->read(null, $id);
		$result = $result[$this->alias];

		if (!empty($result['stopped'])) {	//Job has finished already
			return null;
		}
		
		parent::advanceTurn($id);

		if (empty($result['started'])) {
			$this->setStarted($id, $this->getTurnDateTime());
		}
		if ($result['success'] !== 0)  {
			$obstacles = $this->findNextObstacles($id);

			if (!empty($obstacles)) {
				$obstacle = $obstacles[0];
				if (!$this->Obstacle->advanceTurn($obstacle['Obstacle']['id']) && $obstacle['Obstacle']['is_critical']) {
					//An obstacle critically fails, enters the failed state
					CakeLog::write('story', "Obstacle {$obstacle['Obstacle']['id']} has critically failed. Job has failed");
					return $this->setSuccess($id, 0);
				} else if (!empty($obstacle[1])) {
					//TODO: Check for Random encounters:
					CakeLog::write('story', sprintf('Job has been going on for %d minutes', $result['minutes']));
					CakeLog::write('story', "Job will continue. Check for random encounters");
					return true;
				}
			}
			
			//True if there are no obstacles found, or no next obstacle
			CakeLog::write('story', 'No more obstacles found. Success!');
			$this->setSuccess($id, 1);
			return $this->setCompleted($id);
			
		} else {
			CakeLog::write('story', "Job $id is in failure state");
			return true;
		}

	}
	
	/**
	 * Finds the current and next obstacle
	 **/
	private function findNextObstacles($id) {
		$result = $this->Obstacle->find('all', array(
			'conditions' => array(
				'Obstacle.job_id' => $id,
				'Obstacle.completed' => null,
			),
			'order' => array('Obstacle.order' => 'ASC'),
			'limit' => 2,
		));
		if (!empty($result)) {
			if (empty($result['Obstacle']['started'])) {
				$this->Obstacle->setStarted($id, $this->getTurnDateTime());
			}
		}
		return $result;
	}
	
	public function updateResetTurn($id) {
		$this->updateAll(array(
			$this->escapeField('success') => 'NULL',
			$this->escapeField('stopped') => 'NULL',
			$this->escapeField('minutes') => '0',
		), array(
			$this->escapeField('id') => $id,
		));
		
		return $this->Obstacle->updateAll(array(
			'Obstacle.completed' => 'NULL',
			'Obstacle.success' => 'NULL',
			'Obstacle.started' => 'NULL',
			'Obstacle.stopped' => 'NULL',
		), array(
			'Obstacle.job_id' => $id,
		));
	}
}
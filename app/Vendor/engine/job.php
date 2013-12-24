<?php
class World {
	$jobs = array();
	
	$stats = array();
}

class Job {
	public $obstacles = array();
	public $World;
	
	public __construct($World) {
		$this->World = $World;
	}
	
	public addObstacle($Obstacle) {
		$this->obstacles[] = new Obstacle($this);
	}
	
	public function commit(Team $team) {
		//Get all Obstacles
		
		//Loop through Obstacles
		foreach ($this->obstacles as $Obstacle):
			//Assign Criminal to Obstacle
			//Check for Success
			if ($Obstacle->check()) {	//If Success:
				$this->commitSuccess();
			} else {					//If Failed:
				//If Critical fail Job
				if ($Obstacle->isCritical) {
					$this->commitFail();
					break;
				}
			}
		endforeach;
		//End Loop
	}
}

class Obstacle {
	public $Job;
	public $Criminal;
	
	public $difficulty = 50;
	
	public $isCritical = false;
	
	public $onSuccess = array();
	public $onFail = array();
	
	public __construct($Job, $Crinimal) {
		$this->Job = $Job;
		$this->Criminal = $Criminal;
	}
	
	public function check($Criminal) {
		
	}
}

class Team {
	public $criminals = array();
}

class Criminal {
	public $attributes = array();
	public $stats = array();
}




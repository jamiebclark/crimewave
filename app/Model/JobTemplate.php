<?php
/**
 * Job Template Model
 *
 **/
class JobTemplate extends AppModel {
	public $name = 'JobTemplate';
	public $hasMany = array('Job', 'ObstacleTemplate');
	public $hasAndBelongsToMany = array('LocationType');
}
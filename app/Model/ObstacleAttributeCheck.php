<?php
class ObstacleAttributeCheck extends AppModel {
	public $name = 'ObstacleAttributeCheck';
	public $belongsTo = array('Obstacle', 'Attribute');
}
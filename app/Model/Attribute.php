<?php
class Attribute extends AppModel {
	public $name = 'Attribute';
	
	public $hasMany = array('ObstacleAttributeCheck');
	public $belongsTo = array('World');
	public $hasAndBelongsToMany = array(
		'CharacterType',
		'Obstacle' => array(
			'joinTable' => 'obstacle_attribute_checks',
		)
	);
}
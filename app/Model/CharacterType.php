<?php
class CharacterType extends AppModel {
	public $name = 'CharacterType';
	public $actsAs = array(
		'Tree',
		'Layout.SelectList', 
		'Layout.BlankDelete' => array('and' => 'title')
	);
	
	public $hasMany = array('Character');
	public $belongsTo = array('World');
	public $hasAndBelongsToMany = array('Attribute', 'Obstacle', 'ObstacleTemplate', 'Job');
	
	public $order = array('CharacterType.lft' => 'ASC');	
}
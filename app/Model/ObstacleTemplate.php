<?php
class ObstacleTemplate extends AppModel {
	public $name = 'ObstacleTemplate';
	public $actsAs = array('Layout.FieldOrder' => array(
		'orderField' => 'order',
		'subKeyFields' => array('job_template_id')
	));
	public $belongsTo = array('JobTemplate');
	public $hasAndBelongsToMany = array('CharacterType');
}
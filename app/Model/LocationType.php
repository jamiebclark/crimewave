<?php
class LocationType extends AppModel {
	public $name = 'LocationType';
	public $actsAs = array(
		'Tree', 
		'Layout.SelectList', 
		'Layout.BlankDelete' => array('and' => 'title')
	);
	
	public $hasMany = array('Location');
	public $belongsTo = array('World');
	public $hasAndBelongsToMany = array('Job', 'JobTemplate');
	
	public $order = array('LocationType.lft' => 'ASC');
}
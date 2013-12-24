<?php
class Location extends AppModel {
	public $name = 'Location';
	public $hasMany = array(
		'SafeHouse', 
		'Job'
	);
	public $belongsTo = array(
		'World',
		'LocationType',
	);
}
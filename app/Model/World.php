<?php
class World extends AppModel {
	public $name = 'World';
	public $actsAs = array('Tree');
	
	public $hasMany = array(
		'Game',				//The individual instances of the game being played
		'Location',
		
		//The stats that make this world unique
		'LocationType',
		'CharacterType',
		'Attribute',
	);
}
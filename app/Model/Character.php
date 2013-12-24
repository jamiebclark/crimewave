<?php
class Character extends AppModel {
	public $name = 'Character';
	
	public $hasMany = array(
		'CharacterAttribute',
	);
	
	public $hasAndBelongsToMany = array(
		'Attribute' => array(
			'joinTable' => 'character_attributes',
		),
	);
	public $belongsTo = array('Game', 'CharacterType');
	
	public function beforeSave($options = array()) {
		$data =& $this->getData();
		if (isset($data['first_name']) && isset($data['last_name'])) {
			$data['name'] = trim("{$data['first_name']} {$data['last_name']}");
		}
		return parent::beforeSave($options);
	}
}
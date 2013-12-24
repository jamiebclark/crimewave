<?php
class User extends AppModel {
	public $name = 'User';
	public $hasAndBelongsToMany = array('UserRole', 'Game');
	
	public $displayField = 'email';
	
	public $validate = array(
		'email' => array(
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'Sorry, this email address already exists in our system',
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please enter an email address',
			),
			'email' => array(
				'rule' => 'email',
				'message' => 'Please enter a valid email address',
			)
		),
		'password' => array(
			'noteEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please enter a password',
				'on' => 'create',
			),
			'passwordMatch' => array(
				'rule' => array('passwordMatch'),
				'message' => 'Please make sure your passwords match exactly',
			)
		)
	);

	#region Validation
	public function passwordMatch($field = array()) {
		$matchField = 'password_match';
		if (!isset($this->data[$this->alias][$matchField])) {
			return true;
		} else {
			if ($field['password'] == $this->data[$this->alias][$matchField]) {
				return true;
			} else {
				$this->invalidate($matchField, '');
				return false;
			}
		}
	}
	#endregion
	
	public function beforeSave($options = array()) {
		$data =& $this->getData();
		if (!$this->id && isset($data['password'])) {
			$data['password'] = Security::hash($data['password'], null, true);
		}
		return parent::beforeSave($options);
	}
}
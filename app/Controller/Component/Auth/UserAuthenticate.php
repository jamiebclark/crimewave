<?php
App::uses('BasicAuthenticate', 'Controller/Component/Auth');

class UserAuthenticate extends BasicAuthenticate {
	public function __construct(ComponentCollection $collection, $settings) {
		$settings = array_merge(array(
			'userModel' => 'User',
			'fields' => array(
				'username' => 'email',
				'password' => 'password',
			),
			'contain' => array('UserRole'),
			'realm' => 'localhost/crimewave',	//Remove this once it's set to the main server
		), $settings);
		return parent::__construct($collection, $settings);
	}
}
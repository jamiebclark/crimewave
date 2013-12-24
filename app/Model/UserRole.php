<?php
class UserRole extends AppModel {
	public $name = 'UserRole';
	public $actsAs = array('Tree', 'Layout.SelectList');
	public $hasAndBelongsToMany = array('User');
}
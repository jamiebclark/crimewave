<?php
class Player extends AppModel {
	public $name = 'Player';
	public $hasAndBelongsToMany = array('Game');
}
<?php
echo $this->Form->create();
echo $this->FormLayout->inputs(array(
	'id',
	'email' => array('type' => 'email'),
	'password' => array('type' => 'password'),
));
$View = $this;
echo $this->FormLayout->inputList(function($count) use ($View) {
	$prefix = "UserRole.$count";
	$out = $View->Form->input("$prefix.id", array(
		'options' => $View->viewVars['userRoles'],
		'class' => 'select-collapse',
		'label' => false,
	));
	return $out;
}, array('model' => 'UserRole'));
echo $this->FormLayout->end('Update');
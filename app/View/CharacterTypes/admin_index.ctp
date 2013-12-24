<?php
echo $this->Layout->defaultHeader();
echo $this->CollapseList->output($characterTypes, array(
	'actionMenu' => array(array(
		'edit' => array('class' => 'ajax-modal'),
		'add' => array('class' => 'ajax-modal'),
		'delete',
	))
));

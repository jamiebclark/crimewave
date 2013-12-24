<?php
echo $this->Layout->defaultHeader();
echo $this->CollapseList->output($locationTypes, array(
	'actionMenu' => array(array(
		'edit' => array('class' => 'ajax-modal'),
		'add' => array('class' => 'ajax-modal'),
	))
));

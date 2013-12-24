<?php
echo $this->Layout->defaultHeader($world['World']['id'], null, array(
	'title' => $world['World']['title'],
));
?>
<h2>Character Types</h2>
<?php
echo $this->Layout->headerMenu(array(array(
	'Add Character Type', 
	array('controller' => 'character_types', 'action' => 'add', $world['World']['id']),
	array('class' => 'ajax-modal')
)));
echo $this->CollapseList->output($characterTypes, array(
	'model' => 'CharacterType',
	'actionMenu' => array(array(
		'edit' => array('class' => 'ajax-modal'),
		'add' => array('class' => 'ajax-modal'),
	))
));
?>
<h2>Location Types</h2>
<?php
echo $this->Layout->headerMenu(array(array(
	'Add Location Type', 
	array('controller' => 'location_types', 'action' => 'add', $world['World']['id']),
	array('class' => 'ajax-modal')
)));
echo $this->CollapseList->output($locationTypes, array(
	'model' => 'LocationType',
	'actionMenu' => array(array(
		'edit' => array('class' => 'ajax-modal'),
		'add' => array('class' => 'ajax-modal'),
	))
));
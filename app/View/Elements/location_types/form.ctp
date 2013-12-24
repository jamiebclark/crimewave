<?php
echo $this->Form->create();
echo $this->Form->inputs(array(
	'id',
	'world_id' => array('type' => 'hidden'),
	'parent_id' => array('class' => 'select-collapse'),
	'title',
));
echo $this->FormLayout->end('Update');
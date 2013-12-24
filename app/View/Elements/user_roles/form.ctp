<?php
echo $this->Form->create();
echo $this->Form->hidden('UserType.id');
echo $this->Form->inputs(array(
	'fieldset' => false,
	'parent_id' => array('class' => 'select-collapse'),
	'title',
));
echo $this->FormLayout->end('Update');
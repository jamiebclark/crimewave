<h2>Sign in</h2>
<?php
echo $this->Form->create();
echo $this->FormLayout->inputs(array(
	'email' => array('type' => 'email'),
	'password' => array('type' => 'password'),
));
echo $this->FormLayout->end('Sign in');
<?php
$this->extend('Layout.html');
if (!$this->request->is('ajax')):
$this->start('header');
if ($this->Session->check('Auth.User')):
	echo $this->Layout->navBar(array(
		$this->ModelView->link($this->Session->read('Auth.User')),
		$this->Html->link('Log out', array('controller' => 'users', 'action' => 'logout', 'admin' => false))
	));
else:
	echo $this->Layout->navBar(array(
		$this->Html->link('Log in', array('controller' => 'users', 'action' => 'login', 'admin' => false))
	));
endif;

if (!empty($worldId)) {
	$worldUrl = array('admin' => true, $worldId);
	echo $this->Layout->navBar(array(
		array('Attributes', array('controller' => 'attributes') + $worldUrl),
		array('Character Types', array('controller' => 'character_types') + $worldUrl),
		array('Location Types', array('controller' => 'location_types') + $worldUrl),
		array('Job Templates', array('controller' => 'job_templates') + $worldUrl),
	));
}
if ($isAdmin) {
	$userUrl = array('admin' => true, 'action' => 'index');
	echo $this->Layout->navBar(array(
		array('Worlds', array('controller' => 'worlds') + $userUrl),
		array('Games', array('controller' => 'games') + $userUrl),
		array('Users', array('controller' => 'users') + $userUrl),
	));
}
$this->end();
endif;

echo $this->fetch('content');
?>
<div id="footer">

</div>
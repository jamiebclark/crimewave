<?php
echo $this->Layout->defaultHeader();
echo $this->CollapseList->output($userRoles, array(
	'actionMenu' => array(array('view', 'edit', 'delete', 'add'), array('class' => 'ajax-modal'))
));
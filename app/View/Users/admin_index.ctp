<?php
echo $this->Layout->defaultHeader();
foreach ($users as $user) {
	$this->Table->cells(array(
		array(
			$this->ModelView->link($user),
			'User',
		),
		array(
			$this->Calendar->niceShort($user['User']['created']),
			'Created',
			'created',
		),
		array(
			$this->ModelView->actionMenu(array('view', 'edit', 'delete'), $user['User']),
			'Actions',
		),
	), true);
}
echo $this->Table->output(array(
	'paginate' => true,
));
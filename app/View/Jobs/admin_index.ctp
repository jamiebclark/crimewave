<?php
echo $this->Layout->defaultHeader();
foreach ($jobs as $job) :
	$this->Table->cells(array(
		array(
			$this->ModelView->link($job),
			'Job',
		),
		array(
			$this->ModelView->link($job['Game'], array('model' => 'Game')),
			'Game',
		),
		array(
			$this->Layout->actionMenu(array('view', 'edit', 'delete'), $job['Job'])
		),
	), true);
endforeach;
echo $this->Table->output(array(
	'paginate' => true,
));
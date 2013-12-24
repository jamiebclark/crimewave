<?php
echo $this->Layout->defaultHeader();
foreach ($jobTemplates as $jobTemplate) {
	$this->Table->cells(array(
		array($this->ModelView->link($jobTemplate), 'Template'),
		array($this->ModelView->actionMenu(array('view', 'edit', 'delete'), $jobTemplate), 'Actions')
	), true);
}
echo $this->Table->output(array(
	'paginate' => true,
));
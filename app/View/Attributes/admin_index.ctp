<?php
echo $this->Layout->defaultHeader();
foreach ($attributes as $attribute) {
	$this->Table->cells(array(
		array(
			$this->ModelView->link($attribute),
			'Attribute',
		),
		array(
			$this->ModelView->actionMenu(array('view', 'edit', 'delete'), $attribute['Attribute']),
			'Actions',
		)
	), true);
}
echo $this->Table->output(array(
	'paginate' => true,
));
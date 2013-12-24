<?php
echo $this->Layout->defaultHeader();
foreach ($worlds as $world) {
	$this->Table->cells(array(
		array($this->ModelView->link($world)),
	), true);
}
echo $this->Table->output(array('paginate' => true));
<?php
echo $this->Layout->defaultHeader();

echo $this->Form->create();
echo $this->Form->hidden('id');
echo $this->Form->hidden('world_id');

$View = $this;
echo $this->Form->inputs(array(
	'title',
	'LocationType.LocationType' => array(
		'select' => 'multiple',
		'label' => 'Location Type',
		'helpBlock' => 'Limit this template to only be displayed in specific location types',
	),
	'fieldset' => false,
));
?>
<fieldset>
	<legend>Obstacles</legend>
	<p>What needs to be overcome before this can be listed as a success?</p>
	<?php
	echo $this->FormLayout->inputList(function($count) use ($View) {
		$prefix = "ObstacleTemplate.$count";
		$output = $View->Form->hidden("$prefix.id");
		$output .= $View->FormLayout->inputRow(array(
			"$prefix.order" => array('type' => 'number', 'default' => ($count + 1), 'span' => 2),
			"$prefix.title",
			"$prefix.chance_to_appear" => array('default' => 1),
			"$prefix.CharacterType.CharacterType" => array(
				'select' => 'multiple',
			)
		));
		return $output;
	}, array('model' => 'Obstacle'));
	?>
</fieldset>
<?php
echo $this->FormLayout->end('Update');

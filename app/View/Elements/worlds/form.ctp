<?php
$View = $this;

echo $this->Form->create();
echo $this->Form->hidden('id');
?>
<div class="row-fluid">
	<div class="span6">
	<h3>World Information</h3>
	<?php
		echo $this->FormLayout->inputs(array(
			'title' => array('class' => 'input-block-level'),
			'description' => array('class' => 'input-block-level'),
			'start' => array(
				'type' => 'datetime',
				'helpBlock' => 'The date and time the game world should start counting',
			),
		));
	?>
	<h4>Location Types</h4>
	<?php
		echo $this->FormLayout->inputList(function($count) use ($View, $locationTypes) {
			$prefix = "LocationType.$count";
			$out = $View->Form->hidden("$prefix.id");
			$out .= $View->FormLayout->inputRow(array(
				"$prefix.parent_id" => array(
					'options' => $locationTypes,
					'class' => 'select-collapse',
				),
				"$prefix.title",
			));
			return $out;
		}, array('model' => 'LocationType'));
	?>
	
	<h4>Character Types</h4>
	<?php
		echo $this->FormLayout->inputList(function($count) use ($View, $characterTypes) {
			$prefix = "CharacterType.$count";
			$out = $View->Form->hidden("$prefix.id");
			$out .= $View->FormLayout->inputRow(array(
				"$prefix.parent_id" => array(
					'options' => $characterTypes,
					'class' => 'select-collapse',
				),
				"$prefix.title",
			));
			return $out;
		}, array('model' => 'CharacterType'));

	?>
	</div>
	<div class="span6">
		<h3>Character Stats</h3>
		<p class="note">What statistics should be tracked about your characters?</p>
		<h4>Attributes</h4>
	<?php
		echo $this->FormLayout->inputList(function ($count) use ($View) {
			$prefix = "Attribute.$count";
			$out = $View->Form->hidden("$prefix.id");
			$out .= $View->FormLayout->inputRow(array(
				"$prefix.title" => array(
					'span' => 4,
				),
				"$prefix.min" => array(
					'span' => 2,
					'type' => 'number',
					'default' => 0,
				),
				"$prefix.max" => array(
					'span' => 2,
					'type' => 'number',
					'default' => 100,
				),
				"$prefix.alignment" => array(
					'options' => array(
						'' => 'Both',
						1 => 'Good',
						0 => 'Evil',
					)
				)
			), array('placeholder' => true));
			return $out;
		}, array('model' => 'Attribute'));
		?>
	</div>
</div>
<?php
echo $this->FormLayout->end('Update');
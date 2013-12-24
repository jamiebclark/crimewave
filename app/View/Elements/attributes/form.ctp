<?php
echo $this->Form->create();
echo $this->Form->hidden('id');
?>
<div class="form-horizontal">
	<?php
	echo $this->Form->inputs(array(
		'title',
		'min' => array('label' => 'Min Value'),
		'max' => array('label' => 'Max Value'),
		'default' => array('label' => 'Default Value'),
		'fieldset' => false,
	//	'alignment',
	));
	?>
</div>

<fieldset>
	<legend>Character Types</legend>
	<p>Should this attribute only be for a certain character type?</p>
	<?php
	$View = $this;
	echo $this->FormLayout->inputList(function($count) use ($View, $characterTypes) {
		$prefix = "CharacterType.$count";
		$out = $View->Form->hidden("$prefix.id");
		$out .= $View->Form->input("$prefix.character_type_id", array(
			'options' => $characterTypes,
			'class' => 'select-collapse',
			'label' => false,
		));
		return $out;
	}, array('model' => 'CharacterType'));
	?>
</fieldset>
<?php
echo $this->FormLayout->end('Update');
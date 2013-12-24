<style type="text/css">
#logview {
	max-height: 300px;
	overflow-y: auto;
}

</style>
<h1>Game View</h1>
<pre id="logview">
<?php echo implode("\n", $log); ?>
</pre>

<?php $this->Asset->blockStart(); ?>
$(document).ready(function() {
	var $logBox = $('#logview');
	$logBox.prop('scrollTop', $logBox.prop('scrollHeight'));
});
<?php $this->Asset->blockEnd(); ?>
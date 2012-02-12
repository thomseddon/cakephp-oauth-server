
<script type="text/javascript">
	if (top != self) {
		window.document.write("<div style='background:black; opacity:0.5; filter: alpha (opacity = 50); position: absolute; top:0px; left: 0px;"
		+ "width: 9999px; height: 9999px; zindex: 1000001' onClick='top.location.href=window.location.href'></div>");
	}
</script>


<?php
	echo $this->Form->create('Authorize');

	foreach ($OAuthParams as $key => $value) {
		echo $this->Form->hidden(h($key), array('value' => h($value)));
	}
?>

Do you authorize the app to do its thing?

<?php
	echo $this->Form->submit('Yep', array('name' => 'accept'));
	echo $this->Form->submit('Nope', array('name' => 'accept'));
	echo $this->Form->end();
?>

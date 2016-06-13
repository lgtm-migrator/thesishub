<?php
$controller = $this->context;

$this->beginContent($controller->module->mainLayout);
	echo '<div class="container">';
	echo $content;
	echo '</div>';
$this->endContent();

?>

<?php 
$controller = $this->context;

$this->beginContent($controller->module->mainLayout);
	echo $content;
$this->endContent();

?>
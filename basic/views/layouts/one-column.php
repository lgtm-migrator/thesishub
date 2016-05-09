<?php $this->beginContent('@app/views/layouts/main.php'); ?>
	
	<?php echo $content ?>
	<div ng-view></div>
	
<?php $this->endContent();
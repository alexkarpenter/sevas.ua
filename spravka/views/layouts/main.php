<?php 
/* @var $this Controller */ 
Yii::app()->clientScript->registerCssFile('/css/sprav.css'); 
?>
<?php $this->beginContent('common.views.layouts.main'); ?>
	<?php echo $content;?>
<?php $this->endContent(); ?>

<?php 
/* @var $this SpravController */
Yii::app()->clientScript->registerCssFile('/css/sprav.css'); 
Yii::app()->clientScript->registerCssFile('/css/screen.css'); 
?>
<?php $this->beginContent('common.themes.'.Yii::app()->theme->name.'.views.layouts.main'); ?>
	<strong class="heading"><?=$this->pageHeading?></strong>

	<?php echo $content;?>
<?php $this->endContent(); ?>

<?php /* @var $this Controller */ ?>
<?php $this->beginContent('common.themes.'.Yii::app()->theme-name.'.views.layouts.main'); ?>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<?php $cs->registerCssFile($asset.'/css/file.css');?>
	<?php echo $content;?>
<?php $this->endContent(); ?>

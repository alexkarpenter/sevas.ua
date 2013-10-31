<?php /* @var $this Controller */ ?>
<?php $this->beginContent(Yii::app()->params['appId'].'.themes.'.Yii::app()->theme->name.'.views.layouts.main'); ?>
	<?php echo $content;?>
<?php $this->endContent(); ?>

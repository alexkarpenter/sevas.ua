<?php /* @var $this Controller */ ?>
<?php $this->beginContent('common.views.layouts.main'); ?>
<div id="content">
	<?php echo $content;?>
</div><!-- content -->
<div id="aside">
	<?php $this->beginWidget('zii.widgets.CPortlet'); ?>
    ...insert content here...
	<?php $this->endWidget(); ?>
</div>
<?php $this->endContent(); ?>

<?php 
/* @var $this SpravController */
Yii::app()->clientScript->registerCssFile('/css/sprav.css');
Yii::app()->clientScript->registerCssFile('/css/screen.css'); 
?>
<?php $this->beginContent('common.themes.'.Yii::app()->theme->name.'.views.layouts.main'); ?>
<div id="content">
	<strong class="heading"><?=$this->pageHeading?></strong>

	<? $this->renderPartial('//sprav/_searchline'); ?>
	
	<?php 
	if (count($this->breadcrumbs) > 0) 
		$this->widget('zii.widgets.CBreadcrumbs', array(
			'homeLink' => CHtml::link('Справочник', '/'),
			'links' => $this->breadcrumbs,
			'separator' => '&nbsp;&gt;&gt;&nbsp;',
			'htmlOptions' => array('class' => 'breadcrumbs gap-before gap-after'),
		));
	?>

	<?php echo $content;?>
	
	<div class="block">
		<h3>команды</h3>
		<?php $this->widget('zii.widgets.CMenu', array(
                                'items' => $this->menu,
                                'htmlOptions' => array(
                                        'class' => 'navigation',
                                ),
		)); ?>
	</div>
	
</div><!-- content -->
<div id="aside">
	<?php $this->beginWidget('zii.widgets.CPortlet'); ?>
	
<div class="block">
	<h3>Новое в справочнике</h3>
                    	
	<? $this->widget('OrgListWidget', array()); ?>
                    	
	<div class="more">
	<br class="c">
	</div>
</div>
                    
<div class="block">
 
	<h3>Статистика справочника</h3>
						
	<? $this->widget('OrgStatWidget', array()); ?>
		
</div>

	<?php $this->endWidget(); ?>

</div>
<?php $this->endContent(); ?>

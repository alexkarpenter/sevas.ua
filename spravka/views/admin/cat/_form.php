<?php
/* @var $this CatController */
/* @var $model Category */
/* @var $form SActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('SActiveForm', array(
	'id'=>'category-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array( 'enctype' => 'multipart/form-data' ),
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'name',array('size' => 60, 'maxlength'=>256)); ?>

	<?php echo $form->textAreaRow($model,'descr',array('rows'=>6, 'cols'=>50,)); ?>

	<?php echo $form->textFieldRow($model,'path',array('size' => 60, 'maxlength'=>256)); ?>

	<?php echo $form->textFieldRow($model,'pathfull',array('size' => 60, 'maxlength'=>256, 'readonly' => 'readonly')); ?>

	<?php //echo $form->textFieldRow($model,'weight',array('size' => 60, )); ?>

	<? echo $form->formRowStart($model, 'parent'); ?>
	<?
	$cs = Category::model()->sortedRoots()->findAll();
	$cs = CHtml::listData($cs, 'id', 'deepName');
	
	echo $form->dropDownList($model, 'idcatparent', CMap::mergeArray(array(''=>'-'),$cs), array('class' => 'span5'));
	echo $form->formRowEnd($model, 'parent');
	?>
	
	<?php echo $form->fileFieldRow($model, 'imgFile'); ?>
	<?
	if ($img = $model->imgBehavior->getFileUrl())
		echo CHtml::image($img); 
	?>
	
	<?php echo $form->textFieldRow($model,'created_at', array('readonly' => 'readonly')); ?>
	
	<?php echo $form->textFieldRow($model,'updated_at', array('readonly' => 'readonly')); ?>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
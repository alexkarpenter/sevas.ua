<?php
/* @var $this OrgController */
/* @var $o Organization */

$this->breadcrumbs=array(
	'Organizations'=>array('index'),
	$o->name=>array('view','id'=>$o->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Update Organization', 'url'=>array('update', 'id'=>$o->id)),
);
?>

<h1>Изменение организации <?php echo $o->id; ?></h1>

<div class="form">

<?php $form=$this->beginWidget('SActiveForm', array(
	'id'=>'organization-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($o); ?>
	
	<?php echo $form->textFieldRow($o,'name',array('size'=>60,'maxlength'=>300)); ?>

	<?php echo $form->textFieldRow($o, 'name_h1',array('size'=>60,'maxlength'=>300)); ?>

	<label>images</label>
	<?
	$this->widget('ext.attachment.CAttachmentWidget', array('model' => $o, 'attachId' => 'attachImages')); 
	?>

	<br><br>
	<label>main image</label>
	<?
	$this->widget('ext.attachment.CAttachmentWidget', array('model' => $o, 'attachId' => 'attachImage')); 
	?>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($o->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div>
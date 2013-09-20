<h1>Создание новости</h1>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'News-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row">
		<?php echo $form->labelEx($news_form,'name'); ?>
		<?php echo $form->textField($news_form,'name', array('style'=>'width:500px')); ?>
		<?php echo $form->error($news_form,'name'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($news_form,'title'); ?>
		<?php echo $form->textField($news_form,'title', array('style'=>'width:500px')); ?>
		<?php echo $form->error($news_form,'title'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($news_form,'h1'); ?>
		<?php echo $form->textField($news_form,'h1', array('style'=>'width:500px')); ?>
		<?php echo $form->error($news_form,'h1'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($news_form,'keywords'); ?>
		<?php echo $form->textField($news_form,'keywords', array('style'=>'width:500px')); ?>
		<?php echo $form->error($news_form,'keywords'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($news_form,'name_category'); ?>
		<?php echo $form->dropDownList($news_form, 'name_category', Category::getAllCategory()); ?>
		<?php echo $form->error($news_form,'name_category'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($news_form,'text_description'); ?>
		<?php echo $form->textArea($news_form,'text_description', array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($news_form,'text_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($news_form,'text'); ?>
		<?php echo $form->textArea($news_form,'text', array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($news_form,'text'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($news_form,'fl_block'); ?>
		<?php echo $form->checkBox($news_form,'fl_block'); ?>
		<?php echo $form->error($news_form,'fl_block'); ?>
	</div>
	
<?php	$this->widget('ext.EFineUploader.EFineUploader', array(
		'action' => $this->createUrl('/fileUpload/foo'),
		'model' => $model,
		'attribute' => 'file',
	)); 
?>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Создать'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->

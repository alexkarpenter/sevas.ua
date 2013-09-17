<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'comment-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'action' => "/news/addcomment?url=$url"
)); ?>

	<p class="note">Поля с <span class="required">*</span> должны быть заполнены.</p>

	<?php echo $form->errorSummary($commentForm); ?>

	<div class="row">
		<?php echo $form->labelEx($commentForm,'comment'); ?>
		<?php echo $form->textArea($commentForm,'comment',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($commentForm,'comment'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Комментировать'); ?>
	</div>

<?php $this->endWidget(); ?>

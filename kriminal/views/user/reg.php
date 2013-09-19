<h1>Регистрация</h1>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'reg-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row">
		<?php echo $form->labelEx($RegForm,'login'); ?>
		<?php echo $form->textField($RegForm,'login'); ?>
		<?php echo $form->error($RegForm,'login'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($RegForm,'email'); ?>
		<?php echo $form->textField($RegForm,'email'); ?>
		<?php echo $form->error($RegForm,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($RegForm,'password'); ?>
		<?php echo $form->passwordField($RegForm,'password'); ?>
		<?php echo $form->error($RegForm,'password'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($RegForm,'password_repeat'); ?>
		<?php echo $form->passwordField($RegForm,'password_repeat'); ?>
		<?php echo $form->error($RegForm,'password_repeat'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Регистрация'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->

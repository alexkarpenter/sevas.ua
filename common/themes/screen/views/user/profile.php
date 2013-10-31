<?php
/**
 * User: Alex
 * Date: 14.10.13
 * Time: 21:16
 * @var $form CActiveForm
 * @var $model UserProfile
 * @var $modelUser User
 */
?>

<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'Profile-form',
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data',
        ),
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'action' => $this->createUrl('user/profile'),
    )); ?>

    <div class="row">
        <?php echo $form->labelEx($modelUser,'nickname'); ?>
        <?php echo $form->textField($modelUser,'nickname', array('style'=>'width:200px')); ?>
        <?php echo $form->error($modelUser,'nickname'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'firstname'); ?>
        <?php echo $form->textField($model,'firstname', array('style'=>'width:200px')); ?>
        <?php echo $form->error($model,'firstname'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'lastname'); ?>
        <?php echo $form->textField($model,'lastname', array('style'=>'width:200px')); ?>
        <?php echo $form->error($model,'lastname'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'sex'); ?>
        <?php echo $form->dropDownList($model, 'sex', UserProfile::getSex()); ?>
        <?php echo $form->error($model,'sex'); ?>
    </div>

    <?php
        if($YMD = UserProfile::intToYMD($model->birthday))
        {
            $Y = $YMD[0]; $M = $YMD[1]; $D = $YMD[2];
        }
    ?>

    <div class="row">
        <?php echo $form->labelEx($model,'birthday'); ?>
        <?php echo CHtml::dropDownList('UserProfile[listdate]', (isset($D))?$D:'', UserProfile::getAllDays(), array('empty' => 'День'));?>
        <?php echo CHtml::dropDownList('UserProfile[listmonth]', (isset($M))?$M:'', UserProfile::getAllMonth(), array('empty' => 'Месяц'));?>
        <?php echo CHtml::dropDownList('UserProfile[listyear]', (isset($Y))?$Y:'', UserProfile::getLastYears(), array('empty' => 'Год'));?>
        <?php echo $form->error($model,'birthday'); ?>
    </div>

    <?php if( $modelUser->getImageUrl() ) {; ?>
        <img src="<?php echo $modelUser->getImageUrl();  ?>"/>
    <?php } ?>

    <div class="row">
        <?php echo $form->labelEx($modelUser,'image'); ?>
        <?php echo $form->fileField($modelUser,'image'); ?>
        <?php echo $form->error($modelUser,'image'); ?>
    </div>

    <div class="row buttons">
            <?php echo CHtml::submitButton('Редактировать', array('id' => 'edit_profile_submit')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->
<?php
/**
 * User: Alex
 * Date: 02.10.13
 * Time: 15:43
 * @var $this NewsController
 * @var $form CActiveForm
 * @var $model News
 */

if($model->isNewRecord)
{
    $params = array();
    echo "<h1>Создание новости</h1>";
}else{
    $params = array('id'=>$model->id);
    echo "<h1>Редактирование новости $model->name</h1>";
}
?>

<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'News-form',

        'htmlOptions' => array(
            'enctype' => 'multipart/form-data',
        ),
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'action' => $this->createUrl('news/edit', $params),
    )); ?>

    <? CVarDumper::dump($model->getErrors(), 10, true);?>

    <p class="note">Поля со знаком <span class="required">*</span> обязательны для заполнения.</p>

    <div class="row" id="check_cat">
        <?= $form->labelEx($model, 'display_in_category'); ?>
        <? if(isset($model->id)){
            $this->renderPartial('_check_category', array( 'news_id' => $model->id) );
        }else{
            $this->renderPartial('_check_category');
        }?>

    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'title'); ?>
        <?php echo $form->textField($model,'title', array('style'=>'width:500px')); ?>
        <?php echo $form->error($model,'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'url'); ?>
        <?php echo $form->textField($model,'url', array('style'=>'width:500px')); ?>
        <?php echo $form->error($model,'url'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'name_h1'); ?>
        <?php echo $form->textField($model,'name_h1', array('style'=>'width:500px')); ?>
        <?php echo $form->error($model,'name_h1'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'name_bread'); ?>
        <?php echo $form->textField($model,'name_bread', array('style'=>'width:500px')); ?>
        <?php echo $form->error($model,'name_bread'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'name'); ?>
        <?php echo $form->textField($model,'name', array('style'=>'width:500px')); ?>
        <?php echo $form->error($model,'name'); ?>
    </div>

    <div class="row">
        <? echo $form->labelEx($model, 'image'); ?>
        <? $this->widget('common.extensions.attachment.CAttachmentWidget', array(
            'model' => $model,
            'attachId' => 'attachMainImage',
            'viewItem' => 'attachments_item',
        )); ?>
        <? echo $form->error($model, 'image'); ?>
        <div class="c"></div>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'meta_keywords'); ?>
        <?php echo $form->textArea($model,'meta_keywords', array('rows'=>2, 'cols'=>50)); ?>
        <?php echo $form->error($model,'meta_keywords'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'text_description'); ?>
        <?php echo $form->textArea($model,'text_description', array('rows'=>6, 'cols'=>50)); ?>
        <?php echo $form->error($model,'text_description'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'text'); ?>
        <?php echo $form->textArea($model,'text', array('rows'=>6, 'cols'=>50)); ?>
        <?php echo $form->error($model,'text'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'status'); ?>
        <?php echo $form->dropDownList($model,'status', NewsStatusEnum::$list); ?>
        <?php echo $form->error($model,'status'); ?>
    </div>

	<? if(!$model->isNewRecord){ ?>
    <div class="row">
        <?php echo $form->labelEx($model,'files'); ?>
        <? $this->widget('common.extensions.attachment.CAttachmentWidget', array(
            'model' => $model,
            'attachId' => 'attachFiles',
            'viewItem' => 'attachments_item_gallery',
            'fileMultiSelect' => true,
        )); ?>
        <?php echo $form->error($model,'files'); ?>
    </div>
	<? } ?>

    <div class="row buttons">
        <?
		echo CHtml::submitButton('Сохранить и закрыть');
        echo CHtml::submitButton('Сохранить и продолжить редактирование');
        ?>
    </div>

    <? $this->widget('ImperaviRedactorWidget', array(
        // The textarea selector
        //'selector' => '#'.CHtml::activeId($model, 'text'),
        'selector' => 'textarea',
        // Some options, see http://imperavi.com/redactor/docs/
        'options' => array(
            'buttons' => array('html', '|', 'formatting', '|', 'bold', 'italic', '|', 'link'),
            'lang' => 'ru',
            'fullpage' => false,
        ),
    )); ?>

    <?php $this->endWidget(); ?>
</div><!-- form -->
<script type="text/javascript">
	function addImageToRedactor(format, obj){
		var src = obj.parents(".file-slot-cell1").children("img").attr('src');
		var srcArray = src.split('/');
		var img_basename = srcArray[srcArray.length-1];

		if(format == 'original'){
			$('#News_text').redactor('insertHtml', '<img src="'+src+'" />');
		}

		$('#News_text').redactor('insertHtml', '<img src="/uploads/cache/'+format+'/news/<?=$model->id?>/'+img_basename+'" />');
	}
</script>
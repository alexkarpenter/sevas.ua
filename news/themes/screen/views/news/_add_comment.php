<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'comment-form',
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
    'action' => "/news/addcomment?url=$url"
)); ?>

<?php echo $form->errorSummary($commentForm); ?>
<h3><span>Ваш комментарий</span></h3>
<div class="row">
    <label class="textarea-wrap"><?php echo $form->textArea($commentForm,'comment',array('rows'=>6, 'cols'=>50)); ?></label>
    <?php echo $form->error($commentForm,'comment'); ?>
</div>
<div class="ch-row">
    <a id="comments-subscribe-link" href="?subscribe=true">Подписаться на новые комментарии</a>
</div><br class="c"/>
<div class="row">
    <span class="gray-btn">Отправить<?php echo CHtml::submitButton('Отправить'); ?></span>
</div>

<?php $this->endWidget(); ?>
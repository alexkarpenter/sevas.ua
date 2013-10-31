<?php
/**
 * User: Alex
 * Date: 11.10.13
 * Time: 8:22
 */UserController::getStateRButtons($data)
?>

    <h1>Просмотр пользователей</h1>

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'AddNewAnswer',
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>false,
    ),
    'action'=>$this->createUrl('user/list'),
)); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'afterAjaxUpdate' => 'reinstallDatePicker',
    'columns'=>array(
        'name',
        'email',
        array(
            'name'=>'state',
            'type'=>'raw',
            'value'=>'UserController::getStateRButtons($data)',
            'filter'=>array(0=>'Заблокирован',1=>'Активен', 2=>'Ожидает регистрации')
        ),
        array(
            'name'=>'register_date',
            'value'=>'($data->register_date != 0)? date("Y-m-d H:i:s", $data->register_date) : "дата не указана"',
            'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'=>$model,
                    'attribute'=>'register_date',
                    'language' => 'ru',
                    // 'i18nScriptFile' => 'jquery.ui.datepicker-ja.js',
                    'htmlOptions' => array(
                        'id' => 'datepicker_for_register_date',
                        'size' => '10',
                        'value' => '',
                    ),
                    'defaultOptions' => array(
                        'showOn' => 'focus',
                        'dateFormat' => 'yy/mm/dd',
                        'showOtherMonths' => true,
                        'selectOtherMonths' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'showButtonPanel' => true,
                    )
                ),
                true),
        ),
        array(
            'name'=>'last_visit_date',
            'value'=>'($data->last_visit_date != 0)? date("Y-m-d H:i:s", $data->last_visit_date) : "посещения не производилось"',
            'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'=>$model,
                    'attribute'=>'last_visit_date',
                    'language' => 'ru',
                    'htmlOptions' => array(
                        'id' => 'datepicker_for_last_visit_date',
                        'size' => '10',
                        'value' => '',
                    ),
                    'defaultOptions' => array(
                        'showOn' => 'focus',
                        'dateFormat' => 'yy/mm/dd',
                        'showOtherMonths' => true,
                        'selectOtherMonths' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'showButtonPanel' => true,
                    )
                ),
                true),
        ),
    ),
));
?>

<div class="row">
        <span class="gray-btn">Фильтрация<?php echo CHtml::submitButton('Отправить',array('class'=>'submitButton')); ?></span>
</div>

<?php $this->endWidget(); ?>
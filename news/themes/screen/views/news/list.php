<?php
/*
 * User: Alex
 * Date: 02.10.13
 * Time: 15:44
 */
?>

<h1>Просмотр новостей для редактирования</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
    'columns'=>array(
        'id',
        'name',
        'user.name',
        array(
            'name'=>'create_date',
            'value'=>'date("Y-m-d H:i:s", $data->create_date)',
        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{delete}{update}',
            'buttons'=>array(
                'delete' => array(
                    //'lable' => 'delete',
                    'url' => 'Yii::app()->createUrl("news/delete", array("id" =>$data->id))',
                    //'imageUrl'=>'/path/to/copy.gif',  // image URL of the button. If not set or false, a text link is used
                    //'options' => array('class'=>'copy'), // HTML options for the button
                ),
                'update' =>array(
                    'url' => 'Yii::app()->createUrl("news/edit", array("id" =>$data->id))',
                )
            )
        ),
    ),
));
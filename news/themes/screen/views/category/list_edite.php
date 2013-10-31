<h1>Просмотр разделов для редактирования</h1>
<div class="create"><a class="create_news" href="/category/createcategory">Создать новость</a></div>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
    'columns'=>array(
        'id',
        'name',
        'url',
        array(
            'class'=>'CButtonColumn',
            'template'=>'{delete}{update}',
            'buttons'=>array(
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("category/deletecategory", array("id" =>$data->id))',
                ),
                'update' =>array(
                    'url' => 'Yii::app()->createUrl("category/editecategory", array("id" =>$data->id))',
                )
            )
        ),
    ),
));
?>


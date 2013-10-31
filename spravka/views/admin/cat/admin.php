<?php
/* @var $this CatController */
/* @var $model Category */

$this->breadcrumbs=array(
	'Categories'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Список категорий', 'url'=>array('index')),
	array('label'=>'Создать категорию', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#category-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление категориями</h1>


<?php echo CHtml::link('Поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'category-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		array('name' => 'name', 'value' => '$data->deepname', 'type' => 'html'),
		'pathfull',
		array(
			'class'=>'CButtonColumn',
		),
		array(
			'header'=>'Порядок',
			'value' =>
			'CHtml::link("<i class=\"icon-arrow-up\"></i>", "javascript:if(!confirm(\"up?\")) return false;".CHtml::ajax(array("url"=>Yii::app()->controller->createUrl("cat/moveup", array("id"=>$data->id)), "complete"=>"function(){\$.fn.yiiGridView.update(\'category-grid\');}")), array("title"=>"вверх", "rel"=>"tooltip")).'.
			'CHtml::link("<i class=\"icon-arrow-down\"></i>", "javascript:if(!confirm(\"down?\")) return false;".CHtml::ajax(array("url"=>Yii::app()->controller->createUrl("cat/movedn", array("id"=>$data->id)), "complete"=>"function(){\$.fn.yiiGridView.update(\'category-grid\');}")), array("title"=>"вниз", "rel"=>"tooltip"))',
			'type' => 'raw',
		),
	),
)); ?>

<div class="block">
                        <h3>команды</h3>
                        <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => $this->menu,
                                'htmlOptions' => array(
                                        'class' => 'navigation',
                                ),
                        )); ?>
</div>

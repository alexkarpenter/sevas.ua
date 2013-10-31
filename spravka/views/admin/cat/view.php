<?php
/* @var $this CatController */
/* @var $model Category */

$this->breadcrumbs=array(
	'Categories'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Список категорий', 'url'=>array('index')),
	array('label'=>'Создать категорию', 'url'=>array('create')),
	array('label'=>'Изменение категории', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удаление категории', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Управление категориями', 'url'=>array('admin')),
);
?>

<?php $this->pageH1 = "Просмотр категории {$model->id}"; $this->printH1(); ?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'idcatparent',
		'name',
		'descr',
		'path',
		'pathfull',
		'level',
		'weight',
		'options',
		'root',
		'lft',
		'rgt',
		'created_at',
		'updated_at',
	),
)); ?>

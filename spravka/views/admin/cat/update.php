<?php
/* @var $this CatController */
/* @var $model Category */

$this->breadcrumbs=array(
	'Categories'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Список категорий', 'url'=>array('index')),
	array('label'=>'Создать категорию', 'url'=>array('create')),
	array('label'=>'Просмотр категории', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Управление категориями', 'url'=>array('admin')),
);
?>

<?php $this->pageH1 = "Обновление категории {$model->id}"; $this->printH1(); ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
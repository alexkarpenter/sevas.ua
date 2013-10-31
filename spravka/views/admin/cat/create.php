<?php
/* @var $this CatController */
/* @var $model Category */

$this->breadcrumbs=array(
	'Categories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Список категорий', 'url'=>array('index')),
	array('label'=>'Управление категориями', 'url'=>array('admin')),
);
?>

<?php $this->pageH1 = "Создать категорию"; $this->printH1(); ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
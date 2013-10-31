<?php
/* @var $this CatController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Categories',
);

$this->menu=array(
	array('label'=>'Создать категорию', 'url'=>array('create')),
	array('label'=>'Управление категориями', 'url'=>array('admin')),
);
?>

<?php $this->pageH1 = "Категории"; $this->printH1(); ?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

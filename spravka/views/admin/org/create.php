<?php
/* @var $this OrgController */
/* @var $o Organization */

$this->breadcrumbs=array(
	'Organizations'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Organization', 'url'=>array('index')),
	array('label'=>'Manage Organization', 'url'=>array('admin')),
);
?>
<?php 
$this->pageH1 = "Создание организации"; 
$this->printH1();
?>

<?php $this->renderPartial('_form', array('o'=>$o)); ?>
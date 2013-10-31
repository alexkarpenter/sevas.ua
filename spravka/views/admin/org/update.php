<?php
/* @var $this OrgController */
/* @var $o Organization */

$this->breadcrumbs=array(
	'Organizations'=>array('index'),
	$o->name=>array('view','id'=>$o->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Organization', 'url'=>array('index')),
	array('label'=>'Create Organization', 'url'=>array('create')),
	array('label'=>'View Organization', 'url'=>array('sprav/org', 'slug'=>$o->slug)),
	array('label'=>'Manage Organization', 'url'=>array('admin')),
);
?>

<?php $this->pageH1 = "Изменение организации {$o->id}"; $this->printH1(); ?>

<?php $this->renderPartial('_form', array('o'=>$o)); ?>
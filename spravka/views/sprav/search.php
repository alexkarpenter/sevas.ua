<?php
/* @var $this SpravController */

$this->addBreadcrumbs(array('Поиск'));
?>
    
<h1>Результаты по запросу '<?=Chtml::encode($query)?>'</h1>

<?
$this->widget('zii.widgets.CListView', array(
	'dataProvider' => $provider, 
	'itemView' => '_orgpreview',
	'ajaxUpdate' => false,
)); 
?>

<?
//     CVarDumper::dump($res, 10, true);
?>

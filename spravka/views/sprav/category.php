<?php
/* список организаций в категории */
/* @var $this SpravController */
/* @var $c Category */

$this->setPageTitle($c->name);

$this->addBreadcrumbs($c->getBreadcrumbsData(false));
?>

<h1><?=$c->name?></h1>

<?
$this->widget('zii.widgets.CListView', array(
	'dataProvider' => $provider,
	'itemView' => '_orgpreview',   // refers to the partial view named '_post'
	'template' => '{items} {summary} {sorter} {pager}',
	'ajaxUpdate' => false,
));
?>
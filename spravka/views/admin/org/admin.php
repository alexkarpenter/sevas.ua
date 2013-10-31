<?php
/* @var $this OrgController */
/* @var $o Organization */

$this->breadcrumbs=array(
	'Organizations'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Organization', 'url'=>array('index')),
	array('label'=>'Create Organization', 'url'=>array('create')),
	array('label'=>'Manage Categories', 'url'=>array('cat/admin')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#organization-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Организации</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$o,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'organization-grid',
	'dataProvider'=>$o->search(),
	'filter'=>$o,
	'columns'=>array(
		'id',
		'name',
		'name_h1',
		'slug',
		'address',
		'phone',
		/*
		'email',
		'site',
		'anonse',
		'descr',
		'imgs',
		'geocoder',
		'geoexact',
		'geolat',
		'geolon',
		'options',
		'created_at',
		'updated_at',
		'checked',
		'id_owner',
		'idcatprimary',
		'seo_title',
		'seo_keywords',
		'seo_description',
		'views',
		'image_id',
		*/
		array(
			'class'=>'CButtonColumn',
			'viewButtonUrl' => 'Yii::app()->createUrl("sprav/org", array("slug" => $data->slug))',
		),
	),
));

?>

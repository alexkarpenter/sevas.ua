<?php
/* @var $this OrgController */
/* @var $o Organization */

$this->breadcrumbs=array(
	'Organizations'=>array('index'),
	$o->name,
);

$this->menu=array(
	array('label'=>'List Organization', 'url'=>array('index')),
	array('label'=>'Create Organization', 'url'=>array('create')),
	array('label'=>'Update Organization', 'url'=>array('update', 'id'=>$o->id)),
	array('label'=>'Delete Organization', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$o->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Organization', 'url'=>array('admin')),
);
?>

<?php $this->pageH1 = $o->name_h1; $this->printH1(); ?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$o,
	'attributes'=>array(
		'address',
		'phone',
		'email',
		'site',
		'created_at',
		'updated_at',
		'views',
	),
)); ?>

<div class="content">
<?=$o->descr?>
</div>

<? if ($o->image): ?>
<div>
	<img src="<?=$o->image->path?>" alt="<?=$o->image->title?>" >
	<br>
	<label><?=$o->image->title?></label>
</div>
<? endif; ?>

<div>
	<?
	$opts = array('id' => 'orgmap', 'width' => '100%', 'zoom' => 13, 'onready' => 'addMark();');
	if ($o->geolat && $o->geolon)
		$opts['center'] = array($o->geolat, $o->geolon);
	else
		$opts['address'] = $o->address;
	$this->widget('MapWidget', $opts);
	?>
</div>
<script type="text/javascript">
<!--
function addMark() {
	var data = orgmap_data;
	
	var mark = new ymaps.Placemark( data.center, {balloonContentBody:<?=json_encode($o->name)?>}, { } );
	data.map.geoObjects.add(mark);
	mark.balloon.open();
}
//-->
</script>

<label>теги:</label>
<?
echo implode(', ', array_map(function($t){ return $t->name; }, $o->tags));
?>
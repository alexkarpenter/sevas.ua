<?php
/* @var $this OrgController */
/* @var $o Organization */

$cs = Yii::app()->clientScript;
$cs->registerPackage('jquery.ui');
// $cs->registerCssFile($cs->getCoreScriptUrl(). '/jui/css/base/jquery-ui.css');

$this->pageTitle = $o->seo_title ?: $o->name;

$this->addBreadcrumbs($o->getBreadcrumbsData());

$this->menu=array(
		array('label'=>'Update Organization', 'url'=>array('admin/org/update', 'id'=>$o->id)),
);

?>
<div class="org">

<h1><?=($o->name_h1 ?: $o->name)?></h1>

<div class="oprop oprop-rating">

	<? 
	$this->widget('CStarRatingX',
			array('value' => $o->rating, 'name' => "org_rating", 'minRating' => 0.5, 'maxRating' => 5, 'readOnly' => true,
			'ratingStepSize' => 0.5, 'starCount' => 5, ));
	?>
	&nbsp;&nbsp;<span class="text-mini"><a href="#reviews">Отзывов</a><span class="text-gray">&nbsp;(<?=$o->reviewsCount?>)</span></span>
</div>

<div class="frame-border">

	<div class="block-contact">

		<h3>Контактная информация</h3>
	
		<p class="oprop oprop-address">
			<span class="oprop-label">Адрес:</span>
			<?php echo CHtml::encode($o->address); ?>
		</p>

		<?php if (!empty($o->phone)): ?>
		<? foreach ($o->getPhones() as $ph): ?>
		<p class="oprop oprop-phone">
			<span class="oprop-label">Телефон:</span>
			<?=$ph?>
		</p>
		<? endforeach; ?>
		<? endif; ?>
		
		<? if ($o->email): ?>
		<p class="oprop oprop-email">
			<?=CHtml::link($o->email, $o->email);?>
		</p>
		<? endif; ?>
				
		<? if ($o->site): ?>
		<p class="oprop oprop-site">
			<?=CHtml::link($o->site, $o->site);?>
		</p>
		<? endif; ?>
				
	</div>
	
	<? 
	if ($o->regime) :
	$r = $o->getRegimeData();
	// todo: dinner and check empty 
	?>
	<div class="block-regime">
		
		<h3>Режим работы:</h3>
		
		<div class="block-regime-inner">
		<div class="org-regime">
		<? foreach ($r['days'] as $dcode => $d): ?>
			<span class="day-regime day-<?=$dcode?>">
				<span class="regime-day text-gray"><?=$d['label']?></span> 
				<? if (!empty($d['s'])): ?>
				<span class="regime-s"><?=$d['s']?></span> - <span class="regime-e"><?=$d['e']?></span>
					<? if (!empty($d['os'])): ?>
					<span class="regime-obed">(<?=$d['os'].' - '.$d['oe']?>)</span>
					<? endif; ?>
				<? else: ?>
				<span class="regime-s">Вых</span>
				<? endif; ?>
			</span><br>
		<? endforeach; ?>
		</div>
		</div>
		
	</div>
	<? endif; ?>
	
	<div class="clear"></div>
</div>

<div class="frame-margin gap-before gap-after">
<div id="tabs">
	  <ul>
	    <li><a href="#tabs-1">На карте</a></li>
	    <li><a href="#tabs-2">Описание</a></li>
	  </ul>
	  <div id="tabs-1">
			<?
			$opts = array('id' => 'orgmap', 'width' => '100%', 'height' => 300, 'zoom' => 13, 'onready' => 'addMark();');
			if ($o->geolat && $o->geolon)
				$opts['center'] = array($o->geolat, $o->geolon);
			else
				$opts['address'] = $o->address;
			$this->widget('MapWidget', $opts);
			?>
	  </div>
	  <div id="tabs-2">
			<div class="content">
			<?=$o->descr?>
			</div>
	  </div>
</div>
</div>

<script type="text/javascript">
$(function(){
	$('#tabs').tabs();
});
</script>

<?
$this->widget('IncluderWidget', array('view' => 'share-buttons')); 
?>

<?
if (count($o->files))
	$this->widget('ImageGalleryWidget', array('files' => $files, 'view' => 'imageGallerySmall')); 
?>

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

<!-- 
<label>теги:</label>
<?
echo implode(', ', array_map(function($t){ return $t->name; }, $o->tags));
?>
-->

<div class="clear gap2-before">
	<a name="reviews"></a>
<? 
Utils::debugLogin(true);

$this->widget('comment.widgets.CommentsWidget', array(
		'model' => $o, 'view' => 'reviewList',
));
?>
</div>

</div>

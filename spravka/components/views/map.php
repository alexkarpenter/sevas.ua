<?php
/* @var $this MapWidget */

$cs = Yii::app()->clientScript; 
$cs->registerCoreScript('jquery');
$cs->registerScriptFile('http://api-maps.yandex.ru/2.0-stable/?load='.$this->ymapsPackage.'&lang=ru-RU', CClientScript::POS_END);
$cs->registerScriptFile( Yii::app()->baseUrl.'/js/ymapsw.js' );

?>
<? echo CHtml::openTag('div', array('class'=>'map', 'id'=>$this->id, 
		'style' => implode(';', array($this->width ? "width:{$this->width}px" : '', $this->height ? "height:{$this->height}px" : '')) )) ?>
<? echo CHtml::closeTag('div'); ?>

<?
$mapId = $this->id; 
$mapOpts = $this->id.'_data';
$opts = array('id'=>$mapId, 'center'=>$this->center, 'zoom'=>$this->zoom, 'params'=>$this->scriptParams);
$optsopts = array('address', 'balloon', 'boundedBy');
foreach ($optsopts as $opt)
	if ($this->$opt) $opts[$opt] = $this->$opt;
if ($this->onready) $opts['onready'] = $this->onready; 
?>
<script>
var <?=$mapOpts?> = <?=CJavaScript::encode($opts)?>;
</script>
<?
$cs->registerScript($mapId, "$('#{$mapId}').ymapsw({$mapOpts});", CClientScript::POS_READY); 
?>
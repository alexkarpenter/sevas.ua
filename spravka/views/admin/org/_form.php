<?php
/* @var $this OrgController */
/* @var $o Organization */
/* @var $form SActiveForm */
$cs = Yii::app()->clientScript;
$cs->registerScriptFile('/js/knockout-2.3.0.js');
$cs->registerScriptFile('/js/knockout.mapping.js');
$cs->registerScriptFile('/js/jquery.maskedinput.min.js');
$cs->registerPackage('selectize');
?>

<div class="form">

<?php $form=$this->beginWidget('SActiveForm', array(
	'id'=>'organization-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($o); ?>

	<?php echo $form->textFieldRow($o,'name',array('size'=>60,'maxlength'=>300)); ?>

	<?php echo $form->textFieldRow($o, 'name_h1',array('size'=>60,'maxlength'=>300)); ?>

	<?php echo $form->textFieldRow($o,'slug',array('size'=>60,'maxlength'=>300)); ?>
	
	<?php echo $form->textFieldRow($o,'address',array('size'=>60,'maxlength'=>256, 'data-bind' => 'value:address, event: { change : geocode }')); ?>
	
	<? echo $form->label($o, 'geocoder', array('label' => 'расположение на карте', 'class'=>'inline')) ?>
	<? echo $form->dropDownList($o, 'geocoder', array(1=>'по адресу', 0=>'вручную', ), array('data-bind' => 'value:geocoder, event: { change : geocode }')); ?>
	<? echo CHtml::label('широта/долгота', 'Organization_geolat', array('class' => 'inline')); ?>
	<? echo $form->textField($o, 'geolat', array('readonly' => 'readonly', 'data-bind' => 'value:geolat')); ?>
	<? echo $form->textField($o, 'geolon', array('readonly' => 'readonly', 'data-bind' => 'value:geolon')); ?>
	<? echo $form->checkBox($o,'geoexact', array('data-bind' => 'checked:geoexact', 'title' => 'Точный результат геокодирования')); ?>
	<? $this->widget('MapWidget', array('id' =>'omap', 'width' => '100%', 'onready' => 'orgform.mapSetup()')); ?>
	
	<?php //echo $form->textFieldRow($o,'phone',array('size'=>60,'maxlength'=>256)); ?>
	<?
	echo $form->textFieldArrayRow($o, 'phones'); 
	?>
	
	<?php echo $form->textFieldRow($o,'email',array('size'=>60,'maxlength'=>128)); ?>
	
	<?php echo $form->urlFieldRow($o,'site',array('size'=>60,'maxlength'=>128)); ?>
	
	<? echo $form->formRowStart($o, 'descr'); ?>
	<? $this->widget('common.vendor.yiiext.imperavi-redactor-widget.ImperaviRedactorWidget', array(
		    'model' => $o,
		    'attribute' => 'descr',
		    'options' => array(
		        'lang' => 'ru',
		    ),
	));?>
	<? echo $form->formRowEnd($o, 'descr'); ?>
	
	<? // REGIME ?>
	<? echo $form->formRowStart($o, 'regime'); ?>
	<? echo $form->hiddenField($o, 'regime', array('data-bind' => 'value:regimeVal')); ?>
	<?
	$rd = $o->getRegimeData(); 
	foreach ($rd['days'] as $code => $day):
	?>
		<div class="regime" data-day="<?=$code?>" >
			<label class="inline"><input type="checkbox" class="regime-day" data-bind="checked: regime.days.<?=$code?>.on, event: { click:regimeDaySwitch } "><?=$day['label']?></label>
			<input class="regime-time" data-bind="value: regime.days.<?=$code?>.s, enable: regime.days.<?=$code?>.on" >
			<input class="regime-time" data-bind="value: regime.days.<?=$code?>.e, enable: regime.days.<?=$code?>.on" >
			
			<span class="regime-dinner-block" data-bind="visible: regime.days.<?=$code?>.on">
				<label class="inline" title="время обеда"><input type="checkbox" class="regime-dinner" data-bind="checked: regime.days.<?=$code?>.vo, enable: regime.days.<?=$code?>.on">обед</label>
				<span class="regime-dinner-time" data-bind="visible: regime.days.<?=$code?>.on() && regime.days.<?=$code?>.vo()" >
					<input class="regime-time" data-bind="value: regime.days.<?=$code?>.os" >
					<input class="regime-time" data-bind="value: regime.days.<?=$code?>.oe" >
				</span>
			</span>
			
		</div>
	<? endforeach; ?>
	<? echo $form->formRowEnd($o, 'regime'); ?>
	
	<?php echo $form->textFieldRow($o,'rating', array('readonly' => 'readonly')); ?>
		
	<?php echo $form->textFieldRow($o,'created_at', array('readonly' => 'readonly')); ?>
		
	<?php echo $form->textFieldRow($o,'updated_at', array('readonly' => 'readonly')); ?>

	<?php echo $form->checkBoxRow($o,'checked'); ?>
	
	<?php echo $form->textFieldRow($o,'seo_title',array('size'=>60,'maxlength'=>256)); ?>
	
	<?php echo $form->textFieldRow($o,'seo_keywords',array('size'=>60,'maxlength'=>256)); ?>
	
	<?php echo $form->textAreaRow($o,'seo_description',array('rows'=>2, 'cols'=>50)); ?>
	
	<?php echo $form->textFieldRow($o,'views'); ?>
	
	<? echo $form->formRowStart($o, 'categories'); ?>
	<div class="categories-selector"> 
	<? echo $form->checkBoxList($o, 'categoriesIds', Category::getTreeList(),
				array('separator' => "\n", 'template' => '<div class="item">{input}  {label}</div>', 'labelOptions' => array('class' => 'label-categ'))); ?>
	</div>
	<? echo $form->formRowEnd($o, 'categories'); ?>
	
	<? echo $form->dropDownListRow($o, 'idcatprimary', array(), 
			array('data-bind' => "options: categories, value: idcatprimary, optionsText:'name', optionsValue:'id' ")) ?>

	<? echo $form->hiddenField($o, 'mainPhotoIndex'); ?>
	<? echo $form->formRowStart($o, 'files'); ?>
	<? $this->widget('ext.attachment.CAttachmentWidget', array('model' => $o, 'attachId' => 'attachFiles', 'maxFiles' => 100, 'viewItem' => 'attachments_item_photo')); ?>
	<? echo $form->formRowEnd($o, 'files'); ?>
	
	<?php echo $form->textFieldRow($o,'tagsText'); ?>
	
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($o->isNewRecord ? 'Создать' : 'Сохранить'); ?>
		<?php echo CHtml::submitButton('Применить', array('name' => 'apply')); ?>
		<?php if (!$o->isNewRecord) 
				echo CHtml::button('Удалить',
    				array('submit'=>array('delete', 'id'=>$o->id), 'confirm' => 'Удалить?', 'class'=>'btn btn-danger' ) ); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
<!--
var orgform = {

	map : null,
	mark : null,
	address : ko.observable('<?=$o->address?>'),
	geolat : ko.observable('<?=$o->geolat?>'),
	geolon : ko.observable('<?=$o->geolon?>'),
	geocoder : ko.observable('<?=$o->geocoder?>'),
	geoexact : ko.observable('<?=$o->geoexact?>'),
	idcatprimary : ko.observable('<?=$o->idcatprimary?>'),
	categories : ko.observableArray(<?=json_encode(array_map(function($c){ return array('id'=>$c->id, 'name'=>$c->deepName); },  $o->categories))?>),
	regime : ko.mapping.fromJS(<?=json_encode($o->getRegimeData(), JSON_FORCE_OBJECT)?>),
	regimeDaySwitch : function(model, event) {
		var dayCode = $(event.target).closest('.regime').attr('data-day');
		if (this.regime.days[dayCode].on())
		{
			// copy prev day values
			var i = this.regimeDayCodes.indexOf(dayCode) - 1;
			if (i < 0) return true;
			var prevDayCode = this.regimeDayCodes[i];
			this.regime.days[dayCode].s( this.regime.days[prevDayCode].s() ); 
			this.regime.days[dayCode].e( this.regime.days[prevDayCode].e() );
			this.regime.days[dayCode].vo( this.regime.days[prevDayCode].vo() );
			this.regime.days[dayCode].os( this.regime.days[prevDayCode].os() );
			this.regime.days[dayCode].oe( this.regime.days[prevDayCode].oe() );
		}
		return true;
	},
	regimeDayCodes : ['pn','vt','sr','ch','pt','sb','vs'],

	geocode : function() {
		if (this.geocoder()=='1') {

			var self = this;
			if (!this.address().length) return;
			ymaps.geocode(this.address(), {
                boundedBy: omap_data.boundedBy,
                results: 1
            }).then(function (res) {
            	var go = res.geoObjects.get(0);
            	self.mark.geometry.setCoordinates( go.geometry.getCoordinates() );
            	self.map.panTo( go.geometry.getCoordinates(), { delay:500 } );
				self.coordsUpdate();
            	self.geoexact(go.properties.get('metaDataProperty.GeocoderMetaData.precision') == 'exact' ? 1 : 0);
			});
           			
		}
	},

	coordsUpdate : function() {
    	var cs = this.mark.geometry.getCoordinates();
    	this.geolat(parseFloat(cs[0].toFixed(6)));
    	this.geolon(parseFloat(cs[1].toFixed(6)));
	},
	
	mapSetup : function() {

		this.init();
		
		var data = omap_data;
		this.map = data.map;
		var point = this.geolat() && this.geolon() ? [parseFloat(this.geolat()), parseFloat(this.geolon())] : data.center; 
		var mark = this.mark = new ymaps.Placemark( point, null, { draggable:true } );
		var self = this;
	    mark.events.add('dragend', function(){
		    self.geocoder(0);
		    self.coordsUpdate();
		});
		data.map.geoObjects.add(mark);
		data.map.panTo(point);
	
	},

	init : function() {
		$('#Organization_categoriesIds :checkbox').click(function(){
			var id = $(this).val(), 
				name = $('#Organization_categoriesIds :checkbox[value="'+id+'"]').siblings('label').text();
			if ($(this).prop('checked')) {
				orgform.categories.push({id:id, name:name});
			} else {
				var c = ko.utils.arrayFirst( orgform.categories(), function(c) { return c.id == id; } );
				if (c) orgform.categories.remove(c);
			}
		});
		$('.regime-time').mask('99:99');
		ko.applyBindings(orgform);
	}
};

orgform.regimeVal = ko.computed(function(){
	// compact regime data to string
	var days = [];
	$.each(orgform.regime.days, function(key, dday){
		if (!dday.on()) {
			days.push('');
		} else {
			var day = dday.s() + '-' + dday.e();
			if (dday.vo()) 
				day += '(' + dday.os() + '-' + dday.oe() + ')';
			days.push(day);
		}
	});
	return days.join('|');
});

$(function(){
	$('#Organization_tagsText').selectize({
		load : function(query, callback) {
			$.getJSON('/admin/org/tagLoad', {query:query}, function(tags){
				tags = $.map(tags, function(tag){ return {value:tag, text:tag}; });
				callback(tags);
			});
		},
		create : function(input) {
			return {value:input, text:input};
		},
	});

	//orgform.init();
})
//-->
</script>
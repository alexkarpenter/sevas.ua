<?php
Yii::app()->clientScript->registerCoreScript('jquery.ui');
?>
<? echo CHtml::beginForm(array('sprav/search'), 'get', array('class' => 'gap2-before gap2-after')); ?>

<input id="search-input" name="query" class="sprav-search input" value="<?=CHtml::encode(@$_GET['query'])?>">
<input type="submit" class="sprav-submit" value="">

<? echo CHtml::endForm(); ?>

<script type="text/javascript">
$(function(){
	$('#search-input').autocomplete({
		minlength: 2,
	    source: function(request, response) {
	        $.ajax({
	            url: '/sprav/searchHints',
	            data: {query:request.term},
	            type: 'get',
	            dataType: 'json',
	            success: function(res) {
		            response( $.map(res, function(item){
			            	return { value:item.name + ' ' + item.address, label:item.name + ' ' + item.address, url:item.url };
			            }) );
	            }
	        });
	    },
	    select: function(event, ui) {
		    window.location = ui.item.url;
		},
		open: function(event, ui) {
			$(this).autocomplete('widget').width( $(this).width() );
		}
	});
});
</script>
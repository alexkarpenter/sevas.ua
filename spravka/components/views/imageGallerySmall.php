<?php
/*
 * gallery template with ajax-comments
 */

/* @var $this ImageGalleryWidget */
/* @var $f File */
$cs = Yii::app()->clientScript;
$cs->registerScriptFile("/js/jquery.magnific-popup".(defined(YII_DEBUG) ? '.min' : '').".js");
$cs->registerScriptFile("/js/jquery.magnific-popup.ru.js");
$cs->registerCssFile('/js/magnific-popup.css');
$webroot = Yii::getPathOfAlias('webroot');
?>

<div class="image-gallery-small-back gap-after">
<div class="image-gallery image-gallery-small">
	<? foreach (array_values($this->files) as $i => $f): ?>
		<?
		$src = $webroot.$f->path;
		echo CHtml::tag('a', array(
			'href' => $f->path, 'title' => $f->title, 'class' => 'item '.($f->commentsCount ? 'item-commented' : ''),
			'data-type' => get_class($f), 'data-id' => $f->id, 'data-comments' => $f->commentsCount));
		echo CHtml::image( Yii::app()->imager->getImageUrl($src, 'thumb160'), $f->title, 
				array() );
		echo '</a>';
		?>
	<? endforeach; ?>
	<div class="clear"></div>
</div>
</div>

<script type="text/javascript">
$(function(){
	var userGuest = <?=json_encode(Yii::app()->user->isGuest)?>;

	$.magnificPopup.resizeComments = function() {
	    var mfp = this.instance;
	    var maxW = $(window).width() - 30*2;
		var $img = mfp.currItem.img.css('max-width', maxW);
	    var $comments = mfp.content.filter('.mfp-comments');
	    $comments.css('width', $img.width());
	}
	
	$('.image-gallery-small')
		.magnificPopup({
			delegate: 'a', // child items selector, by clicking on it popup will open
			type: 'image',
			removalDelay: 300,
			closeOnBgClick: false,
			mainClass: 'mfp-type2',
			gallery: {
              	enabled: true,
              	navigateByImgClick: true,
			},
			image : {
				markup: '<div class="mfp-figure">'+
				'<div class="mfp-close"></div>'+
				'<div class="mfp-img"></div>'+
					'<div class="mfp-bottom-bar">'+
					'<div class="mfp-title"></div>'+
					'<div class="mfp-counter"></div>'+
				'</div>'+
				'</div>'+
				'<div class="mfp-comments mfp-prevent-close"></div>'
			},		  
			zoom: {
				enabled: false,
				duration: 200
			},
			callbacks : {
				beforeChange: function() {
				},
				afterChange: function() {
				    var mp = $.magnificPopup.instance;
				 	mp.container.find('.mfp-content').css('opacity', .2).animate({opacity: 1}, 300);
				},
				change: function() {
					    var mp = $.magnificPopup.instance;
					    var data = {
						    	type : mp.currItem.el.attr('data-type'),
						    	id : mp.currItem.el.attr('data-id'),
						};
					    var ccount = parseInt(mp.currItem.el.attr('data-comments'), 10);
						var $comments = this.content.filter('.mfp-comments');
						$comments.empty();
						if (userGuest && !ccount) {
							$comments.hide();
						} else {
							$comments.show().removeClass('loaded').addClass('loading');
							$.get('/sprav/commentList', data, function(comments){ 
								$comments.html(comments).removeClass('loading').addClass('loaded'); 
							});
						}
				},
				elementParse: function(item) {
				},
				imageLoadComplete: function() {
					$.magnificPopup.resizeComments();					
				},
				resize: function() {
				    $.magnificPopup.resizeComments();
				},			  
					  
			}
		});
		
});
</script>


<?php
/* @var $this ImageGalleryWidget */
/* @var $f File */
$cs = Yii::app()->clientScript;
$cs->registerScriptFile('/js/jquery.magnific-popup.min.js');
$cs->registerCssFile('/js/magnific-popup.css');
$cs->registerScriptFile('/js/jquery.mCustomScrollbar.min.js');
$cs->registerCssFile('/js/jquery.mCustomScrollbar.css');
$webroot = Yii::getPathOfAlias('webroot');
?>

<div class="image-gallery-back">
<div class="image-gallery">
	<? foreach (array_values($this->files) as $i => $f): ?>
		<?
		$src = $webroot.$f->path;
		echo CHtml::tag('a', array('href' => $f->path, 'title' => $f->title, 'class' => 'item'));
		echo CHtml::image( Yii::app()->imager->getImageUrl($src, 'gallery270'), $f->title, 
				array() );
		echo '</a>';
		?>
	<? endforeach; ?>
</div>
</div>

<script type="text/javascript">
$(function(){
	$('.image-gallery')
		.magnificPopup({
		  delegate: 'a', // child items selector, by clicking on it popup will open
		  type: 'image',
		  removalDelay: 300,
          gallery: {
              enabled: true,
              navigateByImgClick: true,
              //preload: [0,1] // Will preload 0 - before current, and 1 after the current image
			},		  
			zoom: {
				enabled: true,
				duration: 200 // don't foget to change the duration also in CSS
			}
		})
		.mCustomScrollbar({horizontalScroll:true});
		
});
</script>
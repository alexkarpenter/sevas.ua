<?php
/* @var $this SpravController */
/* @var $org Organization */
$org = $data;
$c = $org->mainCategory ?: new Category(); 
?>
<div id="org-<?=$org->id?>" class="org-preview">
	
	<h3 style="background:url('<?=$c->imgBehavior->getFileUrl()?>') left center no-repeat;"><? 
	echo CHtml::link($org->name, $org->getUrlData());
	?></h3>

	<div class="oprop oprop-rating">
		<?
		$this->widget('CStarRatingX', 
			array('value' => $org->rating, 'name' => "org_rating_{$org->id}", 'minRating' => 0.5, 'maxRating' => 5, 'readOnly' => true, 'allowEmpty' => false,
					'ratingStepSize' => 0.5, 'starCount' => 5, ));
		?>
		&nbsp;&nbsp;<span class="text-mini"><a href="<?=CHtml::normalizeUrl($org->getUrlData(array('#'=>'reviews')))?>">Отзывов</a><span class="text-gray">&nbsp;(<?=$org->reviewsCount?>)</span></span>
	</div>
	
	<div class="oprop oprop-address">
		<span class="oprop-label">Адрес:</span>
		<?php echo CHtml::encode($data->address); ?>
	</div>
	
	<?php if (!empty($data->phone)): ?>
	<div class="oprop oprop-phone">
		<span class="oprop-label">Телефон:</span>
		<?php echo CHtml::encode(implode('; ', $org->getPhones())); ?>
	</div>
	<? endif; ?>
		
	<div class="oprop-note">
	</div>

</div>
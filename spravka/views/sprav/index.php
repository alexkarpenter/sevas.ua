<?php
/* список категорий */
/* @var $this SpravController */
/* @var $cs Category[] */

$cs = array_values($cs);
$categs = count($cs);
$columns = 3;
$rows = ceil($categs / $columns);
/* @return Category */
$getNext = function($cs){ 
	static $i = -1;
	return @$cs[++$i];
};

?>

<table class="categ-table">
	<tbody>
		<? for ($ri=0; $ri<$rows; $ri++): ?>
		<tr>
			<? for ($ci=0; $ci<$columns; $ci++): ?>
			<td>
				<?
				$c = $getNext($cs); 
				?>
				<? if ($c): ?>
				<? $cimg = $c->imgBehavior->getFileUrl(); ?>
				<span class="categ categ-level-1" style="background:url('<?=$cimg?>') left center no-repeat;"><?=$c->name?></span>
				<ul class="">
				<? foreach ($c->childs as $cc): ?>
					<li>
						<span class="categ categ-level-2">
							<? echo CHtml::link($cc->name, $cc->getUrlData()); ?>
						</span>
					</li>
				<? endforeach; ?>
				</ul>
				<? endif; ?>
			</td>
			<? endfor; ?>
		</tr>
		<? endfor; ?>
	</tbody>
</table>




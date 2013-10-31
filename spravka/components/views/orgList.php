<?php
/* @var $this OrgListWidget */
/* @var $o Organization */
?>

<ul class="org-list">
	<? foreach (array_values($os) as $i => $o): ?>
	<li class="<?=($i % 2 ? 'odd' : 'even')?>">
		<?=$o->getLink()?>
	</li>
	<? endforeach; ?>
</ul>
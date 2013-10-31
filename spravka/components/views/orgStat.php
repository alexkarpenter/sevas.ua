<?php
/* @var $this OrgStatWidget */
?>

<ul class="org-stat side-category">
	<li>
		<a class="num_active"><?=$this->orgCount?></a>
		<div class="holder">Организаций всего</div>
	</li>
	<? if ($this->orgCountLastMonth): ?>
	<li>
		<a class="num_active"><?=$this->orgCountLastMonth?></a>
		<div class="holder">Добавлено за месяц</div>
	</li>
	<? endif; ?>
</ul>
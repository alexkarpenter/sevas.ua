<?php
/**
 * @var $this SearchController
 */
?>
<style>
<!--
.search-result li { margin-bottom:1em; }
-->
</style>
<div id="content-main-generated">
    <div class="heading-wrap">
        <h1><img width="18" height="18" alt="" src="/images/img-nav12.png">Поиск</h1>
        <span class="mark" style="background-color:#be123a"></span>
    </div>
    
    <h2>Результаты по запросу '<?=$search?>'</h2>
    
    <?
    if (empty($orgs)) print "<b>Ничего не найдено</b>";  
    ?>
    
    <ul class="search-result">
    <?
    foreach ($orgs as $o)
    	$this->renderPartial('_searchItem', array('org' => $o));
    ?>
    </ul>
    
    <div>
    <? 
    $this->widget('CLinkPager', array('pages' => $pages));
    ?>
    </div>
</div>


<?
//     CVarDumper::dump($res, 10, true);
?>

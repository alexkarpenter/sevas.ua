<div id="content-main-generated">
    <div class="heading-wrap">
        <h1><img width="18" height="18" alt="" src="/images/img-nav12.png">КРИМИНАЛ</h1>
        <span class="mark" style="background-color:#be123a"></span>
    </div>
    <? /* Controller::debug($model); */ ?>
    <?php $this->renderPartial('common.views.news._news_list', compact('model')); ?>
    <input type="hidden" id="count_elem" value="10">
    <input type="hidden" id="cat_name" value="">
    <input type="hidden" id="proverca" value="1">
    <div class="opener-aricle-wrap">
        <a class="opener-aricle" href="#"><span>Смотреть еще 10 новостей</span></a>
    </div>
</div>



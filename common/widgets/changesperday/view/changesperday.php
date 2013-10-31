<?php
$count_news = $changesperday_model;
$count_of_reg  = $countofreg;
$znak1 = '';
$znak2 = '';
$znak3 = '';
$znak4 = '';
if ($count_news > 0) {
    $znak1 = '+';
    $link1 = 'href="http://sevas.ru/news-of-day"';
    $num_class1 = '_active';
} else {
    $znak1 = '';
    $link1 = '';
    $num_class1 = '';
}
 if($count_of_reg > 0) {$znak4 = '+';} else{ $znak4 = '';}
?>
<div class="block">
    <h3>Обновления за сегодня</h3>
    <ul class="side-category">
        <li>
            <a class='num<?php echo $num_class1;?>'<? echo $link1?>><?php echo $znak1.$count_news?></a>
            <div class="holder">Новостей</div>
        </li>
        <li>
            <a class="num_active" href="http://sevas.ru/afisha-stat-of-day">+1</a>
            <div class="holder">Афиша</div>
        </li>
        <li>
            <a class="num">0</a>
            <div class="holder">Справочник</div>
        </li>
        <li>
            <a class="num"><?php echo $znak1.$count_of_reg?></a>
            <div class="holder">Регистраций на сайте</div>
        </li>
    </ul>
</div>
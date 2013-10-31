<div class="block">
    <h3>Популярные новости</h3>
    <ul class="side-news">
        <? foreach($popular_news_model as $popular):?>
            <li>
                <ul class="news-list" id="newsNumber-<?php echo $popular->id;?>">
                    <li class='<?php echo $popular->id;?>'>
                        <div class="box">
                            <div class="date"><span class="time"><?php echo date("H:i", $popular->date); ?></span><?php echo date("j F", $popular->date); ?></div>
                            <div class="news_link side_news_title"><a href='/news/<?php echo $popular->url; ?>'><?php echo $popular->name; ?></a></div>
                        </div>
                        <div class="wrap" style="padding-top: 93px;">
                            <div class="panel">
                                <div class="num">
                                    <?php if (!$popular->count_coment) $popular->count_coment = 0; ?>
                                    <?php if (!$popular->count_veiw) $popular->count_veiw = 0; ?>
                                    <div class="views"><?php echo $popular->count_veiw; ?></div>
                                    <div class="comment"><a href='/news/<?php echo $popular->url; ?>#comentblock' title="перейти к комментрарию"><?php echo $popular->count_coment; ?></a></div>
                                </div>
                                <div class="holder">
                                    <a class="category" href="http://politika.sevas.ru/novosti-politiki"><span class="mark" style="background-color: #be123a;"></span>Криминал</a>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </li>
        <? endforeach;?>
    </ul>
    <div class="more">
        <br class="c">
    </div>
</div>
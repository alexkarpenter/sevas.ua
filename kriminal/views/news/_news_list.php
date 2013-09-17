<ul class="article-list">
    <?php foreach ($model as $news) { ?>
        <ul class="news-list" id="newsNumber-<?php echo $news->id; ?>">
            <li class="<?php echo $news->id; ?>"/>
            <div class="news_title"><a href="/news/<?php echo $news->url; ?>"><?php echo $news->name; ?></a></div>
            <div class="wrap-info">
                <div class="visual">
                    <a href="<?php echo $news->url; ?>"/>
                    <div class="img"><img src="<?php echo $news->img; ?>" width="573" height="353"/></div>
                    </a>
                </div>
                <div class="up-down">
                    <input type="hidden" class="id_user" value="">
                    Ваше мнение:
                    <div class="up">
                        <a class="ra_up">up</a>
                        <span class="s_up">+1</span>
                    </div>
                    <div class="down">
                        <a class="ra_down">down</a>
                        <span class="s_down">-1</span>
                    </div>
                </div>
                <div class="statistics">
                    <div class="date">17 Сентября</div>
                    <div class="time">12:50</div>
                    <div class="views">Просмотров:<span>0</span></div>
                    <div class="comment">Комментариев:<span>0</span></div>
                </div>
            </div>
            <br class="c"/>
            <p><?php echo $news->text; ?> <a href="<?php echo $news->url; ?>">Читать полный текст</a></p>
            </li>
        </ul>
    <?php } ?>
</ul>
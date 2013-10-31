<script>
    $(document).ready(function(){
        $('.ra_up').click(function () {
            var id_news = $(this).closest("li").attr("class");
            var id_user = $('.id_user').attr('value');
            var up =  $(this)[0]['nextElementSibling']['innerText'];
            if(id_user != '')
            {
                $.ajax({
                    type: "GET",
                    url: '<?=$this->createUrl('news/rating')?>',
                    data: {id_news:id_news, rating:0},
                    success:function(data){
                        if(data == 'success')
                        {
                            $('li.'+id_news +' .s_up').html('+' + (parseInt(up)+parseInt(1)));
                        }
                    }
                })
            }
            else {
                $('body').stop().animate({'scrollTop':0},700);
                $('.top-panel .opener-popup:not(.reg-tab)').click();
            }
        });
        $('.ra_down').click(function () {
            var id_news = $(this).closest("li").attr("class");
            var id_user = $('.id_user').attr('value');
            var down =  $(this)[0]['nextElementSibling']['innerText'];
            if(id_user != '')
            {
                $.ajax({
                    type: "GET",
                    url: '<?=$this->createUrl('news/rating')?>',
                    data: {id_news:id_news, rating:1},
                    success:function(data){

                        if(data == 'success')
                        {
                            $('li.'+id_news +' .s_down').html('-' + (parseInt(down)+parseInt(1)));
                        }
                    }
                })
            }
            else {
                $('body').stop().animate({'scrollTop':0},700);
                $('.top-panel .opener-popup:not(.reg-tab)').click();
            }
        });
        $(".news_link a").click(function(){
            var id_news = $(this).closest("li").attr("class");
            console.log(id_news);
            $.ajax({
                type: "GET",
                url: '<?=$this->createUrl('news/viewnews')?>',
                data: {id_news:id_news},
                success:function(data){
                    if(data == 'success')
                    {
                        $('.views span').html(data);
                    }
                }
            })
        });
    });
</script>
<ul class="article-list">
    <?php foreach ($model as $news) { ?>
        <?php
        if($news->rating_up == '0') $plus_znak = ''; else $plus_znak = '+';
        if($news->rating_down =='0') $minus_znak = ''; else $minus_znak= '-';
        ?>
        <ul class="news-list" id="newsNumber-<?php echo $news->id; ?>">
            <li class="<?php echo $news->id; ?>"/>
            <div class="news_link news_title"><a href="/<?php echo $news->url; ?>"><?php echo $news->name; ?></a></div>
            <div class="wrap-info">
                <div class="visual">
                    <a href="<?php echo $news->url; ?>"/>
                        <div class="img"><img src="<?php echo $news->img; ?>" width="573" height="353"/></div>
                    </a>
                </div>
                <div class="up-down">
                    <input type="hidden" class="id_user" value='<? echo Yii::app()->user->id;?>'>
                    <input type="hidden" class="up" value='<?php echo $news->rating_up?>'>
                    Ваше мнение:
                    <div class="up">
                        <a class="ra_up">up</a>
                        <span class="s_up"><?php echo $plus_znak.$news->rating_up?></span>
                    </div>
                    <div class="down">
                        <a class="ra_down">down</a>
                        <span class="s_down"><?php echo $minus_znak.$news->rating_down?></span>
                    </div>
                </div>
                <?
                if (!$news->count_veiw) $news->count_veiw = 0;
                if (!$news->count_coment) $news->count_coment = 0;
                ?>
                <div class="statistics">
                    <div class="date"><?php echo Utils::RusDate("j F", $news->date);?></div>
                    <div class="time"><?php echo date("H:i", $news->date);?></div>
                    <div class="views">Просмотров:<span><?php echo $news->count_veiw;?></span></div>
                    <div class="comment">Комментариев:<span><?php echo $news->count_coment?></span></div>
                </div>
            </div>
            <br class="c"/>
            <p><?php echo $news->text; ?> <a href="<?php echo $news->url; ?>">Читать полный текст</a></p>
            </li>
        </ul>
    <?php } ?>
</ul>
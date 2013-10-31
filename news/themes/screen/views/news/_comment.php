<script type="text/javascript">
    $(document).ready(function(){
        $('.up_com').click(function () {
            var id_com = $(this).closest("li").attr("class");
            var id_user = $('.id_user').attr('value');
            var id_com_user = $('.id_com_user').attr('value');
            var up =  $(this)[0]['nextElementSibling']['innerText'];
            if(id_user!='' && id_user!=id_com_user){
                $.ajax({
                    type: "GET",
                    url: '<?=$this->createUrl('news/ratingcomments')?>',
                    data: {id_com:id_com, rating:0},
                    success:function(data){
                        if(data == 'success')
                        {
                            $('li.'+id_com +' .comment_up').html('+' + (parseInt(up)+parseInt(1)));
                        }
                    }
                })
            }
            else {

                var destination = jQuery('.comment_wrap').offset().top;
                jQuery("html,body").animate({scrollTop: destination}, 700);
                $('.opener-popup:not(.reg-tab)').click();

            }
        });

        $('.down_com').click(function () {
            var id_com = $(this).closest("li").attr("class");
            var id_user = $('.id_user').attr('value');
            var id_com_user = $('.id_com_user').attr('value');
            var down =  $(this)[0]['nextElementSibling']['innerText'];
            if (id_user!='' && id_user!=id_com_user){
                $.ajax({
                    type: "GET",
                    url: '<?=$this->createUrl('news/ratingcomments')?>',
                    data: {id_com:id_com, rating:1},
                    success:function(data){
                        if(data == 'success')
                        {
                            $('li.'+id_com +' .comment_down').html('-' + (parseInt(down)+parseInt(1)));
                        }
                    }
                })
            }
            else {

                var destination = jQuery('.comment_wrap').offset().top;
                jQuery("html,body").animate({scrollTop: destination}, 700);
                $('.opener-popup:not(.reg-tab)').click();
            }
        });
    });
</script>
<div id="comment_wrap">
    <?php if($model->comments){ ?>
        <?php foreach ($model->comments as $comment) { ?>
            <?php
            if($comment->rating_up == '0') $plus_znak = ''; else $plus_znak = '+';
            if($comment->rating_down =='0') $minus_znak = ''; else $minus_znak= '-';
            ?>
            <ul class="comment-list" id="commentNumber-<?=$comment->id;?>">
                <li id="idcom<?=$comment->id;?>" class="<?=$comment->id;?>"><div class="box">
                        <div class="visual"><img class="avatar-comment" src="<?= $comment->user->avatarurl; ?>"></div>
                        <div class="holder">
                            <div class="row">
                                <div class="name"><?= $comment->user->name; ?></div>
                                <div class="date">
                                    <span class="time"><?= date('H:i', $comment->create_date);?></span>
                                    <?php echo Utils::RusDate("j F", $comment->create_date);?>
                                </div>
                                <div class="up-down">
                                    <input type="hidden" class="id_user" value='<? echo Yii::app()->user->id;?>'>
                                    <input type="hidden" id="user_info_login" value>
                                    <input type="hidden" class="id_com_user" value='<?echo $comment->user_id?>'>
                                    <div class="up">
                                        <a class="up_com">up</a>
                                        <span class="comment_up"><?php echo $plus_znak.$comment->rating_up?></span>
                                    </div>
                                    <div class="down">
                                        <a class="down_com">down</a>
                                        <span class="comment_down"><?php echo $minus_znak.$comment->rating_down?></span>
                                    </div>
                                </div>
                            </div><ul class="subcomment-list"></ul>

                            <p><?= $comment->text; ?></p>
                        </div>
                    </div>
                </li>
            </ul>
            <? if (Yii::app()->user->checkRole('admin')) { ?>
                <a href="<?= $this->createUrl('news/deletecomment', array('id_comment' => $comment->id, 'back_url' => $comment->news->url)) ?>">Удалить комментарий</a>
            <? } ?>
        <?php } ?>
    <?php } ?>
</div>
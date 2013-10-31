<div id="content-search" style="display: none">
    <noindex>
        <div id="content-search-container" class="bring-me-to-frontier">
            <div id="content-search-header">
                <div class="result">Результаты поиска:</div>
                <span>Закрыть</span>
            </div>
            <div id="content-search-result">
            </div>
        </div>
    </noindex>
</div>
<div id="content-main-generated">
    <div class="heading-wrap">
        <h1><img width="18" height="18" alt="" src="themes/<?php echo Yii::app()->theme->name ?>/images/img-nav12.png">КРИМИНАЛ
        </h1>
        <span class="mark" style="background-color:#be123a"></span>
    </div>
    <div class="article-wrapper">
        <h1><?php echo $model->name; ?></h1>

        <div class="wrap-info">
            <div class="visual">
                <div class="img">
                    <img src="<?php echo $model->img; ?>" width="573" height="353" alt="">
                </div>
                <span class="title"></span>
            </div>
            <div class="up-down">
                Ваше мнение:
                <input type="hidden" id="id_user" value='<? echo Yii::app()->user->id; ?>'>
                <input type="hidden" id="id_stat" value='<? echo $model->id; ?>'>
                <script type="text/javascript">
                    $(document).ready(function () {
                        var up = '<? echo $model->rating_up;?>';
                        var down = '<? echo $model->rating_down?>';
                        var id_user = $('#id_user').attr('value');
                        var id_news = $('#id_stat').attr('value');
                        $('.raiting_up').click(function () {
                            if (id_user != '') {
                                $.ajax({
                                    type: "GET",
                                    url: '<?=$this->createUrl('news/rating')?>',
                                    data: {id_news: id_news, rating: 0},
                                    success: function (data) {
                                        if (data == 'success') {
                                            $('.stat_up').html('+' + (parseInt(up) + parseInt(1)));
                                        }
                                    }
                                })
                            }
                            else {
                                $('body').stop().animate({'scrollTop': 0}, 700);
                                $('.top-panel .opener-popup:not(.reg-tab)').click();
                            }
                        });

                        $('.raiting_down').click(function () {
                            if (id_user != '') {
                                $.ajax({
                                    type: "GET",
                                    url: '<?=$this->createUrl('news/rating')?>',
                                    data: {id_news: id_news, rating: 1},
                                    success: function (data) {
                                        if (data == 'success') {
                                            $('.stat_down').html('-' + (parseInt(down) + parseInt(1)));
                                        }
                                    }
                                })
                            }
                            else {
                                $('body').stop().animate({'scrollTop': 0}, 700);
                                $('.top-panel .opener-popup:not(.reg-tab)').click();
                            }
                        });
                    });
                </script>
                <?php  if ($model->rating_up == '0') $plus_znak = ''; else $plus_znak = '+';
                if ($model->rating_down == '0') $minus_znak = ''; else $minus_znak = '-';
                ?>
                <?php
                if (!$model->count_veiw) $model->count_veiw = 0;
                if (!$model->count_coment) $model->count_coment = 0;
                ?>
                <div class="up">
                    <a class="raiting_up">up</a>
                    <span class="num stat_up"><?php echo $plus_znak . $model->rating_up; ?></span>
                </div>
                <div class="down">
                    <a class="raiting_down">down</a>
                    <span class="num stat_down"><?php echo $minus_znak . $model->rating_down ?></span>
                </div>
            </div>
            <div class="statistics">
                <div class="date"><?php echo Utils::RusDate('j F', $model->create_date); ?></div>
                <div class="time"><span><?php echo date('H:i', $model->create_date); ?></span></div>
                <div class="views">Просмотров:<span><?php echo $model->count_veiw; ?></span></div>
                <div class="comment">Комментариев:<span><?php echo $model->count_coment; ?></span></div>
            </div>
            <div class="print">
                <div id="link_to_print">
                    http://politika.sevas.ru/novosti-politiki/rossiyskie-investoryi-svorachivayut-svoi-programmyi-iz-za-sevastopolskih-reyderov?version=print
                </div>
                <a id="link-to-print" title="печать">
                    <div id="print"><span>Версия</span><br><span>для печати</span></div>
                </a>
            </div>
        </div>
        <br class="c">

        <p><?php echo $model->text; ?></p>

        <div class="content">
            <div class="opener-listwrap-img">
                <a class="opener-list-img" href="#"><span>Смотреть фотографии материала</span></a>
            </div>
            <div class="img-listing">
                <ul class="list">
                    <li><a href='/images/main-img-1.jpg' rel='lightbox[1]'><img src="/images/main-img-1.jpg"/></a></li>
                    <li><a href='/images/main-img-2.jpg' rel='lightbox[1]'><img src="/images/main-img-2.jpg"/></a></li>
                    <li><a href='/images/main-img-3.jpg' rel='lightbox[1]'><img src="/images/main-img-3.jpg"/></a></li>
                    <li><a href='/images/main-img-4.jpg' rel='lightbox[1]'><img src="/images/main-img-4.jpg"/></a></li>
                </ul>
            </div>
            <div class="opener-img-wrap">
                <a class="opener-img-listing" href="#"><span>Показать еще фотографии</span></a>
            </div>
            <div class="hide-img-wrap">
                <a class="hide-img-listing"
                   href="http://spravka.sevas.ru/avtosalonyi/rial-avto-avtosalon-na-ulitse-pravdyi#up"><span>Скрыть фотографии материала</span></a>
            </div>
        </div>
        <div class="overall-rating">
            <div class="title">Ваше мнение:</div>
            <div class="row">
                <!-- start widjets-->
                <br class="c">
            </div>
            <!-- end widjets-->
        </div>
        <div class="comment-wrappper">
            <div id="comments-answers-box">
                <div class="comment_wrap"><h3>Комментарии</h3></div>
                <div class="num2"></div>
                <br class="c">
                <a name="comentblock"></a>
                <?
                if (!Yii::app()->user->isBlocked() && !Yii::app()->user->isGuest)
                    $this->renderPartial('_add_comment', array(
                        'commentForm' => $commentForm,
                        'url' => $url
                    ));
                else {
                    ?>
                    <div class="login-row">Если Вы хотите оставить комментарий, то Вам необходимо <a
                            class="opener-popup" href="#">Войти</a> или <a class="opener-popup reg-tab" href="#"
                                                                           id="reg_button"
                                                                           onclick="$('#header-center-registration').show()">Зарегистрироваться</a>
                    </div> <?
                }
                ?>
                <?php $this->renderPartial('_comment', array('model' => $model)); ?>
            </div>
            <br class="c">

            <div class="main-answer" id="comment-template" style="display:none">
                <table>
                    <tbody>
                    <tr>
                        <td class="avatar-box">
                            <!--Add avatar here like <img src="" class="avatar">-->
                        </td>
                        <td class="textarea-box">
                            <span class="nick-name"><!--Add nick-name here--></span>

                            <p><!--Add text here--></p>

                            <div class="comment-data-and-time"><!--Add day and mounth here-->
                                <span><!--Add time here--></span></div>

                            <br class="c">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="main-answer" id="comment-template-with-quote" style="display:none">
                <table>
                    <tbody>
                    <tr>
                        <td class="avatar-box">
                            <!--Add avatar here like <img src="" class="avatar">-->
                        </td>
                        <td class="textarea-box">
                            <span class="nick-name"><!--Add nick-name here--></span>

                            <div class="quote-box">
                                <div class="quote-nick-name"><!--Add nick-name here--> писал(а):</div>
                                <span class="quote-arrow"></span>

                                <div class="quote-message"><!--Add quote-text here-->
                                    <div class="comment-data-and-time"><!--Add quote-day-and-mouth here--> <span><!--Add quote-time here--></span>
                                    </div>
                                </div>
                            </div>
                            <p><!--Add text here--></p>

                            <div class="comment-data-and-time"><!--Add day and mounth here-->
                                <span><!--Add time here--></span></div>

                            <br class="c">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
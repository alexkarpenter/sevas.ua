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
        <h1><img width="18" height="18" alt="" src="/images/img-nav12.png">КРИМИНАЛ</h1>
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
                <input type="hidden" id="id_user" value="">
                <input type="hidden" id="id_stat" value="2838">
                <div class="up">
                    <a class="raiting_up">up</a>
                    <span class="num stat_up">+1</span>
                </div>
                <div class="down">
                    <a class="raiting_down">down</a>
                    <span class="num stat_down">-1</span>
                </div>
            </div>
            <div class="statistics">
                <div class="date">17 Сентября</div>
                <div class="time"><span>12:50</span></div>
                <div class="views">Просмотров:<span>38</span></div>
                <div class="comment">Комментариев:<span>0</span></div>
            </div>
            <div class="print">
                <div id="link_to_print">http://politika.sevas.ru/novosti-politiki/rossiyskie-investoryi-svorachivayut-svoi-programmyi-iz-za-sevastopolskih-reyderov?version=print</div><a id="link-to-print" title="печать"><div id="print"><span>Версия</span><br><span>для печати</span></div></a>
            </div>
        </div>
        <br class="c">
        <p><?php echo $model->text; ?></p>
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
                <div class="comment_wrap"><h3>Комментарии</h3></div><div class="num2"></div><br class="c"><a name="comentblock"></a><div class="login-row">Если Вы хотите оставить комментарий, то Вам необходимо <a class="opener-popup" href="#">Войти</a> или <a class="opener-popup reg-tab" href="#" id="reg_button" onclick="$('#header-center-registration').show()">Зарегистрироваться</a></div><div style="margin-left:40px; margin-top:10px;">Отзывов пока нет. </div> 
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
                                <div class="comment-data-and-time"><!--Add day and mounth here--> <span><!--Add time here--></span></div>			

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
                                    <div class="comment-data-and-time"><!--Add quote-day-and-mouth here--> <span><!--Add quote-time here--></span></div></div>
                                </div>
                                <p><!--Add text here--></p>
                                <div class="comment-data-and-time"><!--Add day and mounth here--> <span><!--Add time here--></span></div>

                                <br class="c">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

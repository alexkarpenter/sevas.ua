<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />
    <?php
    $cs=Yii::app()->clientScript;
    $cs->scriptMap=array(
        'jquery.js'=>'http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js',
        //'jquery.yiiactiveform.js'=>false,
        'jquery.ui'=>'http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js',
        'news_func.js'=>'/themes/'.Yii::app()->theme->name.'/js/all.js',
        'lightbox.js'=>'/themes/'.Yii::app()->theme->name.'/js/all.js',
    );
    $cs->registerCoreScript('jquery.js');
    $cs->registerCoreScript('jquery.ui');
    $cs->registerScriptFile('/js/es5-shim.js');
    //$cs->registerCssFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/base/jquery-ui.css');
    $cs->registerCssFile('/css/jui/jquery-ui-custom.css');
    //$asset = Yii::app()->assetManager->publish(Yii::getPathOfAlias('common').'/www/themes/'.Yii::app()->theme->name,true);
    $cs->registerScriptFile('/themes/'.Yii::app()->theme->name.'/js/lightbox.js');
    $cs->registerScriptFile('/themes/'.Yii::app()->theme->name.'/js/news_func.js');
    //$cs->registerCssFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('common').'/www/themes/'.$GLOBALS['theme_name'].'/assets/css/screen.css'));
    $cs->registerCssFile('/themes/'.Yii::app()->theme->name.'/css/main.css');
    $cs->registerCssFile('/themes/'.Yii::app()->theme->name.'/css/print.css','print');
    $cs->registerCssFile('/themes/'.Yii::app()->theme->name.'/css/form.css');
    $u = $_SERVER['HTTP_USER_AGENT'];
    $isIE8  = (bool)preg_match('/msie 9./i', $u );
    if($isIE8){
        $cs->registerCssFile($asset.'/css/ie.css','screen, projection');
     }
    ?>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
<?php if(Yii::app()->user->hasFlash('success')):
    echo Yii::app()->user->getFlash('success');
endif; ?>

<?php if(Yii::app()->user->hasFlash('error')):
    echo Yii::app()->user->getFlash('error');
endif; ?>

<div id="wrapper">
    <div id="hide-isotop"></div>
    <div id="test"></div>
    <div id="header">
        <a id="top"></a>
        <div class="top-panel">
            <div class="top_logo">
                <a class="logo" href="http://sevas.ru">SEVAS Севастопольский городской портал</a>
                <span>сайт города Севастополь</span>
            </div>
            <div class="weather-wrap">
                <div class="title">Погода в Севастополе:</div><div class="wrap"><div class="visual"><a title="малооблачно"><div class="weather weather_maloblachno"></div></a></div><div class="now">+24<sup> o</sup><span>C</span></div><div>Днем +25 </div><div>Ночью +15 </div></div>
            </div>
            <div class="reg_succes"></div>
            <div class="block">
                <?php if(!Yii::app()->user->isGuest) {
                    echo "<div class='row'><div class='user_icon'></div><a id='head-user-menu-profile-login' href='/user/profile'>".Yii::app()->user->name."</a> | <a id='head-user-menu-profile-exit' href='/user/logout'>Выход</a></div>";
                }else{
                    echo  "<div class='row'>
									<a id='inpt_pus' class='opener-popup' href='/user/login'>Вход с паролем</a> |
									<a id='reg_link' class='opener-popup reg-tab' href='/user/reg'>Регистрация</a></div>";
                }?>
                <a class="opener-camera" href="http://webcam.sevas.ru"><span>Веб камеры<br>Севастополя</span></a>
            </div>
            <div class="side-wrap">
                <div class="date"><span class="time" id="head_time"><?= date('H:i');?></span><? echo Utils::RusDate('l, j F', time());?></div>
                <div action="#" id="header_search" class="search-form">
                    <input class="text" id="search-text" type="text" value="Найти..." name="search" onblur="if (this.value == ''){this.value = 'Найти...';}" onfocus="if (this.value == 'Найти...'){this.value = '';}">
                    <input class="btn" id="search-sumbit" type="submit" value="" title="submit" onclick="searchInSevas()">
                </div>
            </div>
        </div>
        <div class="nav-wrapper">
            <div class="frame">
                <ul class="nav nav_t">
                    <li>
                        <a href="<?= Yii::app()->subUrl(array('news/index', 'category'=>'politics')); ?>" class="<?$this->activeMenu=='politika'?'active':''?>">
                            <span>
                                <img src="/themes/<?php echo Yii::app()->theme->name; ?>/images/img-nav01.png" width="18" height="18" alt="">
                                ПОЛИТИКА
                            </span>
                            <i>&nbsp;</i>
                        </a>
                    </li>
                    <li>
                        <a href="<?= CHtml::normalizeUrl(array('news/index', 'category'=>'kriminal')); ?>" class="<?$this->activeMenu=='kriminal'?'active':''?>">
                            <span>
                                <img src="/themes/<?php echo Yii::app()->theme->name; ?>/images/img-nav12.png" width="18" height="18" alt="">
                                КРИМИНАЛ
                            </span>
                            <i>&nbsp;</i>
                        </a>
                    </li>
                    <li>
                        <a href="http://news.sevas.ru/sport">
                            <span>
                                <img src="/themes/<?php echo Yii::app()->theme->name; ?>/images/img-nav02.png" width="18" height="18" alt="">
                                СПОРТ
                            </span>
                            <i>&nbsp;</i>
                        </a>
                    </li>
                    <li>
                        <a href="http://news.sevas.ru/holiday">
                            <span>
                                <img src="/themes/<?php echo Yii::app()->theme->name; ?>/images/img-nav08.png" width="18" height="18" alt="">
                                ПРАЗДНИКИ
                            </span>
                            <i>&nbsp;</i>
                        </a>
                    </li>
                    <li>
                        <a href="http://news.sevas.ru/party">
                            <span>
                                <img src="/themes/<?php echo Yii::app()->theme->name; ?>/images/img-nav03.png" width="18" height="18" alt="">
                                ВЕЧЕРИНКИ
                            </span>
                            <i>&nbsp;</i>
                        </a>
                    </li>
                    <li>
                        <a href="http://news.sevas.ru/stars">
                            <span>
                                <img src="/themes/<?php echo Yii::app()->theme->name; ?>/images/img-nav04.png" width="18" height="18" alt="">
                                ЗНАМЕНИТОСТИ
                            </span>
                            <i>&nbsp;</i>
                        </a>
                    </li>
                    <li>
                        <a href="http://news.sevas.ru/festival">
                            <span>
                                <img src="/themes/<?php echo Yii::app()->theme->name; ?>/images/img-nav07.png" width="18" height="18" alt="">
                                ФЕСТИВАЛИ
                            </span>
                            <i>&nbsp;</i>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav_b">
                    <li>
                        <a href="http://news.sevas.ru/fash">
                            <span>
                                <img src="/themes/<?php echo Yii::app()->theme->name; ?>/images/img-nav05.png" width="18" height="18" alt="">
                                МОДА и СТИЛЬ
                            </span>
                            <i>&nbsp;</i>
                        </a>
                    </li>
                    <li>
                        <a href="http://news.sevas.ru/istoricheskie-rekonstrukczii">
                            <span>
                                <img src="/themes/<?php echo Yii::app()->theme->name; ?>/images/img-nav09.png" width="18" height="18" alt="">
                                ИСТОРИЧЕСКИЕ  РЕКОНСТРУКЦИИ
                            </span>
                            <i>&nbsp;</i>
                        </a>
                    </li>
                    <li>
                        <a href="http://news.sevas.ru/exhibit">
                            <span>
                                <img src="/themes/<?php echo Yii::app()->theme->name; ?>/images/img-nav06.png" width="18" height="18" alt="">
                                ВЫСТАВКИ
                            </span>
                            <i>&nbsp;</i>
                        </a>
                    </li>
                    <li>
                        <a href="http://afisha.sevas.ru">
                            <span>
                                <img src="/themes/<?php echo Yii::app()->theme->name; ?>/images/img-nav10.png" width="18" height="18" alt="">
                                АФИША
                            </span>
                            <i>&nbsp;</i>
                        </a>
                    </li>
                    <li>
                        <a href="http://spravka.sevas.ru">
                            <span>
                                <img src="/themes/<?php echo Yii::app()->theme->name; ?>/images/img-nav11.png" width="18" height="18" alt="" />
                                СПРАВОЧНИК
                            </span>
                            <i>&nbsp;</i>
                        </a>
                    </li>
                    <li>
                        <a href="http://news.sevas.ru/mixnews">
                            <span>
                                <img src="/themes/<?php echo Yii::app()->theme->name; ?>/images/img-nav13.png" width="18" height="18" alt="" />
                                РАЗНОЕ
                            </span>
                            <i>&nbsp;</i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div><!-- header -->
    <div id="main">
        <?php if (false && isset($this->breadcrumbs)): ?>
            <?php
                      $this->widget('zii.widgets.CBreadcrumbs', array(
                          'links' => $this->breadcrumbs,
                      ));
                      ?><!-- breadcrumbs -->
        <?php endif ?>
        <?php echo $content; ?>
        <div class="clear"></div>
    </div>
    <div id="footer">
        <div class="nav-wrapper">
            <div class="frame"></div>
        </div>
        <div class="footer-bottom">
            <div class="row">
                <a class="f-logo" href="/">SEVAS Севастопольский городской портал</a>
                <a class="up-btn" href="#"><span>Наверх</span></a>
            </div>
        </div>
    </div><!-- footer -->
</div><!-- #wrapper -->
<div class="popup-holder" id="login-popup-wrap" style="display:none;">
    <div class="bg"></div>
    <div class="login-popup" style="margin: 0px;">
        <ul class="tab-set">
            <li class="active"><a href="#">Вход</a><i></i></li>
            <li><a href="#">Регистрация</a><i></i></li>
        </ul>
        <div class="tab-body">
            <?php  //$this->renderPartial('common.themes.'.Yii::app()->theme->name.'.views.user._login_form_header', array('model'=>new User())); ?>
        </div>
        <div class="b">&nbsp;</div>
    </div>
</div>
</body>
</html>
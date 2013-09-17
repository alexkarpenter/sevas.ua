<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

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
                    <div class="row">
						 <a class="opener-popup" href="#">Вход с паролем</a> |
						 <a class="opener-popup reg-tab" href="#">Регистрация</a>
					</div>
					<a class="opener-camera" href="http://webcam.sevas.ru"><span>Веб камеры<br>Севастополя</span></a>
				</div>
				<div class="side-wrap">
					<div class="date"><span class="time" id="head_time">17:21</span>Четверг, 12 Сентября</div>
					<div action="#" id="header_search" class="search-form">
							<input class="text" id="search-text" type="text" value="Найти..." name="search" onblur="if (this.value == '') {this.value = 'Найти...';}" onfocus="if (this.value == 'Найти...') {this.value = '';}">
							<input class="btn" id="search-sumbit" type="submit" value="" title="submit" onclick="searchInSevas()">
					</div>
				</div>
		</div>
        <div class="nav-wrapper">
			<div class="frame">
				<ul class="nav nav_t">
					<li><a href="http://politika.sevas.ru"><span><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/img-nav01.png" width="18" height="18" alt="">ПОЛИТИКА</span><i>&nbsp;</i></a></li>
					<li><a href="http://kriminal.sevas.ru" class="active"><span><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/img-nav12.png" width="18" height="18" alt="">КРИМИНАЛ</span><i>&nbsp;</i></a></li>
                    <li><a href="http://news.sevas.ru/sport"><span><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/img-nav02.png" width="18" height="18" alt="">СПОРТ</span><i>&nbsp;</i></a></li>
                    <li><a href="http://news.sevas.ru/holiday"><span><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/img-nav08.png" width="18" height="18" alt="">ПРАЗДНИКИ</span><i>&nbsp;</i></a></li>
					<li><a href="http://news.sevas.ru/party"><span><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/img-nav03.png" width="18" height="18" alt="">ВЕЧЕРИНКИ</span><i>&nbsp;</i></a></li>
					<li><a href="http://news.sevas.ru/stars"><span><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/img-nav04.png" width="18" height="18" alt="">ЗНАМЕНИТОСТИ</span><i>&nbsp;</i></a></li>
					<li><a href="http://news.sevas.ru/festival"><span><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/img-nav07.png" width="18" height="18" alt="">ФЕСТИВАЛИ</span><i>&nbsp;</i></a></li>
                 </ul>
                 <ul class="nav nav_b">
                     <li><a href="http://news.sevas.ru/fash"><span><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/img-nav05.png" width="18" height="18" alt="">МОДА и СТИЛЬ</span><i>&nbsp;</i></a></li>
                     <li><a href="http://news.sevas.ru/istoricheskie-rekonstrukczii"><span><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/img-nav09.png" width="18" height="18" alt="">ИСТОРИЧЕСКИЕ  РЕКОНСТРУКЦИИ</span><i>&nbsp;</i></a></li>
					 <li><a href="http://news.sevas.ru/exhibit"><span><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/img-nav06.png" width="18" height="18" alt="">ВЫСТАВКИ</span><i>&nbsp;</i></a></li>
					 <li><a href="http://afisha.sevas.ru"><span><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/img-nav10.png" width="18" height="18" alt="">АФИША</span><i>&nbsp;</i></a></li>
                     <li><a href="http://spravka.sevas.ru"><span><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/img-nav11.png" width="18" height="18" alt="" />СПРАВОЧНИК</span><i>&nbsp;</i></a></li>
                     <li><a href="http://news.sevas.ru/mixnews"><span><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/img-nav13.png" width="18" height="18" alt="" />РАЗНОЕ</span><i>&nbsp;</i></a></li>

				</ul>
        </div>			
	</div>
    <!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array('/site/index')),
				array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
				array('label'=>'Contact', 'url'=>array('/site/contact')),
				array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

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
	</div>
    <!-- footer -->

</div><!-- page -->
</div>
<div class="popup-holder" id="login-popup-wrap" style="display:none;">
			<div class="bg"></div>
			<div class="login-popup" style="margin: 0px;">
				<ul class="tab-set">
					<li class="active"><a href="#">Вход</a><i></i></li>
					<li><a href="#">Регистрация</a><i></i></li>
				</ul>
				<div class="tab-body">
                	<form method="post" id="login-form" name="login" class="tab">
                    <fieldset>
                        <p>Для того чтобы войти на сайт, пожалуйста используйте Ваш <strong>Логин</strong> и <strong>пароль</strong> указанные при регистрации</p>
                        <!-- div class="row active-error"-->
                      	<input type="hidden" name="do" value="aut">
                     	<div class="row">
                            <label class="input-wrap"><input type="text" name="username" value="Логин" onblur="if (this.value == '') {this.value = 'Логин';}" onfocus="if (this.value == 'Логин') {this.value = '';}"></label>
                            <div class="error">Введите Email</div>
                        </div>
                        <div class="row">
                            <label class="input-wrap"><input type="text" name="password" value="Пароль" onblur="if (this.value == '') {this.type = 'text';this.value = 'Пароль';}" onfocus="if (this.value == 'Пароль') {this.type = 'password';this.value = '';}"></label>
                            <div class="error">Неверный пароль</div>
                        </div>
                        <div class="row">
                            <label class="ch ui-checkbox ui-checkbox-checked ui-checkbox-state-checked"><input type="checkbox" class="checkbox ui-helper-hidden-accessible" checked="checked"><span class="ui-checkbox ui-checkbox-checked ui-checkbox-state-checked"></span>Запомнить меня</label>
                            <!--a class="forgot" href="#">Забыли пароль?</a-->
                        </div>
                        <div class="row">
                            <span class="gray-btn">Вход <input type="submit" class="login-form-submit" value="" title="Вход"></span>
                        </div>
                        <div class="user_error"></div>
                        <div class="bottom-row"> 
                            <span class="note">Вход на SEVAS.ru</span>
                        </div>
                    </fieldset>
					</form>
					<form method="post" id="registration-form" name="registration" class="tab" style="display:none;">
							<fieldset>
							<p>Для того чтобы зарегистрироваться на сайте, пожалуйста заполните все поля в форме ниже</p>
							<div class="row">
								<label class="input-wrap"><input type="text" name="username" value="Желаемый логин" onblur="if (this.value == '') {this.value = 'Желаемый логин';}" onfocus="if (this.value == 'Желаемый логин') {this.value = '';}"></label>
								<div class="error">Заполните поле</div>
							</div>
							<div class="row">
								<label class="input-wrap"><input type="text" name="email" value="Email" onblur="if (this.value == '') {this.value = 'Email';}" onfocus="if (this.value == 'Email') {this.value = '';}"></label>
								<div class="error">Заполните поле</div>
							</div>
							<div class="row">
								<label class="input-wrap"><input type="text" name="password" value="Пароль" onblur="if (this.value == '') {this.type = 'text';this.value = 'Пароль';}" onfocus="if (this.value == 'Пароль') {this.type = 'password';this.value = '';}"></label>
								<div class="error">Заполните поле</div>
							</div>
							<div class="row">
								<label class="input-wrap"><input type="text" name="password_confirm" value="Пароль еще раз" onblur="if (this.value == '') {this.type = 'text';this.value = 'Пароль еще раз';}" onfocus="if (this.value == 'Пароль еще раз') {this.type = 'password';this.value = '';}"></label>
								<div class="error">Заполните поле</div>
							</div>
							<div class="row">
								<span class="gray-btn">Зарегистрировать <input id="registration-data-submit-button" value="" title="Зарегистрировать"></span>
							</div><div class="user_reg_error"></div>
							<div class="bottom-row">
								<span class="note">Регистрация на SEVAS.ru</span>
							</div>
							</fieldset>
					</form>
                    <form method="post" id="success-registration" name="success-registration" class="tab" style="display:none;">
						<fieldset>
                        	<div id="block">
                        		<p>Благодарим Вас  за pерегистрацию на сайте Sevas.ru!</p>
								<p>На указаный Вами Email было оправлено письмо с подтверждением Вашей регистрации</p>
								<p>Просим Вас перейти по ссылке из письма для активации Вашей учетной записи</p>
                            </div>
                            <div class="row">
								<span class="gray-btn">Закрыть <input id="close-registration-data-submit-button" value="" title="Закрыть"></span>
							</div>
                            <div class="bottom-row">
								<span class="note">Регистрация на SEVAS.ru</span>
							</div>
                        </fieldset>
                    </form>
				</div>
				<div class="b">&nbsp;</div>
			</div>
		</div>
</body>
</html>

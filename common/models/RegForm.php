<?php

class RegForm extends CFormModel
{
	public $login;
	public $email;
	public $password;
	public $password_repeat;

	public function rules()
	{
		return array(
			array('login, email, password, password_repeat', 'required'),
			// email has to be a valid email address
			array('email', 'email'),
			// verifyCode needs to be entered correctly
			//array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
			//array('password', 'compare'),
			
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'verifyCode'=>'Verification Code',
			'login'=>'Логин',
			'email'=>'Email',
			'password'=>'Пароль',
			'password_dub'=>'Повторить пароль',
		);
	}
}

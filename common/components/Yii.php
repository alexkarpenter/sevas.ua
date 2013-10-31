<?php

class Yii extends YiiBase
{
	/**
	 * (non-PHPdoc)
	 * @see YiiBase::app()
	 * @return SevasApplication
	 */
	public static function app() {
		return parent::app();
	}

	/**
	 * @return CWebUser
	 */
	public static function user() {
		return self::app()->user;
	}
	
	public static function createWebApplication($config=null)
	{
		require_once __DIR__.'/SevasApplication.php';
		return self::createApplication('SevasApplication',$config);
	}
	
}


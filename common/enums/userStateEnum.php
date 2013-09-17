<?php

/*
 * Состояния пользователей
 */

/**
 * Description of userStateEnum
 *
 * @author Alex
 */
class userStateEnum {
	const USER_BLOCKED = 0;
	const USER_ACTIVE = 1;
	
	static public $list = array(
		self::USER_BLOCKED => 'пользователь заблокирован',
		self::USER_ACTIVE => 'пользователь активен',
	);
}

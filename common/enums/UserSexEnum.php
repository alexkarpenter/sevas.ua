<?php
/**
 * User: Alex
 * Date: 14.10.13
 * Time: 8:40
 */

class UserSexEnum {
    const USER_WOMAN = 0;
    const USER_MAN = 1;

    static public $list = array(
        self::USER_WOMAN => 'Женщина',
        self::USER_MAN => 'Мужчина'
    );
}
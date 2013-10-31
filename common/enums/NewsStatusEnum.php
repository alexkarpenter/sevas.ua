<?php
/**
 * User: Alex
 * Date: 02.10.13
 * Time: 15:26
 */
class NewsStatusEnum {
    const DRAFT = 0;
    const PUBLISHED = 1;
    const CLOSED = 2;

    static public $list = array(
        self::DRAFT => 'черновик',
        self::PUBLISHED => 'опубликована',
        self::CLOSED => 'закрыта для пользователей'
    );
}
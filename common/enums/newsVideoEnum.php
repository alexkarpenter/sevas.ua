<?php

class newsVideoEnum {
    const NOT_EXIST = 0;
    const EXIST = 1;

    static public $list = array(
        self::NOT_EXIST => 'нет видео',
        self::EXIST => 'есть видео',
    );
}
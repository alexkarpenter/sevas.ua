<?php

class Utils
{
    static public function RusDate(){
        $translate = array(
            "am" => "дп",
            "pm" => "пп",
            "AM" => "ДП",
            "PM" => "ПП",
            "Monday" => "Понедельник",
            "Mon" => "Пн",
            "Tuesday" => "Вторник",
            "Tue" => "Вт",
            "Wednesday" => "Среда",
            "Wed" => "Ср",
            "Thursday" => "Четверг",
            "Thu" => "Чт",
            "Friday" => "Пятница",
            "Fri" => "Пт",
            "Saturday" => "Суббота",
            "Sat" => "Сб",
            "Sunday" => "Воскресенье",
            "Sun" => "Вс",
            "January" => "Января",
            "Jan" => "Янв",
            "February" => "Февраля",
            "Feb" => "Фев",
            "March" => "Марта",
            "Mar" => "Мар",
            "April" => "Апреля",
            "Apr" => "Апр",
            "May" => "Мая",
            "May" => "Мая",
            "June" => "Июня",
            "Jun" => "Июн",
            "July" => "Июля",
            "Jul" => "Июл",
            "August" => "Августа",
            "Aug" => "Авг",
            "September" => "Сентября",
            "Sep" => "Сен",
            "October" => "Октября",
            "Oct" => "Окт",
            "November" => "Ноября",
            "Nov" => "Ноя",
            "December" => "Декабря",
            "Dec" => "Дек",
            "st" => "ое",
            "nd" => "ое",
            "rd" => "е",
            "th" => "ое"
        );

        if (func_num_args() > 1) {
            $timestamp = func_get_arg(1);
            return strtr(date(func_get_arg(0),$timestamp), $translate);
        } else {
            return strtr(date(func_get_arg(0)), $translate);
        }
    }

	public static function translit($s)
	{
		static $converter = array(
				'а' => 'a',   'б' => 'b',   'в' => 'v',
				'г' => 'g',   'д' => 'd',   'е' => 'e',
				'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
				'и' => 'i',   'й' => 'y',   'к' => 'k',
				'л' => 'l',   'м' => 'm',   'н' => 'n',
				'о' => 'o',   'п' => 'p',   'р' => 'r',
				'с' => 's',   'т' => 't',   'у' => 'u',
				'ф' => 'f',   'х' => 'h',   'ц' => 'c',
				'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
				'ь' => '',  'ы' => 'y',   'ъ' => '',
				'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
	
				'А' => 'A',   'Б' => 'B',   'В' => 'V',
				'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
				'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
				'И' => 'I',   'Й' => 'Y',   'К' => 'K',
				'Л' => 'L',   'М' => 'M',   'Н' => 'N',
				'О' => 'O',   'П' => 'P',   'Р' => 'R',
				'С' => 'S',   'Т' => 'T',   'У' => 'U',
				'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
				'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
				'Ь' => '',  'Ы' => 'Y',   'Ъ' => '',
				'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
		);
		return strtr($s, $converter);
	}
	
	public static function translitForUrl($s) {
		$s = self::translit($s);
		$s = str_replace(array(' '), '_', $s);
		$s = preg_replace('#[^a-zA-Z0-9_-]#', '', $s);
		return strtolower($s);
	}
	
	/**
	 * Преобразование массива css-стилей в строку
	 * @param array $styles
	 */
	public static function htmlStylesToString($styles)
	{
		$ar = array();
		foreach ($styles as $prop => $val) {
			$ar[] = $prop.':'.$val;
		}
		return implode(';', $ar);
	}

	public static function debugLogin($login=true)
	{
		//if (!Yii::app()->user->isGuest) return;
		if ($login) {
			$ui = new UserIdentityDebug(null, null);
			$ui->authenticate();
			Yii::app()->user->login($ui);
		} else {
			Yii::app()->user->logout();
		}
	}
	
	/**
	 * include composer autoloader 
	 */
	public static function composer() {
		require __DIR__.'/../vendor/autoload.php';
	}

	public static function getPresetPathBySource($source, $preset)
	{
		$source = explode("/", $source);
		list($type, $id) = array_slice($source, -3);
		return "$preset/$type/$id";
	}
}

?>
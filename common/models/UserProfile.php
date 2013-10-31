<?php
/**
 * User: Alex
 * Date: 15.10.13
 * Time: 11:47
 */

class UserProfile extends BaseActiveRecord
{
    public static function model($className=__CLASS__){
        return parent::model($className);
    }

    public function tableName(){
        return 'user_profile';
    }

    public function attributeLabels()
    {
        return array(
            'firstname'=>'Имя',
            'lastname'=>'Фамилия',
            'birthday'=>'Дата рождения',
            'sex'=>'Пол',
        );
    }

    public function rules()
    {
        return array(
            //array('name, firstname, lastname', 'filter', 'filter'=>'trim'),
            array('firstname, lastname', 'filter', 'filter'=>'trim'),
            //array('firstname, lastname', 'required'),
            array('sex', 'safe'),
        );
    }

    public function validNickName($attribute,$params)
    {
        if(!$this->hasErrors())
        {
            if(!User::isCorrectLogin($this->{$attribute}))
            {
                $this->addError($attribute,'Логин не корректный');
            }
        }
    }

    public function relations()
    {
        return array(
            'profile' => array(self::HAS_ONE, 'UserProfile', 'user_id'),
        );
    }

    public static function getSex()
    {
        $arr_sex = array(''=>'');
        foreach(UserSexEnum::$list as $k => $v)
        {
            $arr_sex[$k] = $v;
        }
        return $arr_sex;
    }

    public static function getAllDays()
    {
        $arr = array();
        for($i = 1; $i<=31; $i++)
        {
            $arr[$i] = $i;
        }
        return $arr;
    }

    public static function getAllMonth()
    {
        return array(
            '1' => 'Январь', '2' => 'Февраль',
            '3' => 'Март', '4' => 'Апрель',
            '5' => 'Май', '6' => 'Июнь',
            '7' => 'Июль', '8' => 'Август',
            '9' => 'Сентябрь', '10' => 'Октябрь',
            '11' => 'Ноябрь', '12' => 'Декабрь',

        );
    }

    public static function getLastYears()
    {
        $start_Y = 1970;
        $end_Y = date("Y");
        $arr = array();
        for($start_Y; $start_Y<=$end_Y; $start_Y++)
        {
            $arr[$start_Y] = $start_Y;
        }
        return $arr;
    }

    public static function birthDayToInt($d, $m, $y)
    {
        if(!empty($d) && !empty($m) && !empty($y))
        {
            return strtotime("$y-$m-$d");
        }else
        {
            return false;
        }
    }

    public static function intToYMD($stamp)
    {
        if(isset($stamp))
        {
            $date = date("Y-m-d", $stamp);
            $arr = explode('-', $date);
            $arr[1] = preg_replace("/^0/", "",$arr[1]);
            $arr[2] = preg_replace("/^0/", "",$arr[2]);
            return $arr;
        }else
        {
            return false;
        }
    }

}

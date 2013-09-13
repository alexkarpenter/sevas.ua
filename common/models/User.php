<?php
/**
 * Модель User
 *
 * @property integer $id
 * @property string $name
 * @property string $password
 * @property string $state
 */
class User extends CActiveRecord 
{	
    public static function model($className=__CLASS__){
        return parent::model($className);
    }
 
    public function tableName(){
        return 'authorized.user';
    }
 
    protected function beforeSave(){
        $this->password = md5($this->password);
        return parent::beforeSave();
    }
}

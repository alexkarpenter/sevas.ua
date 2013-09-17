<?php
/**
 * Модель User
 *
 * @property integer $id
 * @property string $name
 * @property string $password
 * @property string $state
 */
class User extends BaseActiveRecord
{	
    public static function model($className=__CLASS__){
        return parent::model($className);
    }
 
    public function tableName(){
        return Yii::app()->params['auth_db'].'.user';
    }
 
    protected function beforeSave(){
        $this->password = md5($this->password);
        return parent::beforeSave();
    }
	
	public function getAvatarUrl()
	{
		return "/uploads/users/$this->id/$this->avatar";
	}
	
	public function isBlocked()
	{
		return $this->state==userStateEnum::USER_BLOCKED;
	}
}

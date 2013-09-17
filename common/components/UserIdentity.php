<?php

class UserIdentity extends CUserIdentity {
    // Будем хранить id.
    protected $_id;
 
    // Данный метод вызывается один раз при аутентификации пользователя.
    public function authenticate(){
		
        // Производим стандартную аутентификацию, описанную в руководстве.
        $user = User::model()->find('LOWER(name)=? AND state=?', array(strtolower($this->username), userStateEnum::USER_ACTIVE));
        if(($user===null) || ($this->password!==$user->password)) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else {
            $this->_id = $user->id;
            $this->username = $user->name;
            $this->errorCode = self::ERROR_NONE;
        }
       return !$this->errorCode;
    }
 
    public function getId(){
        return $this->_id;
    }
}
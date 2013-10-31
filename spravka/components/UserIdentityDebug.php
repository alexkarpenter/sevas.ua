<?php

class UserIdentityDebug extends CUserIdentity {

	protected $u;
	protected $_id;
 
    public function authenticate() {
		
    	$this->u = $u = User::model()->find();
    	
		$this->_id = $u->id;
		$this->username = $u->username;
		$this->errorCode = self::ERROR_NONE;
		return true;
    }
 
    public function getId(){
        return $this->_id;
    }
}
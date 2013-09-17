<?php

class WebUser extends CWebUser {
	private $_model = null;
	
    public function checkRole($roleName)
	{
		return (Yii::app()->user->id ===NULL)? false : array_key_exists($roleName, Yii::app()->authManager->getRoles(Yii::app()->user->id));
	}
	
	public function getStatus()
	{
		if($user = $this->getModel())
		{
			return $user->state;
		}
	}
	
	public function isBlocked()
	{
		if($user = $this->getModel())
		{
			return $user->isBlocked();
		}
	}

	private function getModel(){
        if (!$this->isGuest && $this->_model === null){
            $this->_model = User::model()->find('id=:id',array('id' => $this->id));
        }
        return $this->_model;
    }
}

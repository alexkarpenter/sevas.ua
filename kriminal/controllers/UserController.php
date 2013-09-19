<?php
class UserController extends Controller
{
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		
		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}
	
	public function actionReg()
	{
		$model = new RegForm;
		
		if(isset($_POST['RegForm']))
		{
			$login = $_POST['RegForm']['login'];
			$email = $_POST['RegForm']['email'];
			$password = $_POST['RegForm']['password'];
			//$password_repeat = $_POST['RegForm']['password_repeat'];
			
			$gen_code = '';
			for($i=0; $i<15; $i++) {
				$gen_code.= chr(rand(65,90));
			}
			
			$user = new User;
			$user->name = $login;
			$user->password = $password;
			$user->state = userStateEnum::WAITING_REG;
			$user->email = $email;
			$user->once_pass = $gen_code;
			$user->save();
			
			$link_finish_reg = $this->createUrl('user/activation', array('code'=>$gen_code));

		}
		$this->render('reg', array('RegForm' => $model));

	}
	
	public function actionActivation()
	{
	
		if(isset($_GET['code']))
		{
			$user = User::model()->find(array(
				'condition' => 'once_pass=:code AND state=:state',
				'params' => array(
						':code' => $_GET['code'],
						':state' => userStateEnum::WAITING_REG
					)
			));
			
			if(!$user)
			{
				Yii::app()->user->setFlash('error',"Код подтверждения не найден!");
				$this->redirect( Yii::app()->createUrl('news/index') );
			}

			$user->once_pass = 'NULL';
			$user->state = userStateEnum::USER_ACTIVE;
			$user->save();

			Yii::app()->user->setFlash('success', $user->name.", вы зарегистрированы!");
			$this->redirect( Yii::app()->createUrl('news/index') );			
		}else{
			Yii::app()->user->setFlash('error',"Не указан код подтверждения!");
			$this->redirect( Yii::app()->createUrl('news/index') );
		}
		
		
	}

	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	
}
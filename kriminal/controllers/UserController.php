<?php
class UserController extends Controller
{
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
//		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
//		{
//			echo CActiveForm::validate($model);
//			Yii::app()->end();
//		}

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

	
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	public function actionCreateUR()
	{
		$auth = Yii::app()->authManager;
		
		$auth->createOperation('viewsNews','просмотр новостей');
		$auth->createOperation('createKriminalNews','создание новости Криминал');
		$auth->createOperation('updateKriminalNews','редактирование новости Криминал');
		$auth->createOperation('deleteKriminalNews','удаление новости Криминал');
		
		$task = $auth->createTask('manageKriminalNews', 'Управление новостями Криминала');
		$task->addChild('createKriminalNews');
		$task->addChild('updateKriminalNews');
		$task->addChild('deleteKriminalNews');
		
		$role = $auth->createRole('guest');
		$role->addChild('viewsNews');
		
		$role = $auth->createRole('authorizedUser');
		//$guest->addChild('addComment');
		$role->addChild('guest');
		
		$role = $auth->createRole('publicistKriminal');
		$role->addChild('manageKriminalNews');
		$role->addChild('authorizedUser');
		
		$role = $auth->createRole('admin');
		
		$auth->assign('admin', 1);
	}
}
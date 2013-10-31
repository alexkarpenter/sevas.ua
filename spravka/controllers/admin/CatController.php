<?php

class CatController extends SpravBaseController
{
	
	public function filters()
	{
		return array(
			//'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionCreate()
	{
		$model=new Category;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Category']))
		{
			$model->attributes=$_POST['Category'];
			
			if ($model->idcatparent)
			{
				$parent = Category::model()->findByPk($model->idcatparent);
				if ($model->appendTo($parent))
					$this->redirect(array('view','id'=>$model->id));
			}
			else
			{
				if($model->saveNode())
					$this->redirect(array('view','id'=>$model->id));

			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Category']))
		{
			$idcatparent0 = $model->idcatparent;
			
			$model->attributes=$_POST['Category'];
			$model->imgFile = CUploadedFile::getInstance($model, 'imgFile');
			
			$parentNotChanged = $idcatparent0 == $model->idcatparent;
				
			if ($parentNotChanged)
			{
				if($model->saveNode())
					$this->redirect(array('view','id'=>$model->id));

			}
			else // parent changed
			{
				$p2 = Category::model()->findByPk($model->idcatparent);
				if (empty($p2))
				{
					$updated = $model->moveAsRoot();
				}
				else
				{
					$updated = $model->moveAsLast($p2);
				}
				
				if ($updated)
					$model->saveNode() && $this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionMoveUp($id)
	{
		$c = $this->loadModel($id);
		if (!$c->isRoot())
		{
			$prevc = $c->prev()->find();
			if ($prevc)
			{
				$c->moveBefore($prevc);
			}
		}
	}
	
	public function actionMoveDn($id)
	{
		$c = $this->loadModel($id);
		if (!$c->isRoot())
		{
			$nextc = $c->next()->find();
			if ($nextc)
			{
				$c->moveAfter($nextc);
			}
		}
	}
	
	
	public function actionDelete($id)
	{
		$this->loadModel($id)->deleteNode();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Category');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAdmin()
	{
		$this->layout = 'spravka.views.layouts.main';
		
		$model=new Category('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Category']))
			$model->attributes=$_GET['Category'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * @return Category
	 */
	public function loadModel($id)
	{
		$model=Category::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='category-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

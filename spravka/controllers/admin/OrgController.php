<?php

class OrgController extends SpravBaseController
{

	public function actions()
	{
		return array(
				'upload'=>array(
						'class'=>'common.extensions.xupload.actions.XUploadAction',
						'path' => Yii::app()->getBasePath() . "/www/uploads",
						'publicPath' => Yii::app()->getBaseUrl() . "/uploads",
				),
				'attachmentUpload' => array(
					'class' => 'ext.attachment.CAttachmentAction',
					'hostModelType' => 'Organization',
				),
				'tagLoad' => array(
					'class' => 'TagLoadAction',
					'modelType' => 'Tag',
				)
		);
	}
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			//'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
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

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($slug)
	{
		$this->render('view',array(
			'o'=>$this->loadModel($slug),
		));
	}

	public function actionCreate()
	{
		$this->createUpdate();
	}

	public function actionUpdate($id)
	{
		$this->createUpdate($id);
	}
	
	public function createUpdate($id=null)
	{
		$o = $id ? $this->loadModel($id) : new Organization();
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($o);
		
		if(isset($_POST['Organization']))
		{
			try {
				$trx = $o->dbConnection->beginTransaction();
					
				$o->attributes = $post = $_POST['Organization'];
				$o->attachFiles->collectUserInput($post);
				$o->attachFiles->updateRelation();
				$o->setMainPhotoIndex($_POST['Organization']['mainPhotoIndex']); // еще раз, после регистрации файлов
		
				if ($o->withRelated->validate(array('files'))) {
						
					if ($o->save(false)) {
						
						if ($o->attachFiles->hasErrors()) {
								
							Yii::user()->setFlash('error', 'save errors');
							$trx->rollback();
								
						} else {
								
							$trx->commit();
							Yii::user()->setFlash('success', 'org saved');
							
							if (@$_POST['apply'])
								$this->redirect(array('update', 'id'=>$o->id));
							else
								$this->redirect(array('sprav/org', 'slug'=>$o->slug));
								
							
						}
						
					}
						
				}
		
			}
			catch (Exception $e) {
				$trx->rollback();
				throw $e;
			}
		
		}
		
		$this->render($id ? 'update' : 'create', array(
				'o'=>$o,
		));
		
	}
	
	/*
	 * 
	 * TESTCODE
	 * 
	 */
	public function actionFile2($id)
	{
		$o=$this->loadModel($id);
	
		if(isset($_POST['Organization']))
		{
			try {
				$trx = $o->dbConnection->beginTransaction();
				
				$o->attributes = $post = $_POST['Organization'];
				$o->attachImage->collectUserInput($post);
				$o->attachFiles->collectUserInput($post);
				$o->attachImage->updateRelation();
				$o->attachFiles->updateRelation();
				
				if ($o->withRelated->validate(array('image', 'files'))) {
					
					//if ($o->withRelated->save(false, array('image', 'files'))) {
					if ($o->save(false)) {
					
						if ($o->attachImage->hasErrors() || $o->attachFiles->hasErrors()) {
							
							Yii::user()->setFlash('error', 'save errors');
							$trx->rollback();
							
						} else {
							
							$trx->commit();
							Yii::user()->setFlash('success', 'org saved2');
							$this->redirect(array('file2','id'=>$o->id));
							
						}
					}
				
				} else {
					Yii::user()->setFlash('error', 'errors: '.var_export($o->getErrors(), true));
					
					$trx->rollback();
				}
			
			}
			catch (Exception $e) {
				$trx->rollback();
				throw $e;
			}
				
		}

		$this->render('file2',array(
				'o'=>$o,
		));
	}
	
	public function actionUploadFile()
	{
		
	}
	
	public function actionDelete($id)
	{
		try {
// 			$trx = Yii::app()->db->beginTransaction();
			 
			if (!$this->loadModel($id)->delete())
				throw new Exception('delete error');

// 			$trx->commit();
		} catch (Exception $e) {
			throw $e;
		}
		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Organization');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$o=new Organization('search');
		$o->unsetAttributes();  // clear any default values
		if(isset($_GET['Organization']))
			$o->attributes=$_GET['Organization'];

		$this->render('admin',array(
			'o'=>$o,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Organization the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$o = is_numeric($id) ? 
			Organization::model()->findByPk($id) :
			Organization::model()->findByAttributes(array('slug' => $id));
		
		if($o===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $o;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Organization $o the model to be validated
	 */
	protected function performAjaxValidation($o)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='organization-form')
		{
			echo CActiveForm::validate($o);
			Yii::app()->end();
		}
	}
}

<?php

/**
 *
 * @property CommentModule $module
 *
 * @author Carsten Brandt <mail@cebe.cc>
 * @package yiiext.modules.comment
 */
class CommentController extends CController
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return $this->module->controllerFilters;
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return $this->module->controllerAccessRules;
	}

	/**
	 * Creates a new comment.
	 *
	 * On Ajax request:
	 *   on successfull creation comment/_view is rendered
	 *   on error comment/_form is rendered
	 * On POST request:
	 *   If creation is successful, the browser will be redirected to the
	 *   url specified by POST value 'returnUrl'.
	 */
	public function actionCreate()
	{
		$commentModel = Yii::app()->request->getParam('commentModel') ?: $this->module->commentModelClass;
		$commentableModel = Yii::app()->request->getParam('commentableModel');
		
		/** @var Comment $comment */
		$comment = Yii::createComponent($commentModel);
		
		if (!($comment instanceof Comment))
			throw new Exception(null, 404);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST[$cClass=get_class($comment)]))
		{
			$comment->attributes = $_POST[$cClass];
			$comment->type = $_POST[$cClass]['type'];
			$comment->key  = $_POST[$cClass]['key'];

			// determine current users id
			if (Yii::app()->user->isGuest) {
				$comment->userId = null;
			} else {
				$comment->userId = Yii::app()->user->id;
			}

			if(Yii::app()->request->isAjaxRequest) {
				$formSuffix = $cClass != 'Comment' ? $cClass : '';
				$output = '';
				if($comment->save())
				{
					// refresh model to replace CDbExpression for timestamp attribute
					$comment->refresh();

					// render new comment
					$output .= $this->widget('comment.widgets.CommentsWidget', array(
						'view' => '_view'.$formSuffix,
						'comment' => $comment,
						'commentableType' => $commentableModel,
					), true); 
					// create new comment model for empty form
					$comment = Yii::createComponent($commentModel);
					$comment->type = $_POST[$cClass]['type'];
					$comment->key  = $_POST[$cClass]['key'];
				}
				// render comment form
				$output .= $this->widget('comment.widgets.CommentsWidget', array(
						'view' => '_form'.$formSuffix,
						'comment' => $comment,
						'commentableType' => $commentableModel,
				), true);
				
				// render javascript functions
				Yii::app()->clientScript->renderBodyEnd($output);
				echo $output;
				Yii::app()->end();
			} else {
				if($comment->save()) {
					$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('view','id'=>$comment->id));
				} else {
					// @todo: what if save fails?
				}
			}
		} else {
			throw new Exception(null, 404);
		}

	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$commentModel = Yii::app()->request->getParam('commentModel');
		$commentableModel = Yii::app()->request->getParam('commentableModel');
		$comment = $this->loadModel($id, $commentModel);
		$comment->setType($commentableModel);
		$comment->validateType2();
		$formSuffix = $commentModel != 'Comment' ? $commentModel : '';
		
		if(isset($_POST[$cClass=get_class($comment)]))
		{
			$comment->attributes = $_POST[$cClass];
				
			if ($comment->save())
			{
				if(Yii::app()->request->isAjaxRequest) {
					// refresh model to replace CDbExpression for timestamp attribute
					$comment->refresh();

					// render updated comment
					$this->widget('comment.widgets.CommentsWidget', array(
							'view' => '_view'.$formSuffix,
							'comment' => $comment,
							'commentableType' => $commentableModel,
					));
// 					$this->renderPartial('_view'.$formSuffix,array(
// 						'data'=>$comment,
// 					));
					Yii::app()->end();
				} else {
					$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('view','id'=>$comment->id));
				}
			}
		}

		if(Yii::app()->request->isAjaxRequest)
		{
			$output = $this->widget('comment.widgets.CommentsWidget', array(
					'view' => '_form'.$formSuffix,
					'comment' => $comment,
					'commentableType' => $commentableModel,
			), true);
				
// 			$output = $this->renderPartial('_form'.$formSuffix,array(
// 				'comment'=>$comment,
// 				'commentableModel' => $commentableModel,
// 				'ajaxId'=>time(),
// 			), true);
			// render javascript functions
			Yii::app()->clientScript->renderBodyEnd($output);
			echo $output;
			Yii::app()->end();
		}
		else
		{
			$this->render('update',array(
				'model'=>$comment,
			));
		}
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
		$id = Yii::app()->request->getParam('id');
		$commentModel = Yii::app()->request->getParam('commentModel');
		$commentableModel = Yii::app()->request->getParam('commentableModel');
		$comment = $this->loadModel($id, $commentModel);
		$comment->setType($commentableModel);
		$comment->validateType2();
		
		// we only allow deletion via POST request
		if(Yii::app()->request->isPostRequest)
		{
			if (!Yii::app()->user->isGuest && (Yii::app()->user->id == $comment->userId))
			{
				$comment->delete();

				// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
				if (!Yii::app()->request->isAjaxRequest) {
					$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
				}
			}
			else {
				throw new CHttpException(403,'Only comment owner can delete his comment.');
			}
		}
		else {
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
	}

	/**
	 * Manages all models.
	 */
	/*public function actionAdmin()
	{
		$model=Yii::createComponent($this->module->commentModelClass, 'search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Comment']))
			$model->attributes=$_GET['Comment'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}*/

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 * @return Comment
	 */
	public function loadModel($id, $type=null)
	{
		$model = Yii::createComponent(@$type ?: $this->module->commentModelClass)->findByPk((int) $id);
		if ($model === null || !($model instanceof Comment)) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='comment-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

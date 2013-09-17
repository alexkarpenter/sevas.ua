<?php

class BaseNewsController extends Controller
{
	public function actionIndex()
	{
		$countNews = 3;
		$count = $_GET['count']?$_GET['count']:0;
		
		$model=News::model()->findAll(array(
			'order'=>'date DESC',
			'limit' => 3,
		));
		
		if(Yii::app()->request->isAjaxRequest)
		{
			$model=News::model()->findAll(array(
				'order'=>'date DESC',
				'limit' => $count + $countNews,
			));
			$this->renderPartial('_news_list', array('model'=>$model));
		}
		else
		{
			$this->render('index' ,array('model'=>$model));
		}
	}
	
	public function actionView()
	{
		$url = $_GET['url'];
		$model=News::model()->find(array(
			'condition'=>'url=:urlID',
			'params'=>array(':urlID'=>$url),
		));
		$this->render('view', array('model'=>$model));
	}
}
?>

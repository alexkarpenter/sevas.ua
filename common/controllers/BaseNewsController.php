<?php

class BaseNewsController extends Controller
{
	public function filters() {
        return array(
            'accessControl', 
        );
    }
	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('deletecomment'),
				'roles'=>array('admin'),
			),
			array('deny',  
				'actions'=>array('deletecomment'),
				'users'=>array('*'),
			),
		);
	}
	
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
			$model= News::model()->findAll(array(
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
		if(!isset($_GET))
		{
			$this->redirect(array('news/index'));
		}	
		
		$commentForm = new CommentForm();
		
		$url = $_GET['url'];

		$model=News::model()->find(array(
			'condition'=>'url=:urlID',
			'params'=>array(':urlID'=>$url),
		));
		
		$this->render('view', array(
									'model'=>$model, 
									'commentForm' => $commentForm, 
									'url' => $url
								));
	}
	
	public function actionAddComment()
	{
		$comment = new Comment;
		$url = $_GET['url'];
		$dt = strtotime(date('Y-m-h'));
		$comm = $_POST['CommentForm']['comment'];
		
		$comment->user_id = Yii::app()->user->id;
		$comment->news_id = News::getIdByUrl($url);
		$comment->text = $comm;
		$comment->create_date = $dt;
		
		$comment->save();	
		
		$this->redirect(array('news/view', 'url'=>$url));
	}
	
	public function actionDeleteComment()
	{
		$id_comment = $_GET['id_comment'];
		$back_url = $_GET['back_url'];
		
		Comment::model()->deleteAll(
						array(
							'condition' => 'id=:id',
							'params'=>array(':id'=>$id_comment),
						)
					);
		
		$this->redirect(array('news/view', 'url'=>$back_url));
	}

}
?>



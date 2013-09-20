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
		$count = isset($_GET['count'])? $_GET['count']:0;

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
			$this->renderPartial('common.views.news._news_list', compact('model'));
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
		$url = $_GET['url'];
		
		if(isset($_POST['CommentForm']))
		{
			$comment = new Comment;
			
			$dt = strtotime(date('Y-m-d H:i:s'));
			$comm = $_POST['CommentForm']['comment'];

			$comment->user_id = Yii::app()->user->id;
			$comment->news_id = News::getIdByUrl($url);
			$comment->text = $comm;
			$comment->create_date = $dt;

			$comment->save();
		}
		
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
	
	public function actionCreateNews()
	{
		$news_form = new NewsForm;
		
		if(isset($_POST['NewsForm']))
		{
			//var_dump($_POST['NewsForm']);die;
			$model = new News;
			$model->attributes=$_POST['NewsForm'];
			$news = $_POST['NewsForm'];
			var_dump($news['fl_block']);die;
			
			if($model->validate())
			{
				$model->name = $news['name'];
				$model->title = $news['title'];
				$model->name_h1 = $news['h1'];
				$model->keywords = $news['keywords'];
				$model->category_id = $news['name_category'];
				$model->text_description = $news['text_description'];
				$model->text = $news['text'];
				$model->date = strtotime(date('Y-m-d H:i:s'));
				$model->date = $news['fl_block'];
				$model->save();
				
				Yii::app()->user->setFlash('notice','Новость добавлена');
				$this->refresh();
			}	
			
		}
		
		$this->render('new', array(
									'news_form'=>$news_form
								));
		
		
	}

}
?>
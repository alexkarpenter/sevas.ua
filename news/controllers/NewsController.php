<?php

class NewsController extends Controller
{
    public function actions()
    {
        return array(
            'attachmentUpload' => array(
                'class' => 'common.extensions.attachment.CAttachmentAction',
                'hostModelType' => 'News',
            ),
        );
    }

    public function actionIndex()
    {
        $countNews = 10;
        $count = isset($_GET['count'])? $_GET['count']:0;

        //Кнопка "Показать еще новости"
        if(Yii::app()->request->isAjaxRequest)
        {
            $model= News::model()->findAll(array(
                'order'=>'date DESC',
                'limit' => $count + $countNews,
            ));
            $this->renderPartial('_news_list', compact('model'));
            Yii::app()->end;
        }

        $find_params = array(
            'order'=>'date DESC',
            'limit' => $countNews,
        );

        if($category = $_GET['category'])
        {
            $model_category = NewsCategory::model()->find(array(
                'condition' => 'name=:category_name',
                'params' => array(
                    ':category_name' => $_GET['category'],
                )
            ));

            if($model_category)
            {
                $find_params = array(
                    'condition'=>'category_id='.$model_category->id,
                    'order'=>'date DESC',
                    'limit' => $countNews,
                );
            }
            else
            {
                throw new CHttpException(404, 'Извините, но у нас нет такой страницы, зато есть много других интересных!');
            }
        }

        $model=News::model()->findAll($find_params);

        $this->render('index' ,array('model'=>$model));
    }

    public function actionView()
    {
        if(!isset($_GET))
        {
            $this->redirect(array('news/index'));
        }

        $commentForm = array();//new CommentForm();

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

            $comment_model=News::model()->find(array(
                'select'=>'count_coment',
                'condition'=>'id=:id',
                'params'=>array(':id'=>$comment->news_id),
            ));

            News::model()->updateByPk($comment->news_id, array('count_coment'=>$comment_model->count_coment +1));
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

    public function actionEdit()
    {
		Yii::app()->bootstrap->register();
        $fileModel = new File();

        if(isset($_GET['id']))
        {
            $model = $this->loadModel($_GET['id']);
        }
        else
        {
            $model = new News;
        }

        if(isset($_POST['News']))
        {
            try{
                $trx = Yii::app()->db->beginTransaction();

                $model->attributes = $post = $_POST['News'];
                $model->attachFiles->collectUserInput($post);
                $model->attachFiles->updateRelation();
                $model->setRelationsWithFiles();
                $model->author_id = Yii::app()->user->id;

                if($model->withRelated->validate(array('image')))
                {
                    if (!$model->attachFiles->hasErrors())
                    {
                        if($model->isNewRecord)
                        {
                            if($model->save(false))
                            {
                                if(isset($_POST['Category']))
                                {
                                    NewsCategoryRelation::addCategory($_POST['Category'], $model->id);
                                }
                                $trx->commit();
                                $this->successTo('Новость добавлена', 'news/list');
                            }
                            else
                            {
                                $trx->rollback();
                            }
                        }
                        else
                        {
                            if($model->save(false))
                            {
                                if(isset($_POST['Category']))
                                {
                                    NewsCategoryRelation::addCategory($_POST['Category'], $model->id);
                                }
                                $trx->commit();
                                $this->successTo('Новость обновлена', 'news/list');
                            }
                            else
                            {
                                $trx->rollback();
                            }
                        }
                    }
                    else
                    {
                        $trx->rollback();
                    }
                }
            }
            catch (Exception $e)
            {
                $trx->rollback();
                throw $e;
            }
        }

        $this->render('edit', array(
            'model' => $model,
            'fileModel' => $fileModel,
        ));
    }

    public function actionList()
    {
        $dataProvider = new CActiveDataProvider('News', array(
            'criteria'=>array(
                'order'=>'create_date DESC',
            ),
            'pagination'=>array(
                'pageSize'=>10,
            ),
        ));

        $this->render('list', array(
            'dataProvider'=>$dataProvider,
        ));
    }

    public function actionDelete()
    {
        if(isset($_GET['id']) && News::model()->findByPk($_GET))
        {
            News::model()->deleteByPk($_GET['id']);
            $this->successTo('Запись удалена', 'news/list');
        }else
        {
            $this->errorTo('Отсутствие записи для удаления', 'news/list');
        }
    }

    public function actionRating()
    {
        $return = false;
        $id_news = $_GET['id_news']?(int)$_GET['id_news']:false;
        $rating = isset($_GET['rating'])?(int)$_GET['rating']:false;

        $hasRating=Rating::model()->count(array(
            'condition'=>'user_id=:user_id AND obj_id=:obj_id',
            'params'=>array(':user_id'=>Yii::app()->user->id, ':obj_id'=>$id_news),
        ));
        if($hasRating < 1 && $id_news && $rating!==false)
        {
            $model = new Rating();
            $model->obj_id = $id_news;
            $model->user_id = Yii::app()->user->id;
            $model->rating = $rating;
            $model->save();

            $news_model=News::model()->find(array(
                'select'=>'rating_up, rating_down',
                'condition'=>'id=:id',
                'params'=>array(':id'=>$id_news),
            ));

            if($model->rating == NewsRatingEnum::RATING_UP)
            {
                $return = News::model()->updateByPk($id_news, array('rating_up'=>$news_model->rating_up +1));
            }
            elseif($model->rating == NewsRatingEnum::RATING_DOWN)
            {
                $return = News::model()->updateByPk($id_news, array('rating_down'=>$news_model->rating_down +1));

            }
        }
        if($return)
        {
            echo 'success';
        }
        else
        {
            echo 'error';
        }
    }

    public function actionRatingComments()
    {
        $return = false;
        $id_com = $_GET['id_com']?(int)$_GET['id_com']:false;
        $rating = isset($_GET['rating'])?(int)$_GET['rating']:false;

        $hasRating=Rating::model()->count(array(
            'condition'=>'user_id=:user_id AND obj_id=:obj_id',
            'params'=>array(':user_id'=>Yii::app()->user->id, ':obj_id'=>$id_com),
        ));

        if($hasRating < 1 && $id_com && $rating!==false)
        {
            $model = new Rating();
            $model->obj_id = $id_com;
            $model->user_id = Yii::app()->user->id;
            $model->rating = $rating;
            $model->save();

            $comment_model=Comment::model()->find(array(
                'select'=>'rating_up, rating_down',
                'condition'=>'id=:id',
                'params'=>array(':id'=>$id_com),
            ));

            if($model->rating == NewsRatingEnum::RATING_UP)
            {
                $return = Comment::model()->updateByPk($id_com, array('rating_up'=>$comment_model->rating_up +1));
            }
            elseif($model->rating == NewsRatingEnum::RATING_DOWN)
            {
                $return = Comment::model()->updateByPk($id_com, array('rating_down'=>$comment_model->rating_down +1));

            }
        }
        if($return)
        {
            echo 'success';
        }
        else
        {
            echo 'error';
        }
    }

    public function actionViewNews()
    {
        $return = false;
        $id_news = $_GET['id_news']?(int)$_GET['id_news']:false;

        if ($id_news)
        {
            $view_news_model = News::model()->find(array(
                'select' => 'count_veiw',
                'condition' => 'id=:id',
                'params' => array(':id' => $id_news),
            ));

            $return = News::model()->updateByPk($id_news, array('count_veiw' => $view_news_model->count_veiw + 1));
        }
        if($return)
        {
            echo 'success';
        }
        else
        {
            echo 'error';
        }
    }

	public function actionSetCat()
    {
        $cat = NewsCategory::model()->findAll();

        $obj = array();
        foreach($cat as $c)
        {
            $obj[$c['attributes']['id']]['prnts'] = $this->myPrnts($c['attributes']['id']);
            $obj[$c['attributes']['id']]['chlds'] = $this->myChlds($c['attributes']['id']);
        }
        echo CJavaScript::jsonEncode($obj);
    }

    public function myPrnts($id)
    {
        $arr = array();
        $category = NewsCategory::model()->findByPk($id);
        $results = $category->ancestors()->findAll();

        foreach($results as $res)
        {
            array_push($arr, $res['attributes']['id']);
        }

        return $arr;
    }

    public function myChlds($id)
    {
        $arr = array();
        $category = NewsCategory::model()->findByPk($id);
        $results = $category->descendants()->findAll();

        foreach($results as $res)
        {
            array_push($arr, $res['attributes'][id]);
        }

        return $arr;
    }

    public function loadModel($id)
    {
        $model = News::model()->findByPk($id);
        if($model === null)
            throw new CHttpException(404, 'Запись не найдена');
        return $model;
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }
}

<?php
class PopularNews extends CWidget {
 
    public function run() {
            $t = time()-608400;
            $popular_news_model=News::model()->findAll(array(
                'select'=>'*',
                'condition'=>'create_date>:create_date AND category_id=:category_id AND status=:status',//right
                'params'=>array(':create_date'=>$t, ':category_id'=>1, ':status'=>'0'),
                'order' => 'count_veiw DESC',
                'limit' => 5,
            ));    
            $this->render('common.widgets.popularnews.view.popularnews', array('popular_news_model'=>$popular_news_model));

    }
}
?>
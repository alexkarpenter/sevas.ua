<?php
class TalkingNow extends CWidget {
 
    public $params = array(
        'action'=>'index',
    );
 
    public function run() {
          $talkingnow_model_comment=Comment::model()->findAll(array(
                'select'=>'DISTINCT news_id',
                'order' => 'id DESC',
                'limit' => 5,
            ));
          
          if(count($talkingnow_model_comment) > 0){
              
              foreach($talkingnow_model_comment as $talkingnow_model){
                $talkingnow_model_news=News::model()->findAll(array(
                    'select'=>'*',
                    'condition'=>'id=:id AND status=:status',
                    'params'=>array(':id'=>$talkingnow_model->news_id, ':status'=>'0'),
                    'order' => 'id DESC',
                    'limit' => 5,
                ));
                foreach ($talkingnow_model_news as $talkingnow) {

                  if ($talkingnow->rating_up == '0') $plus_znak = '';
                  else $plus_znak = '+';
                  if ($talkingnow->rating_down == '0') $minus_znak = '';
                  else $minus_znak = '-';
                                        
                  $list = $list.'<li>
                          <ul class="news-list" id="newsNumber-'.$talkingnow->id.'"><li class='.$talkingnow->id.'>
                                <div class="row"><div class="news_link name2"><a href="/news/'.$talkingnow->url.'">'.$talkingnow->name.'</a></div>
                                <div class="wrap-info">
                                    <div class="up-down"> 
                                      
                                        <input type="hidden" class="id_user" value="">
                                        <div class="up">
                                            <a class="ra_up">up</a>
                                            <span class="s_up">'.$plus_znak . $talkingnow->rating_up.'</span>
                                        </div>
                                        <div class="down">
                                            <a class="ra_down">down</a>
                                            <span class="s_down">'.$minus_znak . $talkingnow->rating_down.'</span>
                                        </div>
                                    </div>
                                    <div class="statistics">
                                        <div class="comment">Комментариев:<span>'.$talkingnow->count_coment.'</span></div>
                                    </div>
                                </div>
                            </div></li>
                        </ul>
                       
                    </li>';
                }
                
             }  
             $this->render('common.widgets.talkingnow.view.talkingnow',array('list' => $list));
        }
   }
}
?>
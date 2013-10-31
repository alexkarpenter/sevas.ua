<?php

class NewsCategoryRelation extends CActiveRecord
{
    public static function model($className=__CLASS__){
        return parent::model($className);
    }

    public function tableName(){
        return 'news_category_relation';
    }

    public static function addCategory($cat_mas, $news_id)
    {
        if(isset($cat_mas) && isset($news_id))
        {
            $criteria=new CDbCriteria;
            $criteria->condition = 'news_id = :news_id';
            $criteria->params = array(':news_id' => $news_id);

            NewsCategoryRelation::model()->deleteAll($criteria);

            foreach($cat_mas as $k => $v)
            {
                $newsCat = new NewsCategoryRelation();
                /*$transaction=$newsCat->dbConnection->beginTransaction();
                try
                {*/
                    $newsCat->category_id = $v;
                    $newsCat->news_id = $news_id;
                    $newsCat->save();
                   /* if($newsCat->save())
                        $transaction->commit();
                    else
                        $transaction->rollback();*/
                /*}
                catch(Exception $e)
                {
                    $transaction->rollback();
                    throw $e;
                }*/

            }
        }
    }

    /**
     * @param $news_id
     * @return array|bool, where array associativ massive, type of [category_id] => bool(true)
     */
    public static function getCategoryByNewsId($news_id)
    {
        if(!isset($news_id))
            return false;
        else
        {
            $criteria=new CDbCriteria;
            $criteria->condition = 'news_id = :news_id';
            $criteria->params = array(':news_id' => $news_id);
            $model = self::model()->findAll($criteria);
            if ($model != null)
                {
                    $arr = array();
                    foreach($model as $item)
                    {
                        $arr[$item->category_id] = true;
                    }
                    return $arr;
                }
            else
                return false;
        }
    }
}

?>
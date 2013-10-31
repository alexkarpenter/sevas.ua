<?php

class NewsCategory extends CActiveRecord
{
	public static function model($className=__CLASS__){
        return parent::model($className);
    }
 
    public function tableName(){
        return 'news_category';
    }

    public function behaviors()
    {
        return array(
            'nestedSetBehavior'=>array(
                'class'=>'common.extensions.NestedSetBehavior.NestedSetBehavior',
                'leftAttribute'=>'lft',
                'rightAttribute'=>'rgt',
                'levelAttribute'=>'level',
            ),
        );
    }

    //get tree with child nodes by root
    public static function getCriterionByRoot($root)
    {
        if(isset($root))
        {
            $criteria=new CDbCriteria;
            $criteria->order = 't.root, t.lft'; // or 't.root, t.lft' for multiple trees
            $criteria->condition = 'root = :root';
            $criteria->params = array(':root' => $root);
            return Category::model()->findAll($criteria);
        }else{
            return false;
        }
    }

}

?>

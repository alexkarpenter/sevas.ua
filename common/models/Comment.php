<?php

/*
 * Модель Comment
 */

/**
 * Description of Comment
 *
 * @author Alex
 */
class Comment extends BaseActiveRecord
{
	public static function model($className=__CLASS__){
        return parent::model($className);
    }
 
    public function tableName(){
        return Yii::app()->params['kriminal_db'].'.comment';
    }
	
	public function relations()
	{
		return array(
		    'rating' => array(self::HAS_MANY, 'Rating', 'obj_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'news' => array(self::BELONGS_TO, 'News', 'news_id')
 		);
	}
}

?>

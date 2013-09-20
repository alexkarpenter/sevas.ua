<?php

/*
 * News class.
 */

class News extends BaseActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return Yii::app()->params['kriminal_db'].'.news';
	}
	
	public function relations()
	{
		return array(
		    'rating' => array(self::HAS_MANY, 'Rating', 'obj_id'),
			'relation_news' => array(self::HAS_MANY, 'RelationNews', 'news_id'),
			'coordinate_news' => array(self::HAS_ONE, 'CoordinateNews', 'news_id'),
			'comments' => array(self::HAS_MANY, 'Comment', 'news_id'),
			'category' => array(self::HAS_ONE, 'Category', 'category_id')
 		);
	}
	
	public static function getIdByUrl($url)
	{
		$model=News::model()->find(array(
				'condition'=>'url=:urlID',
				'params'=>array(':urlID'=>$url),
			));
		
		return (int)($model->id);
	}
	
}

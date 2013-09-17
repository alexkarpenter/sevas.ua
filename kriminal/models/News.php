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
		    'rating' => array(self::HAS_MANY, 'Rating', 'news_id'),
			'relation_news' => array(self::HAS_MANY, 'RelationNews', 'news_id'),
			'spravka_link' => array(self::HAS_MANY, 'SpravkaLink', 'news_id'),
			'coordinate_news' => array(self::HAS_ONE, 'CoordinateNews', 'news_id')
 		);
	}
	
	
}
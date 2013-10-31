<?php

/**
 * модель-отзыв об организации
 * 
 * @property integer $rating
 *
 */
class Review extends Comment
{

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return CommentModule the comment module instance
	 */
	public function getModule()
	{
		return Yii::app()->getModule('comment');
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'review';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('rating, message', 'required'),
			array('rating', 'numerical', 'integerOnly'=>true),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return parent::relations();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array_merge(
				parent::attributeLabels(),
				array(
					'rating' => 'Ваша оценка',
					'message' => 'Отзыв',
				)
		);
	}
}

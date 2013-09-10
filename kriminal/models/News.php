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
		return '{{news}}';
	}
}

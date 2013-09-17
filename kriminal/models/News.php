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
	
	public function dbConnect()
	{
		$connection = new CDbConnection($dsn, $username, $password);
		$connection->active = true;
		//$connection=Yii::app()->db;
		$sql = "SELECT * FROM news";
		$dataReader = $connection->createCommand($sql)->query();
		return $dataReader;
	}
}

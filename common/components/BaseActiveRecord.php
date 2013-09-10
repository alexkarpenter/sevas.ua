<?php

/**
 * Этот класс является базовым для всех моделей ActiveRecord.
 * Он возвращает основное соединение для работы с БД.
 */
class BaseActiveRecord extends CActiveRecord
{
	public function getDbConnection()
	{
		return Yii::app()->{Yii::app()->params['appId']};
	}
}
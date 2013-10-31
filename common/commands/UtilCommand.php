<?php

class UtilCommand extends CConsoleCommand
{

	/**
	 * connection string for JDBC
	 */
	public function actionDbUrl($dbname=null)
	{
		$db = Yii::app()->db;
		$dbname = $dbname ?: $db->createCommand("SELECT DATABASE();")->queryScalar();
		$url = sprintf("jdbc:mysql://localhost/%s?user=%s&password=%s",
			$dbname, $db->username, $db->password );
		print $url."\n";
	}

	/**
	 * params for current DB for mysql console tools
	 * like this: '-uuser -ppass database'
	 */
	public function actionMysqlParams()
	{
		$db = Yii::app()->db;
		$dbname = $db->createCommand("SELECT DATABASE();")->queryScalar();
		$params = sprintf("-u%s -p%s %s",
				$db->username, $db->password, $dbname );
		print $params."\n";
		
	}
	
	public function actionDebug()
	{
		
		$q = Yii::app()->db->createCommand('select * from organization where id=4831');
		$o = $q->queryAll();
		//print_r($o);
		//print json_encode($o);
		
		Yii::import('spravka.models.Organization');
		$s = Organization::model()->getTableSchema();
		CVarDumper::dump($s, 4);
		
	}
}
<?php
$projectPath = dirname(dirname(__DIR__));


// Define aliases.
Yii::setPathOfAlias('common', $projectPath.DIRECTORY_SEPARATOR.'common');
Yii::setPathOfAlias('api', $projectPath.DIRECTORY_SEPARATOR.'api');
Yii::setPathOfAlias('main', $projectPath.DIRECTORY_SEPARATOR.'main');
Yii::setPathOfAlias('news', $projectPath.DIRECTORY_SEPARATOR.'news');
Yii::setPathOfAlias('themes', $projectPath.DIRECTORY_SEPARATOR.'themes');
Yii::setPathOfAlias('bootstrap', $projectPath.DIRECTORY_SEPARATOR.'common/extensions/yii-bootstrap');
Yii::setPathOfAlias('spravka', $projectPath.DIRECTORY_SEPARATOR.'spravka');

    
// SevasApplication properties can be configured here.
$config = array(
	'language' => 'ru',
	'host' => 'sevas.ru',
	'commonHost' => 'common.sevas.ru',
	'theme' => 'dark',
	// preloading 'log' component
	'preload'=>array('log'),
		
	'controllerMap' => array(
			'user' => 'common.controllers.UserController',
	),
	
	// autoloading model and component classes
	'import'=>array(
			'common.components.*',
			'common.enums.*',
			'common.controllers.BaseNewsController',
			'common.controllers.BaseUserController',
			'common.models.*',
			'common.extensions.*',
			'common.extensions.mailer.YiiMailer',
			'common.extensions.imperavi-redactor-widget-master.ImperaviRedactorWidget',
	),
		
	'aliases' => array(
	),
		
	'modules'=>array(
		// uncomment the following to enable the Gii tool
		/*
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'Enter Your Password Here',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		*/
	),

	// application components
	'components'=>array(
		'user'=>array(
            'class' => 'WebUser',
                // enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		'authManager' => array(
			'class'  => 'CDbAuthManager',
			'itemTable' => 'auth_item',
			'itemChildTable' => 'auth_item_child',
			'assignmentTable' => 'auth_assignment',
			'connectionID' => 'db',
			'defaultRoles' => array('guest', 'authenticated'),
		),
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
                'news/<url:\w+-{1}\w+.*>'=>'news/view',
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
			'showScriptName' => false,
		),
		'db'=>array(
	        'class'=>'system.db.CDbConnection',
			'connectionString' => 'mysql:host=localhost;dbname=sevas.ua',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		'clientScript' => array(
			'class' => 'SClientScript',
			'packages' => array(
				'selectize' => array(
					'basePath' => 'webroot.js.selectize',
					'baseUrl' => '/js/selectize/',
					'js' => array('selectize.js'),
					'css' => array('selectize.css'),
					'depends' => array('jquery'), 
				),
			),
		),
		'assetManager' => array(
			'basePath' => $projectPath.'/common/www/assets',
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
		'bootstrap' => array(
			'class' => 'bootstrap.components.Bootstrap',
		),
	),

	
	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
        // DB name for basic models, etc.
        // Format: '{aplicationName}_db' => ${aplicationName}_db
        'cityCenter' => array('lat' => 44.616649, 'lon' => 33.52536),
        'cityBounds' => array(array(44.443595,33.309753), array(44.847511,33.900268)),
		// 44.443595,33.309753 - sw
		// 44.847511,33.900268 - ne
        // 44.847511,33.309753 - nw
        // 44.443595,33.900268 - se
        
		'YiiMailer' => array(
				'viewPath' => 'common.views.mail',
				'layoutPath' => 'common.views.mail.layouts',
				'layout' => 'mail',
				'testMode'=>false,
				'savePath'=>'news.runtime',
				'ContentType'=>'text/html',
		),
	),
);

@include 'main.local.php'; // machine-specific settings like DB

return $config;
<?php
$projectPath = dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..';


// Define aliases.
Yii::setPathOfAlias('common', $projectPath.DIRECTORY_SEPARATOR.'common');
Yii::setPathOfAlias('spravka', $projectPath.DIRECTORY_SEPARATOR.'spravka');

// Define DB name.
// Format: ${aplicationName}_db = '{db_name}'
    $kriminal_db = 'kriminal_db';
    $spravka_db = 'spravka_db';
    
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
$config = array(
    'basePath'=> $projectPath.DIRECTORY_SEPARATOR.'common',
	'language' => 'ru',
	//'theme' => 'dark',
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'common.components.*',
		//'comment.models.*',
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
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
// 				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
// 				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
// 				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
			'showScriptName' => false,
		), 
		'clientScript' => array(
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
		'kriminal'=>array(
            'class' => 'CDbConnection',
			'connectionString' => 'mysql:host=localhost;dbname='.$kriminal_db,
			'emulatePrepare' => true,
			'username' => 'your_name',
			'password' => 'your_password',
			'charset' => 'utf8',
		),
		'spravka'=>array(
            'class' => 'CDbConnection',
			'connectionString' => 'mysql:host=localhost;dbname='.$spravka_db,
			'emulatePrepare' => true,
			'username' => 'spravka_db',
			'password' => 'spravka_db',
			'charset' => 'utf8',
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
	),

	
	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
        // DB name for basic models, etc.
        // Format: '{aplicationName}_db' => ${aplicationName}_db
        'kriminal_db' => $kriminal_db,
        'spravka_db' => $spravka_db,
        'cityCenter' => array('lat' => 44.616649, 'lon' => 33.52536),
        'cityBounds' => array(array(44.443595,33.309753), array(44.847511,33.900268)),
		// 44.443595,33.309753 - sw
		// 44.847511,33.900268 - ne
        // 44.847511,33.309753 - nw
        // 44.443595,33.900268 - se
	),
);

@include 'console.local.php'; // machine-specific settings like DB

return $config;
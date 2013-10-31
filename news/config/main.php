<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
$config = CMap::mergeArray(
	require(dirname(__FILE__) . '/../../common/config/main.php'), array(
	    'basePath' => $projectPath.DIRECTORY_SEPARATOR.'news',
	    'name' => 'Новости',
        'theme' => 'screen',
        'defaultController' => 'news',

	    // preloading 'log' component
	    'preload' => array('log'),
	    // autoloading model and component classes
	    'import' => array(
			'news.models.*',
			'news.components.*',
	    ),
		    
	    'modules' => array(
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
        'components' => array(
            'errorHandler'=>array(
                // use 'site/error' action to display errors
                'errorAction'=>'news/error',
            ),
            'themeManager'=>array(
                'class'    => 'CThemeManager',
                'basePath'=>Yii::getPathOfAlias('news').'/themes/',
                'baseUrl'  => '/www/themes'
            ),
        ),
		    
	    // application-level parameters that can be accessed
	    // using Yii::app()->params['paramName']
	    'params' => array(
			// this is used in contact page
			'adminEmail' => 'webmaster@example.com',
			'appId'	=> 'news',
	    ),
	)
);

@include 'main.local.php'; // machine-specific settings like DB

return $config;
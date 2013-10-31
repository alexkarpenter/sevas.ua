<?php

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
$config = CMap::mergeArray(
	require(dirname(__FILE__) . '/../../common/config/main.php'), 
	array(
        'basePath'=>$projectPath.DIRECTORY_SEPARATOR.'spravka',
	    'name' => 'Справочник',
		'theme' => 'screen',
		'layout' => 'spravka.views.layouts.spravka-aside',
		'defaultController' => 'sprav',

	    // preloading 'log' component
	    'preload' => array('log'),
	    // autoloading model and component classes
	    'import' => array(
            'spravka.models.*',
            'spravka.components.*',
            'spravka.controllers.*',
	    	'ext.giix.components.*',
	    ),
		    
		'aliases' => array(
				'comment' => $projectPath.'/common/extensions/comment-module',
		),
				
	    'modules' => array(
	    // uncomment the following to enable the Gii tool
        'gii'=>array(
		      'class'=>'system.gii.GiiModule',
		      'password'=>'asdfasdf',
		      // If removed, Gii defaults to localhost only. Edit carefully to taste.
		      'ipFilters'=>array('127.0.0.1','::1'),
        		'generatorPaths' => array(
        				'ext.giix.generators', // giix generators
        		),        		
	      ),
	    ),

	    // application components
	    'components' => array(
	    
	    	'clientScript' => array(
	    		'scriptMap' => array(
		    		'jquery-ui.css' => '/css/jui/jquery-ui-custom.css',
		    	),
		    ),
	    
		    'urlManager'=>array(
		    		'urlFormat'=>'path',
		    		'rules' => array(
		    				array(	
		    					'class' => 'SlugUrlRule', 
	    						'routes' => array( 
									'sprav/org' => 'org',
									'sprav/category' => 'category',
	    						),
		    				),
		    				//'org/<slug:.*>' => 'sprav/org',
		    				//'category/<slug:.*>' => 'sprav/category',
		    				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
		    				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
		    				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
		    		),
		    		'showScriptName' => false,
		    ),
		    
		    'imager' => array(
		    		'class' => 'common.components.Imager',
		    		'presets' => array(
		    		
			    		'gallery270' => array(
				    		'targetDirAlias' => 'webroot.upload.cache.gallery270',
				    		'targetTemplate' => '/{$self->getHashSubdir($self->source)}/{$self->sourceInfo["basename"]}',
				    		'actions' => array(
				    				array('thumbnail', array(344, 277, 'outbound')),
				    				array('watermark', array(__DIR__.'/../www/images/3star.png', array('right' => 10, 'bottom' => 10)))
				    		)
			    		),
			    		
			    		'thumb160' => array(
			    				'targetDirAlias' => 'webroot.upload.cache.thumb160',
			    				'targetTemplate' => '/{$self->getHashSubdir($self->source)}/{$self->sourceInfo["basename"]}',
			    				'actions' => array(
			    						array('thumbnail', array(160, 100, 'outbound')),
			    				)
			    		)
			    		 
		    		),
		    ),
		    
		    'themeManager' => array(
		    		'class'    => 'CThemeManager',
		    		'basePath' => Yii::getPathOfAlias('common').'/themes/',
		    		'baseUrl'  => '/www/themes'
		    ),
		    
			'log' => array(
			    'class' => 'CLogRouter',
			    'routes' => array(
					array(
					    'class' => 'CFileLogRoute',
					),
				    // Show log messages on web pages
				    //array( 'class'=>'CWebLogRoute', ),
			    ),
			),
	    ),
	    
	    'modules' => array(
	    
		    'comment' => array(
		    		'class'=>'common.extensions.comment-module.CommentModule',
		    		'commentableModels'=>array(
		    				// define commentable Models here (key is an alias that must be lower case, value is the model class name)
		    				'organization' => 'Organization',
		    				'file' => 'File',
		    		),
		    		// set this to the class name of the model that represents your users
		    		'userModelClass'=>'User',
		    		// set this to the username attribute of User model class
		    		'userNameAttribute'=>'username',
		    		// set this to the email attribute of User model class
		    		'userEmailAttribute'=>'email',
		    		// you can set controller filters that will be added to the comment controller {@see CController::filters()}
		    //          'controllerFilters'=>array(),
		    		// you can set accessRules that will be added to the comment controller {@see CController::accessRules()}
		    //          'controllerAccessRules'=>array(),
		    		// you can extend comment class and use your extended one, set path alias here
		    //          'commentModelClass'=>'comment.models.Comment',
// 		    		'onNewComment' => array('Organization', 'onNewCommentHandler'),
		    ),	    
	    
	    ),
	    
	    /*
	    'messages' => array (
	    		// Pending on core: http://code.google.com/p/yii/issues/detail?id=2624
	    		'extensionBasePaths' => array(
	    				'giix' => 'ext.giix.messages', // giix messages directory.
	    		),
	    ),
	    */
	    		    
	    // application-level parameters that can be accessed
	    // using Yii::app()->params['paramName']
	    'params' => array(
            // this is used in contact page
            'adminEmail' => 'webmaster@example.com',
            // Application id for basic db connection, etc.
            'appId'	=> 'spravka',
	    ),
	)
);

@include 'main.local.php'; // machine-specific settings like DB

return $config;
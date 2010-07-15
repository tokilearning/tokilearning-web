<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'TOKI Learning Center',
    'defaultController' => 'home',
    'theme' => 'arrastheme',
    'language' => 'id',
    'sourceLanguage' => 'id',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.models.forms.*',
        'application.components.*',
        'application.components.controllers.*',
        'application.components.helpers.*',
        'application.components.widgets.*',
        'ext.mail.Message',
    ),
    // application components
    'components' => array(
        'user' => array(
            'class' => 'WebUser',
            // enable cookie-based authentication
            'allowAutoLogin' => true,
            'loginUrl' => array('/guest'),
        ),
        // uncomment the following to enable URLs in path-format

        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
		'problemset/<id:\d+>' => 'problemset/list',
                'problem/<id:\d+>' => 'problem/view',
                'problem' => 'problemset',
                'submission/<id:\d+>' => 'submission/view',
                'profile/<id:\d+>' => 'profile/view',
                'announcement/<id:\d+>' => 'announcement/view',
                'training/<id:\d+>/chapter/<cid:\d+>/problem/<pid:\d+>' => 'training/viewproblem',
                'training/<id:\d+>/chapter/<cid:\d+>/submission/<pid:\d+>' => 'training/viewsubmission',
                'training/<id:\d+>/chapter/<cid:\d+>' => 'training/viewchapter',
                'training/<id:\d+>/createclarification/<cid:\d+>' => 'training/createclarification',
                'training/<id:\d+>' => 'training/view',
		'train' => 'training/view/id/2',
		'contests' => 'contest/contest/index',
                'contest' => 'contest/contest/index',
                'contest/supervisor' => 'contest/supervisor/news/index',
                'administrator' => 'administrator/home',
                'forgot/<user:\w+>/<key:\w+>' => 'guest/changepassword',
                'contest/<contestid:\d+>/' => 'contest/news',
                'contest/<contestid:\d+>/supervisor' => 'contest/supervisor/news',
		'contest/<contestid:\d+>/supervisor/<controller:\w+>/<action:\w+>' => 'contest/supervisor/<controller>/<action>',
                'contest/<contestid:\d+>/<controller:\w+>' => 'contest/<controller>',
                'contest/<contestid:\d+>/<controller:\w+>/<action:\w+>' => 'contest/<controller>/<action>',
                'contest/<contestid:\d+>/problem/<alias:\d+>' => 'contest/problem/view',
                //statics
                '/about' => '/static/about',
                '/contact' => '/static/contact',
                '/help' => '/static/help',
                'openosn' => '/static/openosn',
                //
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>'
            ),
        ),
//        'db' => array(
//            'connectionString' => 'sqlite:' . dirname(__FILE__) . '/../data/testdrive.db',
//        ),
        // uncomment the following to use a MySQL database
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=lc3_db',
            'emulatePrepare' => true,
            'username' => '',
            'password' => '',
            'charset' => '',
            'tablePrefix' => '',
        ),
        'dblog' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=lc3log',
            'emulatePrepare' => true,
            'username' => '',
            'password' => '',
            'charset' => 'utf8',
            'tablePrefix' => '',
        ),
        'authManager' => array(
            'class' => 'CDbAuthManager',
            'connectionID' => 'db',
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'error/index',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'info, trace, error, warning',
                    'categories' => 'application.commands.StatisticsCommand',
                    'logFile' => 'statistics.log'
                ),
            // uncomment the following to show log messages on web pages
                array(
                    'class' => 'CWebLogRoute',
                    'levels' => 'trace',
                    'categories' => 'system.db.*'
                ),
//                array(
//                    'class' => 'CDbLogRoute',
//                    'levels' => 'info, trace, error, warning',
//                    'connectionID' => 'dblog',
//                    'logTableName' => 'logs',
//                    'categories' => 'application.*',
//                    'autoCreateLogTable' => true
//                )
            ),
        ),
        'session' => array(
            'autoStart' => true
        ),
        'mail' => array(
            'class' => 'ext.mail.Mail', //set to the path of the extension
            'transportType' => 'php',
            'viewPath' => 'application.views.mail',
            'debug' => false
        ),
		'request' => array(
			'enableCsrfValidation' => true,
		),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'toki.learning@gmail.com',
        'tagline' => 'Tim Olimpiade Komputer Indonesia',
        'config' => require('config.php'),
        'facebook' => require('facebook.php')
    ),
);

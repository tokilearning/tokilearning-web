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
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.models.forms.*',
        'application.components.*',
        'application.components.controllers.*',
        'application.components.helpers.*',
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
            'rules' => array(
                'problemset/<id:\d+>' => 'problemset/list',
                'problem/<id:\d+>' => 'problem/view',
                'problem' => 'problemset',
                'submission/<id:\d+>' => 'submission/view',
                'profile/<id:\d+>' => 'profile/view',
                'announcement/<id:\d+>' => 'announcement/view',
                'contest' => 'contest/contest/index',
                'contest/supervisor' => 'contest/supervisor/news/index',
                'administrator' => 'administrator/home',
                'contest/<contestid:\d+>/' => 'contest/news',
                'contest/<contestid:\d+>/supervisor' => 'contest/supervisor/news',
                'contest/<contestid:\d+>/<controller:\w+>' => 'contest/<controller>',
                'contest/<contestid:\d+>/<controller:\w+>/<action:\w+>' => 'contest/<controller>/<action>',
                'contest/<contestid:\d+>/problem/<alias:\d+>' => 'contest/problem/view',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>'
            ),
        ),
//        'db' => array(
//            'connectionString' => 'sqlite:' . dirname(__FILE__) . '/../data/testdrive.db',
//        ),
        // uncomment the following to use a MySQL database
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=lc3',
            'emulatePrepare' => true,
            'username' => 'lc3',
            'password' => 'lc3',
            'charset' => 'utf8',
            'tablePrefix' => '',
        ),
        'dblog' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=lc3log',
            'emulatePrepare' => true,
            'username' => 'lc3log',
            'password' => 'lc3log',
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
                // uncomment the following to show log messages on web pages
//                array(
//                    'class' => 'CWebLogRoute',
//                    'levels' => 'trace',
//                    'categories' => 'system.db.*'
//                ),
//                array(
//                    'class' => 'CDbLogRoute',
//                    'levels' => 'info, trace, error, warning',
//                    'connectionID' => 'db',
//                    'logTableName' => 'logs',
//                    'autoCreateLogTable' => true
//                )
            ),
        ),
        'session' => array(
            'autoStart' => true
        )
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'webmaster@example.com',
        'tagline' => 'Tim Olimpiade Komputer Indonesia',
        'config' => require('config.php')
    ),
);
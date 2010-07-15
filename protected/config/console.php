<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name' => 'My Console Application',
        'preload' => array('log'),
        'import' => array(
            'application.models.*',
            'application.components.evaluators.*',
            'application.components.*',
        ),
        'components' => array(
            'db' => array(
                'connectionString' => 'mysql:host=localhost;dbname=lc3_db',
                'emulatePrepare' => true,
                'username' => '',
                'password' => '',
                'charset' => 'utf8',
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
            'log' => array(
                'class' => 'CLogRouter',
                'routes' => array(
                    array(
                        'class' => 'CFileLogRoute',
                        'levels' => 'info, trace, error, warning',
                        'logFile' => 'evaluator.log',
                        'categories' => 'application',
                    ),
                    //Evaluator
//                    array(
//                        'class' => 'CDbLogRoute',
//                        'levels' => 'info, trace, error, warning',
//                        'connectionID' => 'dblog',
//                        'logTableName' => 'logs',
//                        'categories' => 'application',
//                        'autoCreateLogTable' => true
//                    )
                ),
            ),
        ),
        'params' => array(
            // this is used in contact page
            'adminEmail' => 'webmaster@example.com',
            'tagline' => 'Tim Olimpiade Komputer Indonesia',
            'config' => require('config.php')
        ),
);

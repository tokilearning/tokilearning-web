<?php

/**
 * This is the main configuration used for the web end of this application.
 */
define('APP_CONFIG_DIR', dirname(__FILE__) . '/application');

return array(
        'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
        'name' => 'TOKI Learning Center',
        'language' => 'id',
        'defaultController' => 'home/index',
        // preloading 'log' component
        'preload' => array('log'),
        // autoloading model and component classes
        'import' => array(
                'application.models.*',
                'application.components.*',
        ),
        'modules' => array(),
        // application components
        'components' => array(
                'user' => array(
                        // enable cookie-based authentication
                        'allowAutoLogin' => true,
                ),
                // uncomment the following to enable URLs in path-format
                'urlManager' => array(
                        'urlFormat' => 'path',
                        'rules' => array(
                                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                        ),
                ),
                'db' => require(APP_CONFIG_DIR . '/database.php'),
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
                        ),
                ),
        ),
        'params' => array(
        ),
);
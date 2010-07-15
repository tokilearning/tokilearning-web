<?php

return CMap::mergeArray(
        require(dirname(__FILE__) . '/../main.php'),
        array(
            'components' => array(
                'db' => array(
                    'connectionString' => 'mysql:host=localhost;dbname=lc3local',
                    'emulatePrepare' => true,
                    'username' => 'lc3local',
                    'password' => 'lc3local',
                    'charset' => 'utf8',
                    'tablePrefix' => '',
                ),
                'dblog' => array(
                    'connectionString' => 'mysql:host=localhost;dbname=lc3log',
                    'emulatePrepare' => true,
                    'username' => 'lc3log',
                    'password' => 'lc3log',
                    'charset' => 'utf8',
                    'tablePrefix' => '',
                ),
                'log' => array(
                    'class' => 'CLogRouter',
                    'routes' => array(
                        array(
                            'class' => 'CFileLogRoute',
                            'levels' => 'error, warning',
                            'logFile' => 'dev.log'
                        ),
                        // uncomment the following to show log messages on web pages
                        array(
                            'class' => 'CWebLogRoute',
                            'levels' => 'trace',
                            'categories' => 'system.db.*'
                        )
                    ),
                ),
            ),
            'params' => array(
                // this is used in contact page
                'config' => require('config.php')
            ),
        )
);

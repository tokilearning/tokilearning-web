<?php
return CMap::mergeArray(
    require(dirname(__FILE__).'/../main.php'),
    array(
        'components' => array(
            'db' => array(
                'connectionString' => 'mysql:host=localhost;dbname=lc3_dbdev',
                'emulatePrepare' => true,
                'username' => '',
                'password' => '',
                'charset' => 'utf8',
                'tablePrefix' => '',
            ),
            'dblog' => array(
                'connectionString' => 'mysql:host=localhost;dbname=lc3_dblog',
                'emulatePrepare' => true,
                'username' => '',
                'password' => '',
                'charset' => '',
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

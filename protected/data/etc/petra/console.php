<?php

return CMap::mergeArray(
        require(dirname(__FILE__) . '/../console.php'),
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
            ),
            'params' => array(
                // this is used in contact page
                'config' => require('config.php')
            ),
        )
);

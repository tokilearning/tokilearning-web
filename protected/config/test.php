<?php

return CMap::mergeArray(
        require(dirname(__FILE__) . '/main.php'),
        array(
            'components' => array(
                'fixture' => array(
                    'class' => 'system.test.CDbFixtureManager',
                ),
                'db' => array(
                    'connectionString' => 'mysql:host=localhost;dbname=lc3test',
                    'emulatePrepare' => true,
                    'username' => 'lc3test',
                    'password' => 'lc3test',
                    'charset' => 'utf8',
                ),
                
            ),
        )
);

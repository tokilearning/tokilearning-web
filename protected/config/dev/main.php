<?php
return CMap::mergeArray(
    require(dirname(__FILE__).'/../main.php'),
    array(
        'components' => array(
            'db' => array(
                'connectionString' => 'mysql:host=localhost;dbname=lc3_dbdev',
                'emulatePrepare' => true,
                'username' => 'lc3_dbdev',
                'password' => 'lc3_dbdev',
                'charset' => 'utf8',
                'tablePrefix' => '',
            ),
        )
    )
);

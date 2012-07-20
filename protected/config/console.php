<?php

define('APP_CONFIG_DIR', dirname(__FILE__) . '/application');

/**
 * This is the main configuration used for the CLI end of this application.
 */
return array(
        'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
        'name' => 'TOKI Learning Center',
        'timeZone' => 'Asia/Jakarta',
        'import' => array(
                'application.models.*',
                'application.components.*',
                'application.components.helpers.*',
        ),
        /**
         * Application components
         */
        'components' => array(
                'db' => require(APP_CONFIG_DIR . '/database.php'),
        ),
        'params' => array(
        ),
        'commandMap' => array(
                'migrate' => array(
                        'class' => 'system.cli.commands.MigrateCommand',
                        'migrationTable' => 'Migrations',
                ),
        ),
);

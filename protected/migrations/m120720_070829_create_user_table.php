<?php

/**
 * User management migration class.
 * 
 * This class will handle user management migrations. When applies, this class
 * will create user table and its required indices.
 * 
 * @author Petra Barus <petra.barus@gmail.com>
 * @package application.migrations 
 */
class m120720_070829_create_user_table extends \CDbMigration {

        const TABLE_USERS = 'Users';

        /**
         * Applies this migration.
         * @return boolean false if migration is unsuccesful.
         */
        public function up() {
                $this->createTable(self::TABLE_USERS, array(
                        //Basic informations
                        'id' => 'bigint unsigned NOT NULL AUTO_INCREMENT',
                        'username' => 'varchar(255) NOT NULL',
                        'email' => 'varchar(255) NOT NULL',
                        'password' => 'varchar(32) NOT NULL',
                        'fullName' => 'text NOT NULL',
                        //System information
                        'createdTime' => 'datetime NULL',
                        'updatedTime' => 'datetime NULL',
                        'lastLoginTime' => 'datetime NULL',
                        'lastActivityTime' => 'datetime NULL',
                        'loginCount' => 'bigint unsigned NOT NULL DEFAULT 0',
                        'removedTime' => 'datetime NULL',
                        'profileUpdatedTime' => 'datetime NULL',
                        'isRemoved' => 'tinyint unsigned  NOT NULL DEFAULT 0',
                        //Primary key
                        'primary key (id)'
                ));

                $this->createIndex('email', self::TABLE_USERS, 'email', true);
                $this->createIndex('username', self::TABLE_USERS, 'username', true);
                $this->createIndex('isRemoved', self::TABLE_USERS, 'isRemoved');
        }

        /**
         * Removes this migration.
         * @return boolean false if migration is unsuccesful.
         */
        public function down() {
                $this->dropTable(self::TABLE_USERS);
        }

}
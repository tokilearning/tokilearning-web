<?php

class m120724_060241_create_problems_table extends CDbMigration
{
        const TABLE_PROBLEMS = "Problems";
        
        /**
         * Applies this migration.
         * @return boolean false if migration is unsuccesful.
         */
	public function up()
	{
                $this->createTable(self::TABLE_PROBLEMS, array(
                        //Basic informations
                        'id' => 'bigint unsigned NOT NULL AUTO_INCREMENT',
			'title' => 'text NOT NULL',
			'authorId' => 'bigint unsigned NOT NULL',
			'shortDescription' => 'text NULL',
                        'description' => 'text NULL',
                        'privacyLevel' => 'smallint NOT NULL DEFAULT 0', // draft, public, etc
                        //System Information
			'createdDate' => 'datetime NOT NULL',
                        'modifiedDate' => 'datetime NULL',
                        
                        //Primary key
                        'primary key (id)'
                ));
                // foreign key to Users.id
                $this->addForeignKey('authorIdFK', self::TABLE_PROBLEMS, 'authorId', 'Users', 'id','RESTRICT');
	}
        
        /**
         * Removes this migration.
         * @return boolean false if migration is unsuccesful.
         */
	public function down()
	{
		$this->dropTable(self::TABLE_PROBLEMS);
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}
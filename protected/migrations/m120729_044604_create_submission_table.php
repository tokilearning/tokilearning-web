<?php
/**
 * Submission migration class.
 *
 * This class will handle submission migrations. When applies, this class
 * will create submission table and its required indices.
 *
 * @author Muhammad Adinata <mail.dieend@gmail.com>
 * @package application.migrations
 */

class m120729_044604_create_submission_table extends CDbMigration
{
        const TABLE_SUBMISSION = "Submissions";
	public function up()
	{
                $this->createTable(self::TABLE_SUBMISSION, array(
                        'id' => 'bigint unsigned NOT NULL AUTO_INCREMENT',
                        'problemId' => 'bigint unsigned NOT NULL        ',
                        'submitterId' => 'bigint unsigned NOT NULL',
                        'content' => 'text NOT NULL',
                        'submittedTime' => 'datetime NOT NULL',
                        'gradeTime' => 'datetime',
                        'gradeStatus' => 'smallint DEFAULT 0',
                        'gradeResult' => 'text',
                        'file' => 'longblob',
                        'context' => 'smallint',
                        'contextId' =>'smallint',
                        'primary key (id)',
                ));
                $this->addForeignKey('submitterIdFK', self::TABLE_SUBMISSION, 'submitterId', 'Users', 'id', 'RESTRICT');
	}

	public function down()
	{
                $this->dropTable(self::TABLE_SUBMISSION);
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
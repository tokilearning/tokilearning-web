<?php

class m120726_061503_add_removed_time_column extends CDbMigration
{
        const TABLE_USER = "Users";
        const TABLE_PROBLEM = "Problems";
        const COLUMN_REMOVED_TIME = "removedTime";
	public function up()
	{
                $this->addColumn(self::TABLE_USER, self::COLUMN_REMOVED_TIME, "datetime");
                $this->addColumn(self::TABLE_PROBLEM, self::COLUMN_REMOVED_TIME, "datetime");
	}

	public function down()
	{
                $this->dropColumn(self::TABLE_USER, self::COLUMN_REMOVED_TIME);
                $this->dropColumn(self::TABLE_PROBLEM, self::COLUMN_REMOVED_TIME);
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
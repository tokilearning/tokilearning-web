<?php

/**
 *
 */
class VirtualContest extends CActiveRecord {
    

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{virtual_contests}}';
    }

    public function relations() {
        return array(
            'contest' => array(self::BELONGS_TO, 'Contest', 'id'),
            'contestants' => array(self::MANY_MANY, 'User',
                'virtual_contests_contestants(contest_id, user_id)'
            ),
        );
    }

    public function insertContestant($user) {
        $sql = "INSERT INTO virtual_contests_contestants (contest_id, user_id, entry_time) VALUES ('" . $this->id . "', " . $user->id . ", " . time() . ");";
        $command = $this->dbConnection->createCommand($sql);
        $command->execute();
    }

    public function isActiveContestant($user) {
        $sql = "SELECT * FROM virtual_contests_contestants WHERE contest_id = " . $this->id . " AND user_id = " . $user->id . ";";
        $command = $this->dbConnection->createCommand($sql);
        $result = $command->query();
        return $result->rowCount > 0;
    }

}

//end of file

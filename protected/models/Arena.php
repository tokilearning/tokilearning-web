<?php

/**
 *
 */
class Arena extends CActiveRecord {
    const ARENA_VISIBILITY_PRIVATE = 0;
    const ARENA_VISIBILITY_PUBLIC = 1;

    const ARENA_ROLE_ADMINISTRATOR = 0;
    const ARENA_ROLE_PARTICIPANT = 1;
    const ARENA_ROLE_REGISTRANT = 2;

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{arenas}}';
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Nama',
            'creator_id' => 'Pembuat',
            'status' => 'Status'
        );
    }

    public function rules(){
        return array(
            array('name', 'unique', 'caseSensitive'=>false),
            array('name', 'required'),
            array('creator_id' , 'required')
        );
    }

    public function addMember($pUser) {
        $this->removeMember($pUser);
        $sql = "INSERT INTO arenas_users (arena_id, user_id) VALUES ('".$this->id."', ".$pUser->id.");";
        $command = $this->dbConnection->createCommand($sql);
        $command->execute();
    }

    public function removeMember($pUser) {
        $sql = "DELETE FROM arenas_users WHERE arena_id = '".$this->id."' AND user_id = '".$pUser->id."';";
        $command = $this->dbConnection->createCommand($sql);
        $command->execute();
    }

    public function isMember($pUser) {
        $sql = "SELECT * FROM arenas_users WHERE arena_id = '".$this->id."' AND user_id = '".$pUser->id."';";
        $command= $this->dbConnection->createCommand($sql);
        $result = $command->query();
        return $result->rowCount != 0 || $this->creator_id == $pUser->id;
    }

    public function relations() {
        return array(
            'creator' => array(self::BELONGS_TO, 'User', 'creator_id'),
            'members' => array(self::MANY_MANY, 'User', 'arenas_users(arena_id, user_id)'),
            'problems' => array(self::MANY_MANY, 'Problem', 'arenas_problems(arena_id, problem_id)'),
            'administrators' => array(self::MANY_MANY, 'User',
                'arenas_users(arena_id, user_id)',
                'condition' => 'role=' . self::ARENA_ROLE_ADMINISTRATOR
            ),
            'participants' => array(self::MANY_MANY, 'User',
                'arenas_users(arena_id, user_id)',
                'condition' => 'role=' . self::ARENA_ROLE_PARTICIPANT
            ),
            'registrants' => array(self::MANY_MANY, 'User',
                'arenas_users(arena_id, user_id)',
                'condition' => 'role=' . self::ARENA_ROLE_REGISTRANT
            )
        );
    }


}

//end of file

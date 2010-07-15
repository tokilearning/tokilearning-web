<?php

class Group extends CActiveRecord {

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{groups}}';
    }

    public function relations(){
        return array(
            'members' => array(self::MANY_MANY, 'User', 'groups_users(group_id, user_id)'),
        );
    }

    public function rules(){
        return array(
            array('name', 'unique', 'caseSensitive'=>false),
            array('name, description', 'required'),
            array('name', 'match', 'pattern' => '/^[a-zA-Z][a-zA-Z0-9_]+$/', 'message' => '{attribute} is invalid. Only number, alphabet, and underscore allowed')
        );
    }

    public function attributeLabels() {
        return array(
            'name' => 'Nama',
            'description' => 'Deskripsi'
        );
    }

    public function addMember($user){
        //TODO:
        $sql = "INSERT INTO groups_users (group_id, user_id) VALUES ('".$this->id."', ".$user->id.");";
        $command = $this->dbConnection->createCommand($sql);
        $command->execute();
    }

    public function removeMember($user){
        //TODO:
        $sql = "DELETE FROM groups_users WHERE group_id = '".$this->id."' AND user_id = '".$user->id."';";
        $command = $this->dbConnection->createCommand($sql);
        $command->execute();
    }

    public function findMember($user, $groupname){
        $this->getDbCriteria()->mergeWith(array(
            'join' => 'JOIN  groups_users ON group_id = id',
            'condition' => 'user_id = '.$user->id.' AND name = \''.$groupname.'\''
        ));
        return $this;
    }

    public static function checkMember($groupname, $user){
        $group = Group::model()->findMember($user, $groupname)->findAll();
        return ($group != null);
    }
}
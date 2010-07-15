<?php

/**
 *
 */
class ProblemSet extends CActiveRecord {

    const PROBLEM_SET_STATUS_UNPUBLISHED = 0;
    const PROBLEM_SET_STATUS_PUBLISHED = 1;

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{problemsets}}';
    }

    public function scopes(){
        return array(
            'root' => array(
                'condition'=> 'parent_id IS NULL'
            ),
            'published' => array(
                'condition'=> 'status = '.self::PROBLEM_SET_STATUS_PUBLISHED
            )
        );
    }

    public function defaultScope(){
        return array('order'=>'created_date DESC');
    }
    
    public function relations(){
        return array(
            'parent' => array(self::BELONGS_TO, 'ProblemSet', 'parent_id'),
            'children' => array(self::HAS_MANY, 'ProblemSet', 'parent_id', 'order' => 'created_date ASC'),
            'problems' => array(self::MANY_MANY, 'Problem', '{{problemsets_problems}}(problemset_id, problem_id)')
        );
    }

    public function rules(){
        return array(
            array('name, description', 'required'),
            array('status', 'required', 'on' => 'update')
        );
    }
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Nama',
            'description' => 'Deskripsi',
            'parent_id' => 'Parent'
        );
    }

    public function beforeSave(){
        if ($this->isNewRecord) {
            $this->created_date = new CDbExpression('NOW()');
            $this->modified_date = new CDbExpression('NOW()');
            $this->status = self::PROBLEM_SET_STATUS_UNPUBLISHED;
        } else {
            $this->modified_date = new CDbExpression('NOW()');
        }
        return parent::beforeSave();
    }

    //
    public static function getStatusStrings(){
        return array(
            self::PROBLEM_SET_STATUS_PUBLISHED => "Published",
            self::PROBLEM_SET_STATUS_UNPUBLISHED => "Unpublished",
        );
    }
    
    public function isPublished(){
        return $this->status == self::PROBLEM_SET_STATUS_PUBLISHED;
    }

    public function getStatus(){
        $array = self::getStatusStrings();
        return $array[$this->status];
    }

    public function getParentName(){
        return $this->parent->name;
    }

    public function addProblem($problem){
        $sql = "INSERT INTO problemsets_problems (problemset_id, problem_id) VALUES ('".$this->id."', ".$problem->id.");";
        $command = $this->dbConnection->createCommand($sql);
        $command->execute();
    }

    public function removeProblem($problem){
        $sql = "DELETE FROM problemsets_problems WHERE problemset_id = '".$this->id."' AND problem_id = '".$problem->id."';";
        $command = $this->dbConnection->createCommand($sql);
        $command->execute();
    }

    public function addProblemSet($problemset){
        $problemset->parent_id = $this->id;
        $problemset->save(false);
    }

    public function removeProblemSet($problemset){
        $problemset->parent_id = null;
        $problemset->save(false);
    }

}
//end of file
<?php
/**
 *
 */
class Chapter extends CActiveRecord {
    const CHAPTER_PARTICIPANT_WORKING = 0;
    const CHAPTER_PARTICIPANT_COMPLETE = 1;

    private $_subchapters;
    private $mCompleteSubChapters;

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{chapters}}';
    }

    public function relations(){
        return array(
            'nextChapter' => array(self::BELONGS_TO, 'Chapter', 'next_chapter_id'),
            'previousChapter' => array(self::HAS_ONE, 'Chapter', 'next_chapter_id'),
            'firstSubChapter' => array(self::BELONGS_TO, 'Chapter', 'first_subchapter_id'),
            'parentChapter' => array(self::HAS_ONE, 'Chapter', 'first_subchapter_id'),
            'clarifications' => array(self::HAS_MANY, 'Clarification', 'chapter_id'),
            'training' => array(self::HAS_ONE, 'Training', 'first_chapter_id'),
            'trainings' => array(self::HAS_MANY, 'Training', 'first_chapter_id'),
            'problems' => array(self::MANY_MANY, 'Problem', 'chapters_problems(chapter_id, problem_id)'),
            'participants' => array(self::MANY_MANY, 'User',
                'chapters_users(chapter_id, user_id)'
            ),
        );
    }

    public function rules(){
        return array(
            array('name, description', 'required'),
            array('next_chapter_id', 'safe', 'on' => 'update, create'),
            array('next_chapter_id', 'chapterExists'),
            array('first_subchapter_id', 'safe', 'on' => 'update, create'),
            array('first_subchapter_id', 'chapterExists')
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Nama',
            'created_time' => 'Dibuat',
            'next_chapter_id' => 'Bab Selanjutnya',
            'previousChapter' => 'Bab Sebelumnya',
            'nextChapter' => 'Bab Selanjutnya',
            'first_subchapter_id' => 'Subbab Pertama',
            'firstSubChapter' => 'Subbab Pertama',
        );
    }

    public function isPartOfTraining($training) {
        $chapter = $this;

        while ($chapter->getParentChapter() !== NULL) {
            $chapter = $chapter->getParentChapter();
        }

        $chapter = $chapter->getFirstChapter();

        $retval = false;
        foreach ($chapter->trainings as $t) {
            if ($training->id == $t->id)
                $retval = true;
        }

        /*if ($chapter->training->id == $training->id)
            return true;
        else
            return false;*/
        return $retval;
    }

    public function getParentChapter() {
        return $this->getFirstChapter()->parentChapter;
    }

    public function getFirstChapter() {
        $chapter = $this;
        while ($chapter->previousChapter !== NULL) {
            $chapter = $chapter->previousChapter;
        }
        return $chapter;
    }

    public function getRootChapter() {
        $chapter = $this;

        while ($chapter->getParentChapter() !== NULL) {
            $chapter = $chapter->getParentChapter();
        }

        return $chapter;
    }

    public function isAccessible($user , $training) {
        if ($training->status == Training::STATUS_CLOSED) {
            return false;
        }
        else if ($this->previousChapter === NULL && $this->parentChapter === NULL) {
            return true;
        }
        else if (!$this->isPartOfTraining($training)) {
            return false;
        }
        else {
            $chapter = ($this->previousChapter === NULL) ? $this->parentChapter : $this->previousChapter;
            if ($this->previousChapter !== NULL)
                $sql = "SELECT * FROM chapters_users WHERE chapter_id = " . $chapter->id . " AND user_id = " . $user->id . " AND status = " . self::CHAPTER_PARTICIPANT_COMPLETE;
            else
                $sql = "SELECT * FROM chapters_users WHERE chapter_id = " . $chapter->id . " AND user_id = " . $user->id .";";
            $command= $this->dbConnection->createCommand($sql);
            $result = $command->query();
            $accessible =  $result->rowCount > 0;

            return $chapter->isAccessible($user , $training) && $accessible;
        }
    }

    public function isOpened($user) {
        $sql = "SELECT * FROM chapters_users WHERE chapter_id = " . $this->id . " AND user_id = " . $user->id;
        $command= $this->dbConnection->createCommand($sql);
        $result = $command->query();
        return $result->rowCount != 0;
    }


    public function updateUser($user) {
        $completed = true;
        foreach ($this->problems as $problem) {
            $completed &= $this->isProblemCompleted($user , $problem);
        }

        $subChapters = $this->getSubChapters();
        foreach ($subChapters as $chap) {
            $completed &= $chap->isCompleted($user);
        }

        $tmp_comp = $completed;
        $this->setCompletion($user , ($tmp_comp) ? self::CHAPTER_PARTICIPANT_COMPLETE : self::CHAPTER_PARTICIPANT_WORKING);

        //if ($this->nextChapter !== NULL) $tmp_comp = false;
        $chapter = $this->getParentChapter();
        while ($chapter !== NULL) {
            //$chapter->setCompletion($user , ($tmp_comp) ? self::CHAPTER_PARTICIPANT_COMPLETE : self::CHAPTER_PARTICIPANT_WORKING);
            //if ($chapter->nextChapter !== NULL) $tmp_comp = false;
            $chapter->updateUser($user);
            $chapter = $chapter->getParentChapter();
        }
    }


    public function isCompleted($user , $quick = true , $problem_check = true) {
        $sql = "SELECT * FROM chapters_users WHERE chapter_id = " . $this->id . " AND user_id = " . $user->id;
        $command= $this->dbConnection->createCommand($sql);
        $result = $command->query();
        $row = $result->read();

        if ($quick) {    
            return $row['status'] == self::CHAPTER_PARTICIPANT_COMPLETE;
        }
        else {
            $problems = $this->problems;
            $subChapters = $this->getSubChapters();

            $retval = true;

            foreach ($subChapters as $chap) {
                $retval &= $chap->isCompleted($user , false , $problem_check);
            }

            if ($problem_check) {
                foreach ($problems as $problem) {
                    $retval &= $this->isProblemCompleted($user , $problem);
                }
            }

            //$this->setCompletion($user , ($retval) ? self::CHAPTER_PARTICIPANT_COMPLETE : self::CHAPTER_PARTICIPANT_WORKING);

            return $retval;
        }
    }


    public function isProblemCompleted($user , $problem) {
        $submitter_id = $user->id;
        $submission_status = false;
        $submissions = Submission::model()->findAll(array(
                        "condition" => "problem_id = $problem->id AND " .
                        "submitter_id = $submitter_id AND " .
                        "chapter_id = $this->id",
                        "order" => "submitted_time DESC"
                    ));

        foreach ($submissions as $sub) {
            $submission_status |= ($sub->score == 100) && ($sub->grade_status == Submission::GRADE_STATUS_GRADED);
        }
        return $submission_status;
    }

    public function setCompletion($user , $status = self::CHAPTER_PARTICIPANT_COMPLETE) {
        $sql = "SELECT * FROM chapters_users WHERE chapter_id = $this->id AND user_id = $user->id;";
        $command = $this->dbConnection->createCommand($sql);
        $result = $command->query();
        $row = $result->read();
        $prev_status = $row['status'];

        //echo $this->id . " " . $prev_status . " " . $status . "\n";

        if ($prev_status == self::CHAPTER_PARTICIPANT_WORKING && $status == self::CHAPTER_PARTICIPANT_COMPLETE) {
            //echo "OK\n";
            $sql = "UPDATE chapters_users SET status = $status, finish_time = NOW() WHERE user_id = $user->id AND chapter_id = $this->id";
        }
        else
            $sql = "UPDATE chapters_users SET status = $status WHERE user_id = $user->id AND chapter_id = $this->id";
        
        $command = $this->dbConnection->createCommand($sql);
        $command->execute();
    }

    public function setCompletionRecursive($user , $status = self::CHAPTER_PARTICIPANT_COMPLETE) {
        $this->setCompletion($user , $status);
        foreach ($this->getSubChapters() as $chapter) {
            $chapter->setCompletionRecursive($user , $status);
        }
    }

    public function reset($user) {
        $this->setCompletionRecursive($user , Chapter::CHAPTER_PARTICIPANT_WORKING);
        $chap = $this->getParentChapter();
        while ($chap !== NULL) {
            $chap->setCompletion($user , Chapter::CHAPTER_PARTICIPANT_WORKING);
            /*$chap2 = $chap->nextChapter;
            while ($chap2 !== NULL) {
                $chap2->setCompletionRecursive($user , Chapter::CHAPTER_PARTICIPANT_WORKING);
                $chap2 = $chap2->nextChapter;
            }*/
            $chap = $chap->getParentChapter();
        }
    }

    /*public function set($user) {
        $this->openBy($user);
        $this->setCompletion($user , self::CHAPTER_PARTICIPANT_WORKING);

        $chapter = $this->previousChapter;
        while ($chapter !== NULL) {
            
            $chapter = $this->previousChapter;
        }
    }*/

    public function openBy($user) {
        if (!$this->isOpened($user)) {
            $status = self::CHAPTER_PARTICIPANT_WORKING;
            $sql = "INSERT INTO chapters_users(chapter_id , user_id , status , start_time) VALUES($this->id , $user->id , $status , NOW())";
            
            $command = $this->dbConnection->createCommand($sql);
            $command->execute();

            if (count($this->getSubChapters()) == 0 && count($this->problems) == 0) {
                $this->updateUser($user);
            }
        }
    }

    public function getRequiredChapter() {
        if ($this->previousChapter !== NULL) {
            return $this->previousChapter;
        }
        else {
            if ($this->parentChapter === NULL)
                return NULL;
            else
                return $this->parentChapter->getRequiredChapter();
        }
    }

    public function getNextChapter() {
        if ($this->nextChapter !== NULL) {
            return $this->nextChapter;
        }
        else {
            if ($this->getParentChapter() === NULL)
                return NULL;
            else
                return $this->getParentChapter()->getNextChapter();
        }
    }

    public function defaultScope() {
        return array('order' => 'created_time DESC');
    }

    public function beforeSave(){
        if ($this->isNewRecord) {
            $this->created_time = new CDbExpression('NOW()');
        }
        return parent::beforeSave();
    }

    public function chapterExists($attribute, $params) {
        if (isset($this->$attribute) &&
            is_numeric($this->$attribute) &&
            (!self::model()->exists('id = '. $this->$attribute))){
            $this->addError($attribute, 'Chapter not found');
        }
    }


    public function getAverageFinishTime() {
        $sql = "SELECT TIMESTAMPDIFF(SECOND , start_time , finish_time) AS diff FROM chapters_users WHERE chapter_id = $this->id AND finish_time IS NOT NULL;";
        $command = $this->dbConnection->createCommand($sql);
        $rows = $command->queryAll();
        $total = 0;
        foreach($rows as $row)
            $total += $row['diff'];
        if (count($rows) != 0)
            return $total / count($rows);
        else
            return 0;
    }

    public function getActiveParticipants() {
        $status = self::CHAPTER_PARTICIPANT_WORKING;
        $sql = "SELECT * FROM chapters_users WHERE chapter_id = $this->id AND status = $status";
        $command = $this->dbConnection->createCommand($sql);
        return $command->query()->rowCount;
    }

    public function getFinishedProblems($user) {
        $retval = "";
        foreach ($this->problems as $problem) {
            if ($this->isProblemCompleted($user , $problem)) {
                $retval .= "<a href='".Yii::app()->controller->createUrl('supervisor/problem/view/id/' . $problem->id)."'>$problem->title</a><br />";
            }
        }
        return $retval;
    }


    /**
     * 
     * @param Problem $problem
     * @param integer problem rank
     * @return boolean whether the operation is successful
     */
    public function addProblem($problem, $rank = 0){
        /*$rowsAffected = $this->dbConnection->createCommand()
                        ->insert('chapters_problems', array(
                            'chapter_id' => $this->id,
                            'problem_id' => $problem->id
                        ))->execute();
        return ($rowsAffected == 1);*/
        $sql = "SELECT * FROM chapters_problems WHERE chapter_id = $this->id AND problem_id = $problem->id";
        $command = $this->dbConnection->createCommand($sql);
        $result = $command->query();
        if ($result->rowCount > 0) return;
        
        $sql = "INSERT INTO chapters_problems(chapter_id , problem_id) VALUES($this->id , $problem->id)";
        $command = $this->dbConnection->createCommand($sql);
        $command->execute();
    }


    /**
     * Return analytical report
     * @param <type> $pUser
     */
    public function getReport($pUser , $recursive = false) {
        $report = array();

        $report['completed'] = $this->isCompleted($pUser, true, false);

        $sql = "SELECT TIMESTAMPDIFF(SECOND , start_time , finish_time) AS diff FROM chapters_users WHERE chapter_id = $this->id AND finish_time IS NOT NULL AND user_id = $pUser->id;";
        $command = $this->dbConnection->createCommand($sql);
        $rows = $command->queryAll();
        $report['finishtime'] = !isset($rows[0]) ? "" : $rows[0]['diff'];
        $report['problemstatus'] = array();

        foreach ($this->problems as $problem) {
            $submitter_id = $pUser->id;
            $submissions = Submission::model()->findAll(array(
                            "condition" => "problem_id = $problem->id AND " .
                            "submitter_id = $submitter_id AND " .
                            "chapter_id = $this->id",
                            "order" => "submitted_time DESC"
                        ));

            $trial = count($submissions);
            $success = 0;
            foreach ($submissions as $sub) {
                if ($sub->verdict == "Accepted")
                    $success++;
            }

            $report['problemstatus'][$problem->id] = array();
            $report['problemstatus'][$problem->id]['trial'] = $trial;
            $report['problemstatus'][$problem->id]['success'] = $success;
        }

        return $report;
    }

    /**
     *
     * @param Problem $problem
     * @param integer problem rank
     * @return boolean whether the operation is successful
     */
    public function removeProblem($problem, $rank = 0){
        /*$rowsAffected = $this->dbConnection->createCommand()
                        ->delete('chapters_problems', 
                                'chapter_id = :chapter_id AND problem_id = :problem_id',
                                array(
                                    ':chapter_id' => $this->id,
                                    ':problem_id' => $problem->id
                                ))
                        ->execute();
        return ($rowsAffected == 1);*/
        $sql = "DELETE FROM chapters_problems WHERE chapter_id = $this->id AND problem_id = $problem->id";
        $command = $this->dbConnection->createCommand($sql);
        $command->execute();
    }

    /**
     *
     * @param Problem $problem
     * @return boolean whether the chapter has the problem
     */
    public function hasProblem($problem){
        $sql = "SELECT * FROM chapters_problems WHERE chapter_id = " . $this->id . " AND problem_id = " . $problem->id;
        $command= $this->dbConnection->createCommand($sql);
        $result = $command->query();

        return $result->rowCount > 0;
    }

    /**
     * Get all su$pLevelbchapters under this chapter recursively
     * @param <type> $pLevel
     * @return <type> complete recursive subchapters
     */
    public function getCompleteSubChapters($pLevel = 0) {
        if (!isset($this->mCompleteSubChapters)) {
            $subChapters = array();

            $tSubChapter = $this->firstSubChapter;
            while ($tSubChapter !== NULL) {
                $subChapters[] = array('chapter' => $tSubChapter , 'level' => $pLevel);
                $subChapters = array_merge($subChapters, $tSubChapter->getCompleteSubChapters($pLevel + 1));

                $tSubChapter = $tSubChapter->nextChapter;
            }

            $this->mCompleteSubChapters = $subChapters;
        }

        return $this->mCompleteSubChapters;
    }


    /**
     * Get subchapters who has parent this chapter
     * @return subchapter whose parent is this chapter
     */
    public function getSubChapters(){
        if (!isset($this->_subchapters)){
            //TODO:
            $this->_subchapters = array();

            $chapter = $this->firstSubChapter;

            while ($chapter !== NULL) {
                $this->_subchapters[] = $chapter;
                $chapter = $chapter->nextChapter;
            }
        }
        return $this->_subchapters;
    }
}
//end of file

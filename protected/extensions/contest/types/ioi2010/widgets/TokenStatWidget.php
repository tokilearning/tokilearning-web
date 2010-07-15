<?php

Yii::import("ext.contest.types.ioi2010.model.TokenUsage");

class TokenStatWidget extends CWidget {

    public $handler;

    public function run() {
        $action = $_GET['action'];

        switch ($action) {
            case 'generate' : $this->generate();
                break;
            case 'ajaxgenerate' : $this->generate();
                break;
        }

        $criteria = new CDbCriteria();
        $criteria->condition = 'contest_id = :contest_id';
        $criteria->params = array(
            'contest_id' => $this->handler->getContest()->id
        );
        
        if (isset($_GET['filterbycontestant']) && $_GET['filterbycontestant'] != "") {
            if (($uid = $_GET['filterbycontestant']) != 'all') {
                $criteria->addCondition('contestant_id = ' . $uid);
            }
        }
        if (isset($_GET['filterbyproblem'])) {
            if (($pid = $_GET['filterbyproblem']) != 'all') {
                $p = $this->handler->getContest()->getProblemByAlias($pid);
                $criteria->addCondition('problem_id = ' . $p->id);
            }
        }

        $dataProvider = new CActiveDataProvider('TokenUsage', array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => 20,
                    ),
                ));

        $this->render('tokenstat', array(
            'contest' => $this->handler->getContest(),
            'dataProvider' => $dataProvider
        ));
    }

    protected function generate() {
        $contest = $this->handler->getContest();
        $problems = $contest->problems;
        $contestants = $contest->contestants;

        $filteredProblem = $_POST['filterbyproblem'];
        $filteredContestant = $_POST['filterbycontestant'];

        ob_clean();

        foreach ($problems as $problem) {
            if ($filteredProblem == "all" || $filteredProblem != "all" && $contest->getProblemAlias($problem) == $filteredProblem) {
                foreach ($contestants as $contestant) {
                    if ($filteredContestant == "" || $filteredContestant != "" && $contestant->id == $filteredContestant) {
                        $record = TokenUsage::findFix($contest, $contestant, $problem);
                        if ($record == NULL) {
                            $record = new TokenUsage('Create');
                            $record->contest_id = $contest->id;
                            $record->problem_id = $problem->id;
                            $record->contestant_id = $contestant->id;
                        } else {
                            
                        }
                        
                        $record->amount = $_POST['max-token'];
                        $record->save();
                    }
                }
            }
        }

        echo "Token generated";
        exit;
    }

}

?>

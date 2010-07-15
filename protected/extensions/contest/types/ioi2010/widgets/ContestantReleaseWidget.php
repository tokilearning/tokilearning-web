<?php

class ContestantReleaseWidget extends CWidget {

    public $handler;
    
    protected function updateTokenAmount() {
        $tokenRegenTime = $this->handler->getContest()->getConfig('token_regen');
        if ($tokenRegenTime != NULL) {
            $tokenUsages = TokenUsage::findByContestContestant($this->handler->getContest() , Yii::app()->user);
            foreach ($tokenUsages as $u) {
                $u->updateAmount($tokenRegenTime);
            }
        }
    }

    public function run() {
        $dataProvider = new CActiveDataProvider('Submission', array(
                    'criteria' => array(
                        'condition' => 'submitter_id = :submitter_id AND contest_id = :contest_id',
                        'params' => array(
                            'submitter_id' => Yii::app()->user->getId(),
                            'contest_id' => $this->handler->getContest()->id
                        ),
                    ),
                    'pagination' => array(
                        'pageSize' => 20,
                    ),
                ));
        
        //$this->updateTokenAmount();
        
        $problems = $this->handler->getContest()->openproblems;
        $arproblems = array();
        foreach ($problems as $problem) {
            $arproblem = $problem->attributes;
            $arproblem['amount'] = TokenUsage::findFix($this->handler->getContest(), Yii::app()->user, $problem)->amount;
            $arproblems[] = $arproblem;
        }
        
        
        $problemsDataProvider = new CArrayDataProvider($arproblems, array(
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));

        $this->render('contestantrelease', array(
            'dataProvider' => $dataProvider,
            'problemsDataProvider' => $problemsDataProvider));
    }

}

<?php

class CContestController extends CMemberController {

    public $layout = 'application.views.layouts.contest';
    private $_contest; //The contest
    private $_role;

    public function init() {
        parent::init();
        $this->loadContest();
        $this->getContest()->signUser(Yii::app()->user, Yii::app()->request->pathInfo);
    }

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'expression' => 'Yii::app()->controller->isMember()'
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function getRole() {
        $this->_role = $this->getContest()->getRole(Yii::app()->user);
        return $this->_role;
    }

    private function loadContest() {
        if (isset($_GET['contestid'])) {
            $this->_contest = Contest::model()->findByPk($_GET['contestid']);
            if ($this->_contest === null) {
                throw new CHttpException(404, 'The requested contest not found.');
            } 
            else if ($this->_contest->isContestant(Yii::app()->user) && !$this->_contest->hasStarted()) {
                throw new CHttpException(404, 'Contest not started yet');
            }
            else {
                Yii::app()->session->add('contest', $this->_contest);
            }
        } else {
            $this->_contest = Yii::app()->session->itemAt('contest');
            if ($this->_contest === null) {
                throw new CHttpException(403, 'Unauthorized access');
            }
        }
        return $this->_contest;
    }

    public function createUrl($route, $params = array(), $ampersand='&') {
        //TODO: fix this //hard code
        if ((strpos($route, 'contest') !== false) && (strpos($route, 'contests') == false) && (($route !== '/contest' && $route !== '/supervisor/contest'))) {
            $params['contestid'] = $this->getContest()->id;
        }
        //echo $route;
        return parent::createUrl($route, $params, $ampersand);
    }

    public function getContest() {
        return $this->_contest;
    }

    protected function isMember($user = NULL) {
        return (($this->isOwner() || $this->isSupervisor() || $this->isContestant() || Group::checkMember("administrator", Yii::app()->user)) && !$this->isRegistrant());
    }

    protected function isOwner() {
        return $this->getContest()->isOwner(Yii::app()->user) || (Yii::app()->user->id == 1);
    }

    protected function isSupervisor() {
        return $this->getRole() == Contest::CONTEST_MEMBER_SUPERVISOR || (Group::checkMember("administrator", Yii::app()->user));
    }

    protected function isContestant() {
        return $this->getRole() == Contest::CONTEST_MEMBER_CONTESTANT;
    }

    protected function isRegistrant() {
        return $this->getRole() == Contest::CONTEST_MEMBER_REGISTRANT;
    }

    protected function isContestExpired() {
        return $this->getContest()->isExpired();
    }

}

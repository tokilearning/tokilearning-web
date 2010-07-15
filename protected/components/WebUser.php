<?php

/**
 *
 */
class WebUser extends CWebUser {

    private $record;
    private $last_criteria;

    public $behaviors = array(
	    'application.components.widgets.languagechooser.LanguageChooserUserBehavior',
	);

    public function getRecord($criteria = '') {
        if (!$this->isGuest) {
            if (!isset($this->record) ||
                    $this->record == null ||
                    !isset($this->last_criteria) ||
                    ($this->last_criteria != $criteria)) {
                $this->record = User::model()->findByPk($this->id, $criteria);
                //current record will be updated if new criteria is different from last criteria
                $this->last_criteria = $criteria;
            }
            return $this->record;
        } else {
            return false;
        }
    }

    public function updateLastActivity() {
        if (($record = $this->getRecord(array('select' => array('id')))) !== false) {
            $record->last_activity = new CDbExpression('NOW()');
            $record->save();
        }
    }

    public function login($identity, $duration=0) {
        parent::login($identity, $duration);
        $record = $this->getRecord();
        if (isset($record) && ($record != false)) {
            $record->last_login = new CDbExpression('NOW()');
            $record->last_ip = Yii::app()->request->getUserHostAddress();
            $record->logins++;
            $record->save(false);
        }
    }

}
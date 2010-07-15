<?php

/**
 *
 */
class WebUser extends CWebUser {

    private $record;

    public function getRecord() {
        if (!$this->isGuest) {
            if (!isset($this->record) || $this->record == null) {
                $this->record = User::model()->findByPk($this->id);
            }
            return $this->record;
        } else {
            return false;
        }
    }

    public function login($identity, $duration=0) {
        parent::login($identity, $duration);
        $record = $this->getRecord();
        if (isset($record) && ($record != false)){
            $record->last_login = new CDbExpression('NOW()');
            $record->last_ip = Yii::app()->request->getUserHostAddress();
            $record->logins++;
            $record->save(false);
        }
    }

}
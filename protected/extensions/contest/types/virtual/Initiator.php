<?php

class Initiator {

    public static function init($contest , $handler) {
        Yii::import($handler->getContestTypePathAlias() . '.models.VirtualContest');
        $model = VirtualContest::model()->findByPk($contest->id);
        if ($model === null) {
            $model = new VirtualContest('create');
            $model->id = $contest->id;
            $model->contest_id = $contest->id;
            $model->save(false);
        }

        if ($contest->isContestant(Yii::app()->user) && !$model->isActiveContestant(Yii::app()->user)) {
            $model->insertContestant(Yii::app()->user);
        }
    }
}
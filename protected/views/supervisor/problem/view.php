<?php $this->setPageTitle("Lihat Soal - ".$model->title);?>
<?php $this->renderPartial('_menu');?>
<?php $this->renderPartial('_viewheader', array('model' => $model));?>

<?php
Yii::import('ext.evaluator.ProblemTypeHandler');
$handler = ProblemTypeHandler::getHandler($model);
$handler->problemViewWidget(
            array(
                'problem' => $model,
                'contest' => null,
                'submitter' => Yii::app()->user,
                'submitStatus' => Submission::GRADE_STATUS_PENDING,
                'submitSuccessUrl' => array('submissions', 'id' => $model->id),
                'submitLocked' => false,
            )
        );
?>
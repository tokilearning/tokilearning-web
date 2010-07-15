<?php $this->renderPartial('_breadcrumb' , array('chapter' => $chapter , 'tid' => $this->training->id));?>
<?php $this->renderPartial('_menu', array('model' => $problem , 'training' => $training , 'chapter' => $chapter)); ?>
<?php
Yii::import('ext.evaluator.ProblemTypeHandler');
$handler = ProblemTypeHandler::getHandler($problem);
$handler->problemViewWidget(
        array(
            'problem' => $problem,
            'contest' => null,
            'chapter' => $chapter,
            'submitter' => Yii::app()->user,
            'submitStatus' => Submission::GRADE_STATUS_PENDING,
            'submitSuccessUrl' => Yii::app()->controller->createUrl("training/". $training->id . '/chapter/' . $chapter->id . '/problem/' . $problem->id),
            'submitLocked' => false,
        )
);
?>
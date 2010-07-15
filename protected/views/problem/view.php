<?php $this->setPageTitle($model->title); ?>
<?php $this->renderPartial('_menu', array('model' => $model)); ?>
<?php //if (true)://  ?>
<?php if ((!IPChecker::isInITB()) && (!IPChecker::isLocal())): ?>
<?php

$this->widget(
        'application.components.widgets.facebook.FBLikeWidget',
        array(
            'title' => $problem->title,
            'htmlOptions' => array('style' => 'float:right;'),
            'options' => array('layout' => 'button_count')
        )
);
?>
<?php endif; ?>
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
            'submitLocked' => $model->visibility != Problem::VISIBILITY_PUBLIC,
        )
);
?>

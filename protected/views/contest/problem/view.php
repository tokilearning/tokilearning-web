<?php $this->setPageTitle($model->title);?>
<?php $this->renderPartial('_menu', array('model' => $model)); ?>

<?php if ($this->isProblemClosed() || $this->isContestExpired()):?>
    <div class="error" style="text-align:center;font-weight:bold;">
        Pengumpulan untuk soal ini telah ditutup
    </div>
<?php endif;?>

<?php
Yii::import('ext.evaluator.ProblemTypeHandler');
$handler = ProblemTypeHandler::getHandler($model);
$handler->problemViewWidget(
            array(
                'problem' => $model,
                'contest' => $this->getContest(),
                'submitter' => Yii::app()->user,
                //'submitStatus' => Submission::GRADE_STATUS_NOGRADE,
		'submitStatus' => Submission::GRADE_STATUS_PENDING,
                'submitSuccessUrl' => array('contest/problem/submissions/alias/' . $_GET['alias']),
                'submitLocked' => (!$this->isProblemOpen() || $this->isContestExpired()),
                'submitLockedText' => Yii::t('contest', 'Pengumpulan soal ini ditutup')
            )
        );
?>

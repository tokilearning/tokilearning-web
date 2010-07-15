<?php
Yii::app()->clientScript->registerCss('submitform-css', '
    #submitform {margin:5px; padding:10px;border:1px solid #bbb;}
    
');
?>
<?php if (($this->getContest()->getProblemStatus($model) == Contest::CONTEST_PROBLEM_CLOSED) ||
            $this->getContest()->isExpired()
        ):?>
<div id="submitform">
    <div class="error" style="text-align:center;font-weight:bold;">
        Pengumpulan untuk soal ini telah ditutup
    </div>
</div>
<?php else:?>
<div id="submitform">
<?php if ($submission != null && $submission->hasErrors($answer)) :?>
    <?php echo CHtml::errorSummary($submission);?>
<?php endif;?>
<?php echo CHtml::beginForm($this->createUrl('submitAnswer', array('alias' => $this->getContest()->getProblemAlias($model))), 'post', array('enctype' => 'multipart/form-data'));?>
<?php echo ProblemHelper::renderSubmitForm($model);?>
<?php echo CHtml::submitButton('Kumpul');?>
<?php echo CHtml::endForm();?>
</div>
<?php endif;?>
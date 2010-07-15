<?php
Yii::app()->clientScript->registerCss('answer-css', '
        #answer .name {min-width:140px;}
    ');
;
?>
<?php
CSyntaxHighlighter::registerFiles($submission->getSubmitContent('source_lang'));
CSyntaxHighlighter::registerFiles('text');
?>
<div id="answer" class="section2">
    <?php if ($this->viewLevel == 0): ?>
        <h3 class="title"><?php echo Yii::t('evaluator', 'Jawaban');?></h3>
    <?php elseif ($this->viewLevel == 1): ?>
        <h3 class="title"><?php echo Yii::t('evaluator', 'Jawaban');?> #<?php echo $submission->id; ?></h3>
    <?php endif; ?>
    <div class="dtable">
        <div class="drow">
            <span class="name"><?php echo Yii::t('evaluator', 'Pengumpul');?></span>
            <span class=""><?php echo CHtml::link($submission->submitter->full_name . " (" . $submission->submitter->username . ")", $this->owner->createUrl('/problem/view', array('id' => $submission->problem_id))); ?></span>
        </div>
        <div class="drow">
            <span class="name"><?php echo Yii::t('evaluator', 'Soal'); ?></span>
            <span class=""><?php echo CHtml::link($submission->problem->title, $this->owner->createUrl('supervisor/problem/view', array('id' => $submission->problem_id))); ?></span>
        </div>
        <div class="drow">
            <span class="name"><?php echo Yii::t('evaluator', 'Waktu Terkumpul');?></span>
            <span class=""><?php echo CDateHelper::timespanAbbr($submission->submitted_time); ?></span>
        </div>
        <div class="drow">
            <span class="name"><?php echo Yii::t('evaluator', 'Status');?></span>
            <span class=""><?php echo $submission->getGradeStatus(); ?></span>
        </div>
    </div>
    <div class="dtable">
        <div class="drow">
            <span class="name"><?php echo Yii::t('evaluator', 'Bahasa Pemrograman');?></span>
            <span><?php echo $submission->getSubmitContent('source_lang'); ?></span>
        </div>
        <div class="drow">
            <span class="name"><?php echo Yii::t('evaluator', 'Nama Berkas');?></span>
            <span><?php echo $submission->getSubmitContent('original_name'); ?></span>
        </div>
        <div class="drow">
            <span class="name"><?php echo Yii::t('evaluator', 'Hasil');?></span>
            <span><?php echo $submission->getGradeContent('verdict'); ?></span>
        </div>
        <div class="drow">
            <span class="name"><?php echo Yii::t('evaluator', 'Nilai');?></span>
            <span><?php echo $submission->score; ?></span>
        </div>
        <div class="drow">
            <span class="name">Token</span>
            <span><?php echo ($submission->getSubmitContent('fullfeedback')) ? "Used" : "Unused"; ?></span>
        </div>
        <?php if ($submission->getReleaseLevel() > Submission::RELEASE_LEVEL_EASY || $submission->getSubmitContent('fullfeedback')): ?>
            <div class="drow">
                <span class="name"><?php echo Yii::t('evaluator', 'Nilai Resmi');?></span>
                <span class=""><?php echo $submission->getGradeContent('official_result'); ?></span>
            </div>
        <?php endif; ?>
        <?php if ($submission->getReleaseLevel() > Submission::RELEASE_LEVEL_EASY): ?>
            <div class="drow">
                <span class="name"><?php echo Yii::t('evaluator', 'Keluaran Evaluator Resmi');?></span>
                <span class=""></span>
            </div>
        </div>
        <div><pre class="brush: text"><?php echo $submission->getGradeContent('official_output'); ?></pre></div>
        <div class="dtable">
        <?php endif; ?>
        <?php if ($submission->contest == null || ($submission->contest_id != "" && ($submission->contest->isOwner(Yii::app()->user) || $submission->contest->isSupervisor(Yii::app()->user)))): ?>
        </div>
        <div><pre class="brush: text"><?php echo $submission->getGradeContent('tc_output'); ?></pre></div>
        <div class="dtable">
        <?php endif; ?>
        <div class="drow">
            <span class="name"><?php echo Yii::t('evaluator', 'Keluaran Evaluator');?></span>
            <span>
                <?php
                /* $content = str_replace("\n" , "<br />" , $submission->getGradeContent('output'));
                  $content = str_replace("\t" , "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" , $content);
                  echo $content; */
                ?>
            </span>
        </div>
        <div><pre class="brush: text"><?php echo $submission->getGradeContent('output'); ?></pre></div>
    </div>
</div>

<?php $this->setPageTitle("Jawaban");?>
<?php
Yii::app()->clientScript->registerCss('answer-css', '
        #answer .name {min-width:140px;}

    ');
;?>
<?php
CSyntaxHighlighter::registerFiles($model->getSubmitContent('source_lang'));
CSyntaxHighlighter::registerFiles('text');
?>
<div id="answer">
    <div class="dtable">
        <div class="drow">
            <span class="name">Pengumpul</span>
            <span class=""><?php echo $model->submitter->getFullnameLink();?></span>
        </div>
        <div class="drow">
            <span class="name">Soal</span>
            <span class=""><?php echo CHtml::link($model->problem->title, $this->createUrl('/problem/view', array('id' => $model->problem_id)));?></span>
        </div>
        <div class="drow">
            <span class="name">Waktu Terkumpul</span>
            <span class=""><?php echo CDateHelper::timespanAbbr($model->submitted_time);?></span>
        </div>
        <div class="drow">
            <span class="name">Status</span>
            <span class=""><?php echo $model->getGradeStatus();?></span>
        </div>
    </div>
    <?php ProblemHelper::renderAnswer($model);?>
</div>
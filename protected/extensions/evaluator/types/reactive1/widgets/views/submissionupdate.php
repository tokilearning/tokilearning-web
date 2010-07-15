<div id="answer" class="section2">
    <h3 class="title">Jawaban #<?php echo $submission->id;?></h3>
    <div class="dtable">
        <div class="drow">
            <span class="name">Soal</span>
            <span class=""><?php echo CHtml::link($submission->problem->title, $this->owner->createUrl('/problem/view', array('id' => $submission->problem_id))); ?></span>
        </div>
        <div class="drow">
            <span class="name">Waktu Terkumpul</span>
            <span class=""><?php echo CDateHelper::timespanAbbr($submission->submitted_time); ?></span>
        </div>
        <div class="drow">
            <span class="name">Pengumpul</span>
            <span class=""><?php echo CHtml::link($submission->submitter->getFullnameLink()); ?></span>
        </div>
    </div>
</div>

<div id="answer" class="section2">
    <?php echo CHtml::beginForm();?>
    <h3 class="title">Edit</h3>
    <div class="dtable">
        <div class="drow">
            <span class=""><?php echo CHtml::activeLabel($submission, 'verdict');?></span>
            <span class=""><?php echo CHtml::activeDropDownList($submission, 'verdict',
                    array(
                        'Accepted', 'Wrong Answer','Compile Error',
                        'Time Limit Exceeded', 'Memory Limit Exceeded',
                        'Forbidden syscall', 'File access forbidden'
            ));?></span>
        </div>
        <div class="drow">
            <span class=""><?php echo CHtml::activeLabel($submission, 'grade_status');?></span>
            <span class=""><?php echo CHtml::activeDropDownList($submission, 'grade_status', Submission::getGradeStatuses());?></span>
        </div>
        <div class="drow">
            <span class=""><?php echo CHtml::activeLabel($submission, 'score');?></span>
            <span class=""><?php echo CHtml::activeTextField($submission, 'score');?></span>
        </div>
        <div class="drow">
            <span></span>
            <span><?php echo CHtml::submitButton('Simpan');?></span>
        </div>
    </div>
    <?php echo CHtml::endForm();?>
</div>

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
    <h3 class="title">Informasi</h3>
    <div class="dtable">
        <div class="drow">
            <span class="name">Bahasa Pemrograman</span>
            <span><?php echo $submission->getSubmitContent('source_lang'); ?></span>
        </div>
        <div class="drow">
            <span class="name">Nama Berkas</span>
            <span><?php echo $submission->getSubmitContent('original_name'); ?></span>
        </div>
        <div class="drow">
            <span class="name">Hasil</span>
            <span><?php echo $submission->getGradeContent('verdict'); ?></span>
        </div>
        <div class="drow">
            <span class="name">Keluaran Evaluator</span>
            <span></span>
        </div>
    </div>
    <div><pre class="brush: text"><?php echo $submission->getGradeContent('output'); ?></pre></div>
    <div class="dtable">
        <div class="drow">
            <span class="name">Isi Berkas</span>
            <span>
            </span>
        </div>
    </div>
    <div>
        <pre class="brush: <?php echo $submission->getSubmitContent('source_lang'); ?>"><?php echo CHtml::encode($submission->getSubmitContent('source_content')); ?></pre>
    </div>

</div>

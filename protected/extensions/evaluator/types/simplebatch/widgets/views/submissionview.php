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
    <?php if($this->viewLevel == 0):?>
    <h3 class="title">Jawaban</h3>
    <?php elseif ($this->viewLevel == 1):?>
    <h3 class="title">Jawaban #<?php echo $submission->id;?></h3>
    <?php endif;?>
    <div class="dtable">
        <div class="drow">
            <span class="name">Soal</span>
            <span class=""><?php echo CHtml::link($submission->problem->title, $this->owner->createUrl('supervisor/problem/view', array('id' => $submission->problem_id))); ?></span>
        </div>
        <div class="drow">
            <span class="name">Waktu Terkumpul</span>
            <span class=""><?php echo CDateHelper::timespanAbbr($submission->submitted_time); ?></span>
        </div>
        <div class="drow">
            <span class="name">Status</span>
            <span class=""><?php echo $submission->getGradeStatus(); ?></span>
        </div>
    </div>
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
            <span class="name">Komentar</span>
            <span><?php echo $submission->comment; ?></span>
        </div>
        <div class="drow">
            <span class="name">Hasil</span>
            <span><?php echo $submission->getGradeContent('verdict'); ?></span>
        </div>
        <div class="drow">
            <span class="name">Nilai</span>
            <span><?php echo $submission->score; ?></span>
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
            <span></span>
            <span>
                <?php echo CHtml::link("Download as Text", $this->owner->createUrl("", array('id' => $submission->id , 'action' => 'download')), array('class' => 'linkbutton')); ?>
            </span>
        </div>
    </div>
    <div>
        <pre class="brush: <?php echo $submission->getSubmitContent('source_lang'); ?>"><?php echo CHtml::encode($submission->getSubmitContent('source_content')); ?></pre>
    </div>

</div>

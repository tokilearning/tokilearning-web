<?php
Yii::app()->clientScript->registerCss('answer-css', '
        #answer .name {min-width:140px;}
    ');
;
?>
<?php Yii::app()->clientScript->registerScript('selector-js' , "
    $('.code-selector').attr('checked' , true);
    $('.code-selector').change(function() {
        if($(this).val() == 'all') {
            if ($(this).attr('checked')) {
                $('.code-container').show();
                $('.code-selector').attr('checked' , true);
            }
            else {
                $('.code-container').hide();
                $('.code-selector').attr('checked' , false);
            }
        }
        else {
            if ($(this).attr('checked'))
                $('#code-'+$(this).val()).show();
            else
                $('#code-'+$(this).val()).hide();
        }
    });
");?>
<?php
CSyntaxHighlighter::registerFiles("pas");
CSyntaxHighlighter::registerFiles("c");
CSyntaxHighlighter::registerFiles("cpp");
CSyntaxHighlighter::registerFiles("java");
CSyntaxHighlighter::registerFiles('text');
?>
<div id="answer" class="section2">
    <?php if($this->viewLevel == 0):?>
    <h3 class="title"><?php echo Yii::t('evaluator', 'Jawaban');?></h3>
    <?php elseif ($this->viewLevel == 1):?>
    <h3 class="title"><?php echo Yii::t('evaluator', 'Jawaban');?> #<?php echo $submission->id;?></h3>
    <?php endif;?>
    <div class="dtable">
        <div class="drow">
            <span class="name"><?php echo Yii::t('evaluator', 'Soal'); ?></span>
            <span class=""><?php echo CHtml::link($submission->problem->title, $this->owner->createUrl('/problem/view', array('id' => $submission->problem_id))); ?></span>
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
            <span class="name"><?php echo Yii::t('evaluator', 'Waktu Terkumpul');?></span>
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
        <?php if (($submission->contest_id != "" && (!$submission->contest->getConfig('secret') || $submission->contest->isOwner(Yii::app()->user) || $submission->contest->isSupervisor(Yii::app()->user)))): ?>
        <div class="drow">
            <span class="name"><?php echo Yii::t('evaluator', 'Nilai Resmi');?></span>
            <span class=""><?php echo $submission->getGradeContent('official_result'); ?></span>
        </div>
        <div class="drow">
            <span class="name"><?php echo Yii::t('evaluator', 'Keluaran Evaluator Resmi');?></span>
            <span class=""></span>
        </div>
    </div>
    <div><pre class="brush: text"><?php echo $submission->getGradeContent('official_output'); ?></pre></div>
    <div class="dtable">
        <?php endif;?>
        <div class="drow">
            <span class="name"><?php echo Yii::t('evaluator', 'Keluaran Evaluator');?></span>
            <span></span>
        </div>
    </div>
    <div><pre class="brush: text"><?php echo $submission->getGradeContent('output'); ?></pre></div>
    <div class="dtable">
        <div class="drow">
            <span class="shead"><?php echo CHtml::link("Download Berkas", "?downloadsource", array('class' => 'linkbutton'));?></span>
            <span></span>
        </div>
    </div>
    <br />
    <div>
        <?php
            $data = array('all' => 'Semua');
            foreach ($files as $key => $file) {
                $data[$key] = basename($file);
            }
        ?>
        Pilih kode <?php echo CHtml::checkBoxList("code-selector", "", $data, array('class' => 'code-selector' , 'separator' => '&nbsp;'));?>
    </div>
    <?php foreach ($files as $key => $file) : ?>
    <div class="code-container" id="code-<?php echo $key;?>">
        <strong><?php echo basename($file);?></strong>
        <?php 
            $ext = CSourceHelper::getSourceExtension($file);
            if ($ext == 'h')
                $ext = "c";
            else if ($ext == "")
                $ext = "text";
        ?>
        <div><pre class="brush: <?php echo $ext;?>"><?php echo htmlspecialchars(file_get_contents($file)); ?></pre></div>
    </div>
    <?php endforeach;?>
</div>

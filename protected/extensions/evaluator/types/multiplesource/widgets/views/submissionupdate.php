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
                        'Accepted' => 'Accepted', 'Wrong Answer' => 'Wrong Answer','Compile Error' => 'Compile Error',
                        'Time Limit Exceeded' => 'Time Limit Exceeded', 'Memory Limit Exceeded' => 'Memory Limit Exceeded',
                        'Forbidden syscall' => 'Forbidden syscall', 'File access forbidden' => 'File access forbidden'
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

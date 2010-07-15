
<?php
$problem = $submission->problem;
$problems = $problem->getConfig('problems');
$randomseq = $submission->getSubmitContent('random_sequence');
$answers = $submission->getSubmitContent('answers');
?>
<?php if ($this->viewLevel == 0): ?>
    <div id="answer" class="section2">
        <h3 class="title"><?php echo Yii::t('evaluator', 'Informasi');?></h3>
        <div class="dtable">
            <div class="drow">
                <span class="name"><?php echo Yii::t('evaluator', 'Soal');?></span>
                <span class=""><?php echo CHtml::link($submission->problem->title, $this->owner->createUrl('/problem/view', array('id' => $submission->problem_id))); ?></span>
            </div>
            <div class="drow">
                <span class="name"><?php echo Yii::t('evaluator', 'Waktu Terkumpul');?></span>
                <span class=""><?php echo CDateHelper::timespanAbbr($submission->submitted_time); ?></span>
            </div>
        </div>
    </div>
    <?php
    $aranswer = array();
    foreach ($randomseq as $k => $r) {
        $aranswer[$k] = array(
            'no' => $k + 1,
            'answer' => $answers[$r]
        );
    }
    $dataProvider = new CArrayDataProvider($aranswer, array(
                'pagination' => array(
                    'pageSize' => 20,
                ),
            ));
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $dataProvider,
        'columns' => array(
            array(
                'name' => 'no',
                'value' => '$data[\'no\']',
                'header' => Yii::t('evaluator', 'Nomor')
            ),
            array(
                'name' => 'answer',
                'value' => '$data[\'answer\']',
                'header' => Yii::t('evaluator', 'Jawaban')
            ),
        ),
        'summaryText' => Yii::t('contest', 'Menampilkan {start}-{end} dari {count}.'),
        'enablePagination' => true,
        'cssFile' => Yii::app()->request->baseUrl . '/css/yii/gridview/style.css',
        'id' => 'contestantsgridview',
    ));
    ?>
<?php elseif ($this->viewLevel == 1): ?>
    <div id="answer" class="section2">
        <h3 class="title"><?php echo Yii::t('evaluator', 'Jawaban');?> #<?php echo $submission->id; ?></h3>
        <div class="dtable">
            <div class="drow">
                <span class="name"><?php echo Yii::t('evaluator', 'Soal');?></span>
                <span class=""><?php echo CHtml::link($submission->problem->title, $this->owner->createUrl('/problem/view', array('id' => $submission->problem_id))); ?></span>
            </div>
            <div class="drow">
                <span class="name"><?php echo Yii::t('evaluator', 'Waktu Terkumpul');?></span>
                <span class=""><?php echo CDateHelper::timespanAbbr($submission->submitted_time); ?></span>
            </div>
        </div>
    </div>
    <?php
    Yii::app()->clientScript->registerCss('submission-view-css', '
    pre {margin:0px;}
    td {vertical-align:top;}
');
    $aranswer = array();
    $rseq = array_flip($randomseq);
    foreach ($problems as $k => $p) {
        $aranswer[$k] = array(
            'no' => $k + 1,
            'original' => "--------------- (" . $p['point'] . ")\n" . $p['answer'],
            'random' => $rseq[$k] + 1,
            'answer' => isset($answers[$k]) ? $answers[$k] : '',
        );

        foreach ($p['alternatives'] as $alt) {
            $aranswer[$k]['original'] .= "\n--------------- (" . $alt['point'] . ")\n" . $alt['answer'];
        }

        $aranswer[$k]['original'] .= "\n---------------";
    }

    $dataProvider = new CArrayDataProvider($aranswer, array(
                'pagination' => array(
                    'pageSize' => 20,
                ),
            ));
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $dataProvider,
        'columns' => array(
            array(
                'name' => 'no',
                'header' => 'No',
            ),
            array(
                'name' => 'original',
                'header' => 'Jawaban Benar',
                'value' => '\'<pre>\'.$data[\'original\'].\'</pre>\'',
                'type' => 'raw'
            ),
            array(
                'name' => 'answer',
                'header' => Yii::t('evaluator', 'Jawaban Peserta'),
                'value' => '\'<pre>\'.$data[\'answer\'].\'</pre>\'',
                'type' => 'raw'
            ),
            array(
                'name' => 'random',
                'header' => Yii::t('evaluator', 'Urutan')
            ),
        ),
        'summaryText' => Yii::t('contest', 'Menampilkan {start}-{end} dari {count}.'),
        'enablePagination' => true,
        'cssFile' => Yii::app()->request->baseUrl . '/css/yii/gridview/style.css',
        'id' => 'contestantsgridview',
    ));
    ?>
    <?php
    CSyntaxHighlighter::registerFiles('text');
    ?>
    <div id="answer" class="section2">
        <h3 class="title"><?php echo Yii::t('evaluator', 'Keluaran');?></h3>
        <div class="dtable">
            <div class="drow">
                <span class="name"><?php echo Yii::t('evaluator', 'Nilai');?></span>
                <span class=""><?php echo $submission->score; ?></span>
            </div>
            <?php if ($submission->contest_id != "" && ($submission->contest->isOwner(Yii::app()->user) || $submission->contest->isSupervisor(Yii::app()->user))): ?>
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
            <?php endif; ?>
            <div class="drow">
                <span class="name"><?php echo Yii::t('evaluator', 'Keluaran');?></span>
                <span class=""></span>
            </div>
        </div>
        <div>
            <pre class="brush: text"><?php echo CHtml::encode($submission->getGradeContent('evaluator')); ?></pre>
        </div>
    </div>
<?php endif; ?>
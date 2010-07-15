<div id="answer" class="section2">
    <h3 class="title">Jawaban #<?php echo $submission->id; ?></h3>
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
    <?php echo CHtml::beginForm(); ?>
    <h3 class="title">Edit</h3>
    <div class="dtable">
        <div class="drow">
            <span class=""><?php echo CHtml::activeLabel($submission, 'grade_status'); ?></span>
            <span class=""><?php echo CHtml::activeDropDownList($submission, 'grade_status', Submission::getGradeStatuses()); ?></span>
        </div>
        <div class="drow">
            <span class=""><?php echo CHtml::activeLabel($submission, 'score'); ?></span>
            <span class=""><?php echo CHtml::activeTextField($submission, 'score'); ?></span>
        </div>
        <div class="drow">
            <span></span>
            <span><?php echo CHtml::submitButton('Simpan'); ?></span>
        </div>
    </div>
    <?php echo CHtml::endForm(); ?>
</div>

<?php
    $problem = $submission->problem;
    $problems = $problem->getConfig('problems');
    $randomseq = $submission->getSubmitContent('random_sequence');
    $answers = $submission->getSubmitContent('answers');
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
?>
    <div id="answer" class="section2">
        <h3 class="title">Jawaban Peserta</h3
    <?php
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
                'header' => 'Jawaban Peserta',
                'value' => '\'<pre>\'.$data[\'answer\'].\'</pre>\'',
                'type' => 'raw'
            ),
            array(
                'name' => 'random',
                'header' => 'Urutan'
            ),
        ),
        'summaryText' => Yii::t('contest', 'Menampilkan {start}-{end} dari {count}.'),
        'enablePagination' => true,
        'cssFile' => Yii::app()->request->baseUrl . '/css/yii/gridview/style.css',
        'id' => 'contestantsgridview',
    ));
    ?>
</div>
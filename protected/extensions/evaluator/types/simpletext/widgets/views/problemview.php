<?php
$problems = $problem->getConfig('problems');
$randomseq = $submission->getSubmitContent('random_sequence');

$problemidxs = array();
for($i = 1; $i <= count($problems); $i++){$problemidxs[$i] = $i;}
$questions = array();
$originalanswers = $submission->getSubmitContent('answers');
$answers = array();
foreach($randomseq as $r) {
    $questions[] = $problems[$r]['question'];
    $answers[] = isset($originalanswers[$r]) ? $originalanswers[$r] : '';
}

Yii::app()->clientScript->registerCss('problem-view-css', '
    #problem-wrapper h3 {border-bottom:1px solid #ccc;margin:0px 0px 10px 0px;}
    #problem-wrapper h4 {margin:2px 0px;}
    #problem-desc-wrapper {padding:10px;border:1px solid #bbb;margin:2px 0px;}
    #problem-chooser-wrapper {padding:10px;border:1px solid #bbb;margin:2px 0px;}
    #problem-question-wrapper{padding:10px;border:1px solid #bbb;margin:2px 0px;}
    #briefing {font-size:10px;padding:3px 5px;border:1px solid #ff0000;color:#000;background:#ffcccc;margin:3px 0px 0px 0px;}
    .backslider {font-size:18px;padding:3px;}
    .nextslider {font-size:18px;padding:3px;}
');
Yii::app()->clientScript->registerScriptFile($assets.'/problemview.js', CClientScript::POS_END );
Yii::app()->clientScript->registerScript('problem-desc-js', '
    var problemcount = '.count($problems).';
    var questions = '.CJSON::encode($questions).';
    var answers = '.CJSON::encode($answers).';
    var problemidx = 1;
', CClientScript::POS_HEAD);
?>
<?php echo CHtml::beginForm('?action=submit', 'post', array('enctype' => 'multipart/form-data'));?>
<div id="problem-wrapper">
    <div id="problem-chooser-wrapper">
        <h3>Daftar Soal</h3>
        <div>
            <div>
                <?php
                $this->widget('zii.widgets.jui.CJuiSlider', array(
                    'value' => 1,
                    // additional javascript options for the slider plugin
                    'options'=>array(
                        'min' => 1,
                        'max'=>count($problems),
                        'slide' => 'js:problemchooserslide',
                    ),
                    'htmlOptions'=>array(
                    ),
                    'id' => 'problemslider',
                ));

                ?>
            </div>
            <div style="border:1px solid #bbb;display:inline-block;margin:5px 5px 0px 0px;padding:0px 5px;">
                Soal ke <?php echo CHtml::dropDownList('problemchooser', 1, $problemidxs, array('id'=>'problemchooser'));?>
                dari <span id="problemcount"><?php echo count($problems);?></span>
                &nbsp;&nbsp;
                <?php echo CHtml::button('<', array('class' => 'backslider'));?>
                <?php echo CHtml::button('>', array('class' => 'nextslider'));?>
            </div>
            <?php if (!$this->submitLocked):?>
                <?php echo CHtml::submitButton('Simpan', array('id' => 'savebutton1', 'class' => 'savebutton', 'name' => 'Submission[save]'));?>
                <?php //echo CHtml::submitButton('Selesaikan', array('id' => 'finishbutton', 'name' => 'Submission[finish]'));?>
            <?php endif;?>
            <div id="briefing">
                Klik <strong>"Simpan"</strong> untuk menyimpan jawaban. <!--Klik <strong>"Selesaikan"</strong> untuk menyelesaikan soal.-->
                Untuk berjaga-jaga jangan lupa catat jawaban kamu di selembar kertas.
                
            </div>
        </div>
    </div>
    <div id="problem-desc-wrapper">
        <h4>Pertanyaan</h4>
        <div id="problem-question-wrapper"><?php echo $questions[0];?></div>
        <?php if (!$this->submitLocked):?>
        <h4>Jawaban</h4>
        <?php echo CHtml::textArea('problemanswer', $answers[0], array('style' => 'width:97%;height:100px;', 'id' => 'problemanswer', 'rows' => '4')); ?>

        <div>
            <?php echo CHtml::button('<', array('class' => 'backslider'));?>
            <?php echo CHtml::button('>', array('class' => 'nextslider'));?>
            <?php echo CHtml::submitButton('Simpan', array('id' => 'savebutton2', 'class' => 'savebutton', 'name' => 'Submission[save]'));?>
        </div>
        <div id="datawrapper">
        </div>
        <?php endif;?>
    </div>
</div>
<?php echo CHtml::endForm();?>
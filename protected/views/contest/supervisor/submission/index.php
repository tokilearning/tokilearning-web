<?php $this->setPageTitle("Jawaban"); ?>
<?php $contest = $this->getContest(); ?>
<?php Yii::app()->clientScript->registerCoreScript("jquery.js"); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/scripts/jquery.timers.js"); ?>
<?php Yii::app()->clientScript->registerCss('filter-css', '
    #filter {border:1px solid #ddd;width:100%;}
    .graded {color:#0000ff;font-weight:bold;}
    .pending {color:#00ff00;font-weight:bold;}
    .error {color:#ff0000;font-weight:bold;}
    .no-grade {color:#000000;font-weight:bold;}
'); ?>
<?php //Yii::app()->clientScript->registerScript('tooltip-js', "$('#regradebutton, #selectiveregradebutton').tooltip();");?>
<?php Yii::app()->clientScript->registerScript('filter-js', '
    var update_filter = function(){
        $(\'#submissiongridview\').yiiGridView.update(\'submissiongridview\', {
            url:\'?filterproblem=\'+$(\'#filterbyproblem\').val()+\'&filtercontestant=\'+$(\'#filterbycontestant\').val()
        });
    }
    $("#refreshbutton").click(function() {
        $(\'#submissiongridview\').yiiGridView.update(\'submissiongridview\');
    });

    $("#filterbycontestant").keydown(function(event) {
        if (event.which == 13) {
            update_filter();
        }
    });

    $(\'#filterbyproblem\').change(update_filter);
    //$(\'#filterbycontestant\').change(update_filter);
    $(\'#filterbutton\').click(update_filter);
    $("#regradebutton").click(function(){
        if(!$("#all-subs-cb").attr("checked")) {
            $("#selectiveregradebutton").trigger("click");
            return false;
        }

        var ok = confirm("Anda akan menilai ulang seluruh jawaban yang telah disaring, termasuk di halaman lainnya. Apakah anda yakin?");
        if (!ok) return false;

        ok = confirm("Apakah anda yakin?");
        if (!ok) return false;

        $.ajax({
            url: "'.$this->createUrl('contest/supervisor/submission/QuickRegrade').'",
            type: "POST",
            data: "problem_id=" + $(\'#filterbyproblem\').val() + "&submitter_id=" + $(\'#filterbycontestant\').val() + "&YII_CSRF_TOKEN='.Yii::app()->request->csrfToken.'",
            success : function() {
                update_filter();
            }
        });
    });
'); ?>

<div class="dtable" id="filter">
    <div class="drow">
        <span class="shead"><?php echo Yii::t('contest', 'Saring Per Soal');?></span>
        <span>
            <?php
            $arfilterproblem = array('all' => 'Semua Soal');
            $problems = $contest->problems;
            foreach ($problems as $problem) {
                $arfilterproblem[$contest->getProblemAlias($problem)] = $contest->getProblemAlias($problem) . ". " . $problem->title;
            }
            ?>
            <?php echo CHtml::dropDownList('filterbyproblem', 'all', $arfilterproblem, array('id' => 'filterbyproblem')); ?>
        </span>
    </div>
    <div class="drow">
        <span class="shead">Saring per Kontestan</span>
        <span>
            <?php
            $arfiltercontestant = array('all' => 'Semua Kontestan');
            $contestants = $contest->contestants;
            foreach ($contestants as $contestant) {
                $arfiltercontestant[$contestant->id] = $contestant->id . ". (" . $contestant->username . ") " . $contestant->full_name;
            }
            ?>
            <?php $this->widget('zii.widgets.jui.CJuiAutoComplete',
                array(
                    'name' => 'filterbycontestant',
                    'sourceUrl' => array('contest/supervisor/member/contestantlookup?contestantfilter=true'),
                ));
            ?>
            <?php //echo CHtml::dropDownList('filterbycontestant', 'all', $arfiltercontestant, array('id' => 'filterbycontestant')); ?>
        </span>
        <span>
            <?php //echo CHtml::button('Nilai Ulang Cepat', array('id' => 'regradebutton' , 'title' => 'Menilai ulang semua jawaban yang sudah disaring')); ?>
        </span>
    </div>
    <div class="drow">
        <span></span>
        <span><?php echo CHtml::button('Muat Ulang', array('id' => 'refreshbutton')); ?>
        <?php echo CHtml::button('Saring', array('id' => 'filterbutton')); ?></span>
    </div>
</div>
<br/>
    <?php echo CHtml::beginForm();?>
<div>
    <?php echo CHtml::checkBox("all", false, array('id' => 'all-subs-cb'));?>Semua jawaban
    <?php echo CHtml::ajaxSubmitButton('Nilai Ulang', $this->createUrl('contest/supervisor/submission/BatchRegrade'), array(
        'success' => "function(data, textStatus, XMLHttpRequest) { $('#submissiongridview').yiiGridView.update('submissiongridview');}"
    ) , array('style' => 'display: none;' , 'id' => 'selectiveregradebutton' , 'title' => 'Menilai ulang semua jawaban yang sudah dipilih di halaman ini')); ?>
    <?php echo CHtml::button('Nilai Ulang', array('id' => 'regradebutton' , 'title' => 'Menilai ulang semua jawaban yang sudah disaring')); ?>
    <?php echo CHtml::ajaxSubmitButton('Lewatkan', $this->createUrl('contest/supervisor/submission/BatchSkip'), array(
        'success' => "function(data, textStatus, XMLHttpRequest) { $('#submissiongridview').yiiGridView.update('submissiongridview');}"
    )); ?>
</div>
    <br/>
<?php
$contest = $this->contest;
            $this->widget('zii.widgets.grid.CGridView', array(
                'dataProvider' => $dataProvider,
                'columns' => array(
                    array(
                        'class' => 'CCheckBoxColumn',
                        'id' => 'mark'
                    ),
                    array (
                        'name' => 'id',
                        'value' => '\'<a title="\'.$data->getGradeStatus().\'" class=\\\'\'.str_replace(\' \', \'-\', strtolower($data->getGradeStatus())).\'\\\'>\'' . '.$data->primaryKey.' . "'</a>'",
                        'header' => 'ID',
                        'sortable' => false,
						'type' => 'raw'
                    ),
                    array(
                        'name' => 'submitted_time',
                        'value' => 'CDateHelper::timespanAbbr($data->submitted_time)',
                        'type' => 'raw'
                    ),
                    array(
                        'name' => 'problem_id',
                        'value' => '$data->contest->getProblemAlias($data->problem) . ") " . $data->problem->title'
                    ),
                    array(
                        'name' => 'submitter_id',
                        'value' => '$data->submitter->username . " - " . $data->submitter->getFullnameLink()',
                        'type' => 'raw'
                    ),
                    /*array(
                        'name' => 'grade_time',
                        'value' => 'CDateHelper::timespanAbbr($data->grade_time)',
                        'type' => 'raw'
                    ),*/
                    /*array(
                        'name' => 'grade_status',
                        'value' => '\'<span class=\\\'\'.str_replace(\' \', \'-\', strtolower($data->getGradeStatus())).\'\\\'>\'.$data->getGradeStatus().\'</span>\'',
                        'type' => 'raw',
                    ),*/
                    /*array(
                        'name' => 'verdict',
                        'header' => 'Verdict',
                        
                    ),*/
                    array(
                        'name' => 'score',
                        'header' => 'Score',
                        'value' => '$data[\'score\']',
                        'type' => 'raw'
                    ),
                    array(
                        'name' => 'verdict',
                        'header' => 'Verdict',
                        'value' => '$data[\'verdict\'] . " [" . $data->getGradeContent("official_result") . "]"',
                        'type' => 'raw'
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{view}{update}{regrade}',
                        'viewButtonUrl' => 'Yii::app()->controller->createUrl(\'contest/supervisor/submission/view\', array(\'id\' => $data->id))',
                        'viewButtonOptions' => array('target' => '_blank'),
                        'updateButtonOptions' => array('target' => '_blank'),
                        'buttons' => array(
                            'regrade' => array(
                                'label' => 'Regrade',
                                'imageUrl' => Yii::app()->request->baseUrl."/images/icons/repeat-16px.png",
                                'url' => 'Yii::app()->controller->createUrl(\'regrade\', array(\'id\' => $data->primaryKey))',
                            )
                        )
                    )
                ),
                'selectableRows' => 30,
                'cssFile' => Yii::app()->request->baseUrl . '/css/yii/gridview/style.css',
                'id' => 'submissiongridview',
            ));
?>
<div>
    <?php echo CHtml::ajaxSubmitButton('Nilai Ulang', $this->createUrl('contest/supervisor/submission/BatchRegrade'), array(
        'success' => "function(data, textStatus, XMLHttpRequest) { $('#submissiongridview').yiiGridView.update('submissiongridview');}"
    )); ?>
    <?php echo CHtml::ajaxSubmitButton('Lewatkan', $this->createUrl('contest/supervisor/submission/BatchSkip'), array(
        'success' => "function(data, textStatus, XMLHttpRequest) { $('#submissiongridview').yiiGridView.update('submissiongridview');}"
    )); ?>
</div>
    <?php echo CHtml::endForm();?>

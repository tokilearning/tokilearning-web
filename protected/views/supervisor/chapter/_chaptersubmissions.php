<?php Yii::app()->clientScript->registerCoreScript("jquery.js"); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/scripts/jquery.timers.js"); ?>
<?php Yii::app()->clientScript->registerCss('filter-css', '
    #filter {border:1px solid #ddd;width:100%;}
    .graded {color:#0000ff;font-weight:bold;}
    .pending {color:#00ff00;font-weight:bold;}
    .error {color:#ff0000;font-weight:bold;}
    .no-grade {color:#000000;font-weight:bold;}
'); ?>
<?php Yii::app()->clientScript->registerScript('filter-js', '
    var update_filter = function(){
        $(\'#submissiongridview\').yiiGridView.update(\'submissiongridview\', {
            url:\'?filterproblem=\'+$(\'#filterbyproblem\').val()+\'&filtercontestant=\'+$(\'#filterbycontestant\').val()
        });
    }
    $(document).everyTime(\'10s\',function(i) {
        $(\'#submissiongridview\').yiiGridView.update(\'submissiongridview\');
    });
    $(\'#filterbyproblem\').change(update_filter);
    $(\'#filterbycontestant\').change(update_filter);
    $(\'#filterbutton\').click(update_filter);
    $("#regradebutton").click(function(){
        var ok = confirm("Do you really want to perform this action? This action can not be UNDONE");
        if (!ok) return false;

        ok = confirm("Are you sure? This is the last warning");
        if (!ok) return false;

        $.ajax({
            url: "'.$this->createUrl('supervisor/chapter/quickregrade/id/' . $model->id).'",
            type: "POST",
            data: "problem_id=" + $(\'#filterbyproblem\').val() + "&submitter_id=" + $(\'#filterbycontestant\').val(),
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
            $problems = $model->problems;
            foreach ($problems as $problem) {
                $arfilterproblem[$problem->id] = $problem->id . ". " . $problem->title;
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
            $participants = $model->participants;
            foreach ($participants as $participant) {
                $arfiltercontestant[$participant->id] = $participant->id . ". (" . $participant->username . ") " . substr($participant->full_name , 0 , 50);
            }
            ?>
            <?php echo CHtml::dropDownList('filterbycontestant', 'all', $arfiltercontestant, array('id' => 'filterbycontestant')); ?>
        </span>
    </div>
    <div class="drow">
        <span>
        <?php echo CHtml::button('Saring', array('id' => 'filterbutton')); ?>
        </span>
		<span>
		<?php echo CHtml::button('Nilai Ulang Cepat', array('id' => 'regradebutton')); ?>
		</span>
    </div>
	<div class="drow">
        <span></span>
        <span><em>Anda dapat menilai ulang cepat pada jawaban yang sudah anda saring</em></span>
    </div>
</div>
<?php echo CHtml::beginForm();?>
<?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $dataProvider,
        'columns' => array(
            array(
                'class' => 'CCheckBoxColumn',
                'id' => 'mark'
            ),
            array (
                'name' => 'id',
                'value' => '$data->primaryKey',
                'header' => 'ID',
                'sortable' => false
            ),
            array(
                'name' => 'submitted_time',
                'value' => 'CDateHelper::timespanAbbr($data->submitted_time)',
                'type' => 'raw'
            ),
            array(
                'name' => 'problem_id',
                'value' => '$data->problem->title'
            ),
            array(
                'name' => 'submitter_id',
                'value' => '$data->submitter->username . " - " . $data->submitter->getFullnameLink()',
                'type' => 'raw'
            ),
            array(
                'name' => 'grade_time',
                'value' => 'CDateHelper::timespanAbbr($data->grade_time)',
                'type' => 'raw'
            ),
            array(
                'name' => 'grade_status',
                'value' => '\'<span class=\\\'\'.str_replace(\' \', \'-\', strtolower($data->getGradeStatus())).\'\\\'>\'.$data->getGradeStatus().\'</span>\'',
                'type' => 'raw',
            ),
            array(
                'name' => 'verdict',
                'header' => 'Verdict',

            ),
            array(
                'name' => 'score',
                'header' => 'Score',
            ),
            array(
                'class' => 'CButtonColumn',
                'template' => '{view}{update}{regrade}',
                'viewButtonUrl' => 'Yii::app()->controller->createUrl(\'view\', array(\'id\' => $data->id))',
                'viewButtonOptions' => array('target' => '_blank'),
                'updateButtonOptions' => array('target' => '_blank'),
                'buttons' => array(
                    'regrade' => array(
                        'label' => 'Regrade',
                        'imageUrl' => Yii::app()->request->baseUrl."/images/icons/repeat-16px.png",
                        'url' => 'Yii::app()->controller->createUrl(\'supervisor/submission/regrade\', array(\'id\' => $data->primaryKey))',
                    ),
                    'view' => array(
                        'label' => 'View',
                        'url' => 'Yii::app()->controller->createUrl(\'supervisor/submission/view\', array(\'id\' => $data->primaryKey))',
                    ),
                    'update' => array(
                        'label' => 'Update',
                        'url' => 'Yii::app()->controller->createUrl(\'supervisor/submission/update\', array(\'id\' => $data->primaryKey))',
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
    <?php echo CHtml::ajaxSubmitButton('Nilai Ulang', $this->createUrl('supervisor/submission/BatchRegrade'), array(
        'success' => "function(data, textStatus, XMLHttpRequest) { $('#submissiongridview').yiiGridView.update('submissiongridview');}"
    )); ?>
    <?php echo CHtml::ajaxSubmitButton('Lewatkan', $this->createUrl('supervisor/submission/BatchRegrade'), array(
        'success' => "function(data, textStatus, XMLHttpRequest) { $('#submissiongridview').yiiGridView.update('submissiongridview');}"
    )); ?>
</div>
<?php echo CHtml::endForm();?>
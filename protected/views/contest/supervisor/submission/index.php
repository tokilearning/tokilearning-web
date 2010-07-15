<?php $this->setPageTitle("Jawaban"); ?>
<?php $contest = $this->getContest(); ?>
<?php Yii::app()->clientScript->registerCoreScript("jquery.js"); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/scripts/jquery.timers.js"); ?>
<?php Yii::app()->clientScript->registerCss('filter-css', '
    #filter {border:1px solid #ddd;width:100%;}
    .graded {color:#0000ff;font-weight:bold;}
    .pending {color:#00ff00;font-weight:bold;}
    .error {color:#ff0000;font-weight:bold;}
'); ?>
<?php Yii::app()->clientScript->registerScript('filter-js', '
    $(document).everyTime(\'10s\',function(i) {
        $(\'#submissiongridview\').yiiGridView.update(\'submissiongridview\');
    });
    $(\'#filterbutton\').click(function(){
        $(\'#submissiongridview\').yiiGridView.update(\'submissiongridview\', {
            url:\'?filterproblem=\'+$(\'#filterbyproblem\').val()+\'&filtercontestant=\'+$(\'#filterbycontestant\').val()
        });
    });
'); ?>

<div class="dtable" id="filter">
    <div class="drow">
        <span class="shead">Saring per Soal</span>
        <span>
            <?php
            $arfilterproblem = array('all' => 'Semua Soal');
            $problems = $contest->openproblems;
            foreach ($problems as $problem) {
                $arfilterproblem[$contest->getProblemAlias($problem)] = $contest->getProblemAlias($problem) . ". " . $problem->title;
            }
            ?>
            <?php echo CHtml::dropDownList('filterbyproblem', 'all', $arfilterproblem, array('id' => 'filterbyproblem')); ?>
        </span>
        <span class="shead">Saring per Kontestan</span>
        <span>
            <?php
            $arfiltercontestant = array('all' => 'Semua Kontestan');
            $contestants = $contest->contestants;
            foreach ($contestants as $contestant) {
                $arfiltercontestant[$contestant->id] = $contestant->id . ". " . $contestant->full_name;
            }
            ?>
            <?php echo CHtml::dropDownList('filterbycontestant', 'all', $arfiltercontestant, array('id' => 'filterbycontestant')); ?>
        </span>
        <span
        <?php echo CHtml::button('Saring', array('id' => 'filterbutton')); ?>
        </span>
    </div>
    </div>
    <br/>
    <?php echo CHtml::beginForm();?>
<div>
    <?php echo CHtml::ajaxSubmitButton('Nilai Ulang', $this->createUrl('AJAXRegrade'), array(
        'success' => "function(data, textStatus, XMLHttpRequest) { $('#submissiongridview').yiiGridView.update('submissiongridview');}"
    )); ?>
</div>
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
                        'value' => '$data->submitter->getFullnameLink()',
                        'type' => 'raw'
                    ),
                    array(
                        'name' => 'grade_time',
                        'value' => 'CDateHelper::timespanAbbr($data->grade_time)',
                        'type' => 'raw'
                    ),
                    array(
                        'name' => 'grade_status',
                        'value' => '\'<span class=\\\'\'.strtolower($data->getGradeStatus()).\'\\\'>\'.$data->getGradeStatus().\'</span>\'',
                        'type' => 'raw',
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{view}{regrade}',
                        'viewButtonUrl' => 'Yii::app()->controller->createUrl(\'view\', array(\'id\' => $data->id))',
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
    <?php echo CHtml::ajaxSubmitButton('Nilai Ulang', $this->createUrl('AJAXRegrade'), array(
        'success' => "function(data, textStatus, XMLHttpRequest) { $('#submissiongridview').yiiGridView.update('submissiongridview');}"
    )); ?>
</div>
    <?php echo CHtml::endForm();?>
<?php $this->setPageTitle("Jawaban");?>
<?php $this->renderPartial('_menu');?>
<?php Yii::app()->clientScript->registerCoreScript("jquery.js"); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/scripts/jquery.timers.js"); ?>
<?php Yii::app()->clientScript->registerScript('timer-js', '
    $(document).everyTime(\'10s\',function(i) {
        $(\'#submissiongridview\').yiiGridView.update(\'submissiongridview\');
    });
    $(\'#filterbutton\').click(function(){
        var filterproblem = \'all\';
        if ($(\'#checkfilterproblem\').attr(\'checked\')){
            filterproblem = $(\'#problem_lookup\').val();
        }
        var filtermember = \'all\';
        if ($(\'#checkfiltermember\').attr(\'checked\')){
            filtermember = $(\'#member_lookup\').val();
        }
        $(\'#submissiongridview\').yiiGridView.update(\'submissiongridview\', {
            url:\'?filterproblem=\'+filterproblem+\'&filtermember=\'+filtermember
        });
    });
');?>
<?php Yii::app()->clientScript->registerCss('submission-css', '
     #filter {border:1px solid #ddd;width:100%;}
    .graded {color:#0000ff;font-weight:bold;}
    .pending {color:#00ff00;font-weight:bold;}
    .error {color:#ff0000;font-weight:bold;}
    .no-grade {color:#000000;font-weight:bold;}
');
?>
<div class="dtable" id="filter">
    <div class="drow">
        <span class="shead">
            <?php echo CHtml::checkBox('checkfilterproblem');?>
            <?php echo Yii::t('contest', 'Saring Per Soal');?>
        </span>
        <span>
        <?php $this->widget('zii.widgets.jui.CJuiAutoComplete',
          array(
                'name' => 'problem_lookup',
                'sourceUrl' => array('problemlookup')
             ));
        ?>
        </span>
        <span class="shead">
            <?php echo CHtml::checkBox('checkfiltermember');?>
            Saring per Anggota
        </span>
        <span>
        <?php $this->widget('zii.widgets.jui.CJuiAutoComplete',
          array(
                'name' => 'member_lookup',
                'sourceUrl' => array('memberlookup'),
             ));
        ?>
        </span>
        <span
        <?php echo CHtml::button('Saring', array('id' => 'filterbutton')); ?>
        </span>
    </div>
</div>
    <br/>
<?php echo CHtml::beginForm();?>
<div>
    <?php echo CHtml::ajaxSubmitButton('Nilai Ulang', $this->createUrl('BatchRegrade'), array(
        'success' => "function(data, textStatus, XMLHttpRequest) { $('#submissiongridview').yiiGridView.update('submissiongridview');}"
    )); ?>
    <?php echo CHtml::ajaxSubmitButton('Lewatkan', $this->createUrl('BatchSkip'), array(
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
                'value' => 'CHtml::link($data->problem->title, Yii::app()->controller->createUrl(\'/supervisor/problem/view\', array(\'id\' => $data->problem_id)))',
                'type' => 'raw'
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
                'value' => '\'<span class=\\\'\'.str_replace(\' \', \'-\', strtolower($data->getGradeStatus())).\'\\\'>\'.$data->getGradeStatus().\'</span>\'',
                'type' => 'raw',
            ),
	    array(
		'header'=> 'Verdict',
		//'value' => '$data->getGradeContent(\'verdict\')',
                'value' => '$data->verdict',
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
                        'url' => 'Yii::app()->controller->createUrl(\'regrade\', array(\'id\' => $data->primaryKey))',
                    )
                )
            )
        ),
        'summaryText' => Yii::t('contest', 'Menampilkan {start}-{end} dari {count}.'),
        'emptyText' => Yii::t('contest', 'Belum ada jawaban yang sudah dikumpulkan'),
        'enablePagination' => true,
        
        'selectableRows' => 30,
        'cssFile' => Yii::app()->request->baseUrl.'/css/yii/gridview/style.css',
        'id' => 'submissiongridview',
    ));
?>
<div>
    <?php echo CHtml::ajaxSubmitButton('Nilai Ulang', $this->createUrl('BatchRegrade'), array(
        'success' => "function(data, textStatus, XMLHttpRequest) { $('#submissiongridview').yiiGridView.update('submissiongridview');}"
    )); ?>
    <?php echo CHtml::ajaxSubmitButton('Lewatkan', $this->createUrl('BatchSkip'), array(
        'success' => "function(data, textStatus, XMLHttpRequest) { $('#submissiongridview').yiiGridView.update('submissiongridview');}"
    )); ?>
</div>
<?php echo CHtml::endForm();?>

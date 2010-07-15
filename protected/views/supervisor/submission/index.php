<?php $this->setPageTitle("Jawaban");?>
<?php $this->renderPartial('_menu');?>
<?php Yii::app()->clientScript->registerCoreScript("jquery.js"); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/scripts/jquery.timers.js"); ?>
<?php Yii::app()->clientScript->registerScript('timer-js', '
    $(document).everyTime(\'10s\',function(i) {
        $(\'#submissionsgridview\').yiiGridView.update(\'submissionsgridview\');
    });
    $(\'#filterbutton\').click(function(){
        var filterproblem = \'all\';
        if ($(\'#checkfilterproblem\').attr(\'checked\')){
            filterproblem = $(\'#filterproblem_id\').val();
        }
        var filtermember = \'all\';
        if ($(\'#checkfiltermember\').attr(\'checked\')){
            filtermember = $(\'#filtermember_id\').val();
        }
        $(\'#submissionsgridview\').yiiGridView.update(\'submissionsgridview\', {
            url:\'?filterproblem=\'+filterproblem+\'&filtermember=\'+filtermember
        });
    });
');?>
<?php Yii::app()->clientScript->registerCss('submission-css', '
     #filter {border:1px solid #ddd;width:100%;}
    .graded {color:#0000ff;font-weight:bold;}
    .pending {color:#00ff00;font-weight:bold;}
    .error {color:#ff0000;font-weight:bold;}
');
?>
<div class="dtable" id="filter">
    <div class="drow">
        <span class="shead">
            <?php echo CHtml::checkBox('checkfilterproblem');?>
            Saring per Soal
        </span>
        <span>
        <?php $this->widget('CAutoComplete',
          array(
             'name' => 'problem_lookup',
             'url' => array('problemlookup'),
             'max' => 10,
             'minChars' => 1,
             'delay' => 500,
             'matchCase' => false,
             'htmlOptions' => array('size'=>'20'),
             'methodChain' => ".result(function(event,item){\$(\"#filterproblem_id\").val(item[1]);})",
             ));
        ?>
        <?php echo CHtml::hiddenField('filterproblem_id'); ?>
        </span>
        <span class="shead">
            <?php echo CHtml::checkBox('checkfiltermember');?>
            Saring per Anggota
        </span>
        <span>
        <?php $this->widget('CAutoComplete',
          array(
             'name' => 'contestant_lookup',
             'url' => array('memberlookup'),
             'max' => 10,
             'minChars' => 1,
             'delay' => 500,
             'matchCase' => false,
             'htmlOptions' => array('size'=>'20'),
             'methodChain' => ".result(function(event,item){\$(\"#filtermember_id\").val(item[1]);})",
             ));
        ?>
        <?php echo CHtml::hiddenField('filtermember_id'); ?>
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
        'success' => "function(data, textStatus, XMLHttpRequest) { $('#submissionsgridview').yiiGridView.update('submissionsgridview');}"
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
                'value' => 'CHtml::link($data->problem->title, Yii::app()->controller->createUrl(\'/problem/view\', array(\'id\' => $data->problem_id)))',
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
        'summaryText' => 'Menampilkan {start}-{end} dari {count}.',
        'emptyText' => 'Belum ada jawaban yang sudah dikumpulkan',
        'enablePagination' => true,
        
        'selectableRows' => 30,
        'cssFile' => Yii::app()->request->baseUrl.'/css/yii/gridview/style.css',
        'id' => 'submissionsgridview',
    ));
?>
<div>
    <?php echo CHtml::ajaxSubmitButton('Nilai Ulang', $this->createUrl('AJAXRegrade'), array(
        'success' => "function(data, textStatus, XMLHttpRequest) { $('#submissionsgridview').yiiGridView.update('submissionsgridview');}"
    )); ?>
</div>
<?php echo CHtml::endForm();?>
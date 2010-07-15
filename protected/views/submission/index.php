<?php $this->setPageTitle(Yii::t('menu', "Jawaban"));?>
<?php $this->renderPartial('_menu');?>
<?php Yii::app()->clientScript->registerCoreScript("jquery.js"); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/scripts/jquery.timers.js"); ?>
<?php Yii::app()->clientScript->registerScript('timer-js', '
    $(document).everyTime(\'10s\',function(i) {
        $(\'#submissiongridview\').yiiGridView.update(\'submissiongridview\');
    });
');
?>
<?php Yii::app()->clientScript->registerCss('submission-css', '
     #filter {border:1px solid #ddd;width:100%;}
    .graded {color:#0000ff;font-weight:bold;}
    .pending {color:#00ff00;font-weight:bold;}
    .error {color:#ff0000;font-weight:bold;}
    .no-grade {color:#000000;font-weight:bold;}
');
?>
<div><?php echo Yii::t('contest', 'Jawaban yang sudah pernah kamu kumpul');?> </div>
<br/>
<?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $submissionDataProvider,
        'columns' => array(
            array(
                'name' => 'problem_id',
                'value' => 'CHtml::link($data->problem->title, Yii::app()->controller->createUrl(\'/problem/view\', array(\'id\' => $data->problem_id)))',
                'type' => 'raw'
            ),
            array(
                'name' => 'submitted_time',
                'value' => 'CDateHelper::timespanAbbr($data->submitted_time)',
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
                'template' => '{view}',
                'viewButtonUrl' => 'Yii::app()->controller->createUrl(\'view\', array(\'id\' => $data->id))',
                'viewButtonOptions' => array('target' => '_blank'),
            )
        ),
        'summaryText' => Yii::t('contest', 'Menampilkan {start}-{end} dari {count}.'),
        'emptyText' => Yii::t('contest', 'Belum ada jawaban yang sudah dikumpulkan'),
        'enablePagination' => true,
        'cssFile' => Yii::app()->request->baseUrl.'/css/yii/gridview/style.css',
        'id' => 'submissiongridview',
    ));
?>

<?php $this->setPageTitle($model->title);?>
<?php $this->renderPartial('_menu', array('model' => $model)); ?>
<?php Yii::app()->clientScript->registerCss('submission-css', '
     #filter {border:1px solid #ddd;width:100%;}
    .graded {color:#0000ff;font-weight:bold;}
    .pending {color:#00ff00;font-weight:bold;}
    .error {color:#ff0000;font-weight:bold;}
    .no-grade {color:#000000;font-weight:bold;}
');
?>
<div>
    <?php echo Yii::t('contest', 'Jawaban yang sudah kamu kumpulkan pada soal ini.');?>
    <?php echo CHtml::link(Yii::t('contest', 'Lihat jawaban kamu untuk semua soal'), $this->createUrl('/submission'));?>
</div>
<br/>
<?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $submissionDataProvider,
        'columns' => array(
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
                'viewButtonUrl' => 'Yii::app()->controller->createUrl(\'/submission/view\', array(\'id\' => $data->id))',
                'viewButtonOptions' => array('target' => '_blank')
            )
        ),
        'summaryText' => Yii::t('contest', 'Menampilkan {start}-{end} dari {count}.'),
        'emptyText' => Yii::t('contest', 'Belum ada jawaban yang sudah dikumpulkan'),
        'enablePagination' => true,
        'cssFile' => Yii::app()->request->baseUrl.'/css/yii/gridview/style.css',
    ));
?>

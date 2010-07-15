<?php Yii::app()->clientScript->registerCss('submission-css', '
    .graded {color:#0000ff;font-weight:bold;}
    .pending {color:#00ff00;font-weight:bold;}
    .error {color:#ff0000;font-weight:bold;}
');
?>
<div>
    Jawaban yang sudah dikumpulkan pada soal ini.
    <?php echo CHtml::link('Lihat jawaban untuk semua soal', $this->createUrl('supervisor/submission'));?>
</div>
<?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $submissionDataProvider,
        'columns' => array(
            array(
                'class' => 'CCheckBoxColumn'
            ),
            'id',
            array(
                'name' => 'submitted_time',
                'value' => 'CDateHelper::timespanAbbr($data->submitted_time)',
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
                'viewButtonUrl' => 'Yii::app()->controller->createUrl(\'supervisor/submission/view\', array(\'id\' => $data->id))',
                'viewButtonOptions' => array('target' => '_blank'),
                'buttons' => array(
                    'regrade' => array(
                        'label' => 'Regrade',
                        'imageUrl' => Yii::app()->request->baseUrl."/images/icons/repeat-16px.png",
                        'url' => 'Yii::app()->controller->createUrl(\'regrade\', array(\'id\' => \''.$model->id.'\',\'problemid\' => $data->primaryKey))',
                    )
                )
            )
        ),
        'summaryText' => 'Menampilkan {start}-{end} dari {count}.',
        'emptyText' => 'Belum ada jawaban yang sudah dikumpulkan',
        'enablePagination' => true,
        'cssFile' => Yii::app()->request->baseUrl.'/css/yii/gridview/style.css',
    ));
?>
<div>
    Jawaban yang sudah kamu kumpulkan pada soal ini.
    <?php echo CHtml::link('Lihat jawaban kamu untuk semua soal', $this->createUrl('contest/submission'));?>
</div>
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
                'value' => '$data->getGradeStatus()'
            ),
            array(
                'class' => 'CButtonColumn',
                'template' => '{view}',
                'viewButtonUrl' => 'Yii::app()->controller->createUrl(\'contest/submission/view\', array(\'id\' => $data->id))',
                'viewButtonOptions' => array('target' => '_blank')
            )
        ),
        'summaryText' => 'Menampilkan {start}-{end} dari {count}.',
        'emptyText' => 'Belum ada jawaban yang sudah dikumpulkan',
        'enablePagination' => true,
        'cssFile' => Yii::app()->request->baseUrl.'/css/yii/gridview/style.css',
    ));
?>
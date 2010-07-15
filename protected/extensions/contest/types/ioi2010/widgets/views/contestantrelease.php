<div>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $problemsDataProvider,
    'columns' => array(
        array(
            'name' => 'title',
            'header' => 'Title'
        ),
        array(
            'name' => 'amount',
            'header' => 'Amount Left'
        )
    ),
    'cssFile' => Yii::app()->request->baseUrl.'/css/yii/gridview/style.css',
    'id' => 'problemsgridview'
));
?>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $dataProvider,
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
                'value' => '$data->getGradeStatus()'
            ),
            array(
                'name' => 'verdict',
                'value' => '$data->verdict'
            ),
            array(
                'name' => 'score',
                'header' => 'Sample score'
            ),
            array(
                'name' => 'official_score',
                'header' => "Official score",
                'value' => '($data->getSubmitContent("fullfeedback") || !$data->contest->getConfig("secret")) ? "<strong style=\"color:#0505F5;\">" . $data->getGradeContent("official_result") . "</strong>" : "<i>Token unused</i>"',
                'type' => 'raw'
            ),
            array(
                'class' => 'CButtonColumn',
                'template' => '{release} {view}',
                'viewButtonUrl' => 'Yii::app()->controller->createUrl(\'contest/submission/view\', array(\'id\' => $data->id))',
                //'viewButtonOptions' => array('target' => '_blank'),
                //'updateButtonOptions' => array('onclick' => ($this->handler->getAvailableTokens() <= 0) ? "alert('Token tidak tersedia'); return false;" : "" , 'title' => 'Minta rilis'),
                //'updateButtonUrl' => 'Yii::app()->controller->createUrl("contest/menu" , array("index" => 0 , "submissionid" => $data->id))',
                'buttons' => array(
                    'release' => array(
                        'label' => 'Use Token',
                        'imageUrl' => Yii::app()->request->baseUrl . "/images/icons/file-white-16px.png",
                        'url' => 'Yii::app()->controller->createUrl("contest/menu" , array("index" => 0 , "submissionid" => $data->id))',
                        //'options' => array('onclick' => ($this->handler->getAvailableTokens() <= 0) ? "alert('Token tidak tersedia'); return false;" : "")
                    )
                )
            )
        ),
        'summaryText' => Yii::t('contest', 'Menampilkan {start}-{end} dari {count}.'),
        'emptyText' => Yii::t('contest', 'Belum ada jawaban yang sudah dikumpulkan'),
        'enablePagination' => true,
        'cssFile' => Yii::app()->request->baseUrl . '/css/yii/gridview/style.css',
    ));
    ?>
</div>
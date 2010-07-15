<?php $this->renderPartial('_breadcrumb' , array('chapter' => $model));?>
<?php
$this->widget('CTabView',
        array(
            'tabs' => array(
                'information' => array(
                    'title' => 'Informasi',
                    'view' => '_chapterinfo',
                    'data' => array('model' => $model)
                ),
                'subchapters' => array(
                    'title' => 'Subbab Lengkap',
                    'view' => '_chaptersubchapters',
                    'data' => array('model' => $model)
                ),
                'problems' => array(
                    'title' => 'Soal',
                    'view' => '_chapterproblems',
                    'data' => array('problems' => $problems, 'model' => $model)
                ),
                'participants' => array(
                    'title' => 'Peserta',
                    'view' => '_chapterparticipants',
                    'data' => array('participant' => $participantDP, 'model' => $model)
                ),
                'submissions' => array(
                    'title' => 'Jawaban',
                    'view' => '_chaptersubmissions',
                    'data' => array('dataProvider' => $dataProvider, 'model' => $model)
                ),
                'clarifications' => array(
                    'title' => 'Klarifikasi',
                    'view' => '_chapterclarifications',
                    'data' => array('dataProvider' => $clarificationDataProvider, 'model' => $model)
                )
            ),
            'viewData' => $viewData,
            'id' => 'problem-set-tab',
            'htmlOptions' => array('class' => 'tab'),
            'cssFile' => Yii::app()->request->baseUrl . "/css/arrastheme/tabs.css",
            'activeTab' => (!isset($currtab) ? 'information': $currtab),
        )
);
?>
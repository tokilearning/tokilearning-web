<?php $this->setPageTitle("Soal - ".$model->title);?>
<?php
if (!isset($activeTab) || $activeTab == null){
    $activeTab = 'problem';
}
$this->widget('CTabView',
        array(
            'tabs' => array(
                'problem' => array(
                    'title' => 'Soal',
                    'view' => '_problem',
                    'data' => array('model' => $model)
                ),
                'submit' => array(
                    'title' => 'Kumpul Jawaban',
                    'view' => '_submit',
                    'data' => array('model' => $model, 'submission' => $submission)
                ),
                'submission' => array(
                    'title' => 'Jawaban',
                    'view' => '_submissions',
                    'data' => array('submissionDataProvider' => $submissionDataProvider)
                )
            ),
            'id' => 'problem-tab',
            'htmlOptions' => array('class' => 'tab'),
            'cssFile' => Yii::app()->request->baseUrl . "/css/arrastheme/tabs.css",
            'activeTab' => $activeTab
       ));


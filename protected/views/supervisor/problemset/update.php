<?php $this->setPageTitle("Sunting Bundel Soal");?>
<?php $this->renderPartial('_menu'); ?>

<?php

$this->widget('CTabView',
        array(
            'tabs' => array(
                'information' => array(
                    'title' => 'Informasi',
                    'view' => '_updateinformation',
                    'data' => array('model' => $model)
                ),
                'subproblems' => array(
                    'title' => 'Sub Bundel Soal',
                    'view' => '_updatesubproblemsets',
                    'data' => array('subProblemSetDataProvider' => $subProblemSetDataProvider, 'model' => $model)
                ),
                'problems' => array(
                    'title' => 'Soal',
                    'view' => '_updateproblems',
                    'data' => array('problemsDataProvider' => $problemsDataProvider, 'model' => $model)
                )
            ),
            'viewData' => $viewData,
            'id' => 'problem-set-tab',
            'htmlOptions' => array('class' => 'tab'),
            'cssFile' => Yii::app()->request->baseUrl . "/css/arrastheme/tabs.css"
        )
);
?>
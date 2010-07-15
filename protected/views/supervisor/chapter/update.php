<?php $this->renderPartial('_menu');?>
<?php
$this->widget('CTabView',
        array(
            'tabs' => array(
                'information' => array(
                    'title' => 'Informasi',
                    'view' => '_updateinfo',
                    'data' => array('model' => $model)
                ),
                'subbab' => array(
                    'title' => 'Subbab',
                    'view' => '_updatesubchapter',
                    'data' => array('model' => $model , 'subchapters' => $subchapters)
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
            'cssFile' => Yii::app()->request->baseUrl . "/css/arrastheme/tabs.css",
            'activeTab' => (!isset($currtab) ? 'information': $currtab),
        )
);
?>
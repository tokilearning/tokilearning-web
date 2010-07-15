<?php
$this->widget('CTabView',
        array(
            'tabs' => array(
                'display' => array(
                    'title' => 'Tampilan',
                    'view' => 'ext.evaluator.types.batchioi.widgets.views.problemupdate.description',
                    'data' => array(
                        'problem' => $problem,
                        'description' => $this->renderDescription(),
                    )
                ),
                'configuration' => array(
                    'title' => 'Konfigurasi Evaluator',
                    'view' => 'ext.evaluator.types.batchioi.widgets.views.problemupdate.configuration',
                    'data' => array(
                        'problem' => $problem,
                    )
                ),
//                'manual' => array(
//                    'title' => 'Konfigurasi Manual',
//                    'view' => 'ext.evaluator.types.simplebatch.widgets.views.problemupdate.manual',
//                    'data' => array(
//                        'problem' => $problem,
//                    )
//                ),
                'files' => array(
                    'title' => 'Berkas',
                    'view' => 'ext.evaluator.types.batchioi.widgets.views.problemupdate.files',
                    'data' => array(
                        'problem' => $problem,
                    )
                ),
            ),
            'id' => 'problem-update-tab',
            'htmlOptions' => array('class' => 'tab'),
            'cssFile' => Yii::app()->request->baseUrl . "/css/arrastheme/tabs.css",
            'activeTab' => (isset($action) ? $action : 'display'),
        )
);
?>
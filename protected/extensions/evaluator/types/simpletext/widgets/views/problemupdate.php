<?php
$this->widget('CTabView',
        array(
            'tabs' => array(
                'problem' => array(
                    'title' => 'Soal',
                    'view' => 'ext.evaluator.types.simpletext.widgets.views.problemupdate.problems',
                    'data' => array(
                        'problem' => $problem,
                        'assets' => $assets,
                    )
                ),
                'files' => array(
                    'title' => 'Berkas',
                    'view' => 'ext.evaluator.types.simpletext.widgets.views.problemupdate.files',
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
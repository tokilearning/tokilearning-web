<?php
$this->widget('CTabView',
        array(
            'tabs' => array(
                'display' => array(
                    'title' => 'Soal',
                    'view' => 'ext.evaluator.types.reactive1.widgets.views.problemview.description',
                    'data' => array(
                        'problem' => $problem,
                        'description' => $this->renderDescription(),
                    )
                ),
                'submit' => array(
                    'title' => 'Kumpul Jawaban',
                    'view' => 'ext.evaluator.types.reactive1.widgets.views.problemview.submit',
                    'data' => array(
                        'problem' => $problem,
                        'submission' => $submission,
                        'submitLocked' => $this->submitLocked,
                        'submitLockedText' => $this->submitLockedText,
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

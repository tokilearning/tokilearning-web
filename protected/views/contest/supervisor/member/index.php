<?php $this->setPageTitle("Anggota");?>
<?php

$this->widget('CTabView',
        array(
            'tabs' => array(
                'contestants' => array('title' => 'Kontestan', 'view' => '_contestants', 'data' => array('contestantsDataProvider' => $contestantsDataProvider)),
                'supervisors' => array('title' => 'Supervisor', 'view' => '_supervisors', 'data' => array('supervisorsDataProvider' => $supervisorsDataProvider)),
            ),
            'viewData' => $viewData,
            'id' => 'profile-tab',
            'htmlOptions' => array('class' => 'tab'),
            'cssFile' => Yii::app()->request->baseUrl . "/css/arrastheme/tabs.css"
        )
);
?>
<?php $this->setPageTitle("Profil - ".$user->full_name);?>
<?php

$tabs = array(
    'profile' => array('title' => 'Profil', 'view' => '_profile', 'data' => array('user' => $user)),
    'statistics' => array('title' => 'Statistik', 'view' => '_statistics'),
);
$this->widget('CTabView',
        array(
            'tabs' => $tabs,
            'viewData' => $viewData,
            'id' => 'profile-tab',
            'htmlOptions' => array('class' => 'tab'),
            'cssFile' => Yii::app()->request->baseUrl."/css/arrastheme/tabs.css"
        )
);
?>
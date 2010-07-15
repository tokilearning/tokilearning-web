<?php $this->setPageTitle("Sunting Soal");?>
<?php $this->renderPartial('_menu');?>

<?php
if (!isset($activeTab) || $activeTab == null){
    $activeTab = 'information';
}
$this->widget('CTabView',
        array(
            'tabs' => array(
                'information' => array(
                    'title' => 'Informasi',
                    'view' => 'evaluator/_information',
                    'data' => array(
                        'model' => $model
                    )
                ),
                'display' => array(
                    'title' => 'Tampilan',
                    'view' => 'evaluator/_display',
                    'data' => array(
                        'model' => $model
                    )
                ),
                'evaluator' => array(
                    'title' => 'Evaluator',
                    'view' => 'evaluator/_evaluator',
                    'data' => array(
                        'model' => $model,
                        'evalActiveTab' => $evalActiveTab
                    )
                ),
                
            ),
            'id' => 'problem-update-tab',
            'htmlOptions' => array('class' => 'tab'),
            'cssFile' => Yii::app()->request->baseUrl . "/css/arrastheme/tabs.css",
            'activeTab' => $activeTab
        )
);
?>
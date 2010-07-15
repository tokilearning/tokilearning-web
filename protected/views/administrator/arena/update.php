<?php $this->setPageTitle("Update Arena " . $model->name);?>
<?php $this->renderPartial('_menu');?>

<?php
$this->widget('CTabView',
        array(
            'tabs' => array(
                'information' => array(
                    'title' => 'Informasi Umum',
                    'view' => '_info',
                    'data' => array('model' => $model)
                ),
                'members' => array(
                    'title' => 'Anggota',
                    'view' => '_members',
                    'data' => array('model' => $model , 'dataProvider' => $memberDataProvider)
                ),
                'problems' => array(
                    'title' => 'Soal',
                    'view' => '_problems',
                    'data' => array('dataProvider' => $problemsDataProvider, 'model' => $model)
                )
            ),
            'id' => 'arena-tab',
            'htmlOptions' => array('class' => 'tab'),
            'cssFile' => Yii::app()->request->baseUrl . "/css/arrastheme/tabs.css",
            'activeTab' => (!isset($currtab) ? 'information': $currtab),
        )
);
?>
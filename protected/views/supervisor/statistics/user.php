<?php $this->setPageTitle("Statistik"); ?>
<?php $this->renderPartial('_menu'); ?>

<div>Perbaruan Terakhir <?php echo CDateHelper::timespanAbbr($last_update); ?></div>

<?php
$userDataProvider = new CArrayDataProvider($users, array(
            'id' => 'id',
            'sort' => array(
                'attributes' => array(
                    'id', 'full_name', 'p_solved', 's_count'
                )
            ),
            'pagination' => array(
                'pageSize' => 30
            )
        ));

$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $userDataProvider,
    'columns' => array(
        array(
            'name' => 'id',
            'header' => 'ID',
        ),
        array(
            'name' => 'full_name',
            'header' => 'Nama',
            'value' => 'CHtml::link($data[\'full_name\'], Yii::app()->controller->createUrl(\'/profile/view\', array(\'id\' =>$data[\'id\'] )))',
            'type' => 'raw'
        ),
        array(
            'name' => 'p_solved',
            'header' => 'Prob. Solved'
        ),
        array(
            'name' => 's_count',
            'header' => 'S. Count'
        ),
        array(
            'name' => 's_accepted',
            'header' => 'S Accpt'
        ),
        array(
            'name' => 's_not_accepted',
            'header' => 'S. NAccpt'
        ),
        array(
            'name' => 's_lang_cpp',
            'header' => 'Lang C++'
        ),
        array(
            'name' => 's_lang_c',
            'header' => 'Lang C'
        ), array(
            'name' => 's_lang_pas',
            'header' => 'Lang pas'
        )
    ),
    'summaryText' => 'Menampilkan {start}-{end} dari {count}.',
    'enablePagination' => true,
    'cssFile' => Yii::app()->request->baseUrl . '/css/yii/gridview/style.css',
));
?>

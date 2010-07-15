<?php $this->setPageTitle("Daftar Soal"); ?>
<?php $this->renderPartial('_menu'); ?>

<?php Yii::app()->clientScript->registerScript('filter-js', '
    $(\'#filter\').change(function(){
        $(\'#problemgridview\').yiiGridView.update(\'problemgridview\', {
            url:\'?filter=\'+$(this).val()
        });
    });
    $(\'#searchbutton\').click(function(){
        searchkey = $(\'#search\').val();
        $(\'#problemgridview\').yiiGridView.update(\'problemgridview\', {
            url:\'?search=\'+searchkey
        });
    });
'); ?>

<div class="dtable">
    <div class="drow">
        <span class="shead">
            <strong>Saring</strong>
        </span><span>
            <?php
            echo CHtml::dropDownList('filter', 'all', array(
                'all' => 'Seluruh Soal',
                'mine' => 'Soal Saya',
                'privileged' => 'Diberikan hak'
            )); ?>
        </span>
    </div>
    <div class="drow">
        <span class="shead">
            <strong>Cari</strong>
        </span>
        <span>
            <?php echo CHtml::textField('search', '', array('id' => 'search')); ?>
            <?php echo CHtml::button('Cari', array('id' => 'searchbutton')); ?>
        </span>
    </div>
</div>
<br/>
<em>Hover pada judul soal untuk melihat deskripsi singkat soal</em>
<?php
            $this->widget('zii.widgets.grid.CGridView', array(
                'dataProvider' => $dataProvider,
                'columns' => array(
                    array(
                        'name' => 'id',
                        'value' => '$data->primaryKey',
                        'header' => 'ID',
                        'sortable' => false
                    ),
                    array(
                        'name' => 'title',
                        'value' => 'CHtml::link($data->title, Yii::app()->controller->createUrl(\'view\',  array(\'id\' => $data->primaryKey)) , array("title" => $data->description))',
                        'type' => 'raw'
                    ),
                    array(
                        'name' => 'author_id',
                        'value' => '$data->author->getFullnameLink()',
                        'type' => 'raw'
                    ),
                    array(
                        'name' => 'visibility',
                        'value' => '$data->getVisibility()'
                    ),
                    array(
                        'name' => 'created_date',
                        'value' => 'CDateHelper::timespanAbbr($data->created_date)',
                        'type' => 'raw'
                    ),
                    array(
                        'name' => 'modified_date',
                        'value' => 'CDateHelper::timespanAbbr($data->modified_date)',
                        'type' => 'raw'
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{view}{update}{delete} {download} {publish}{unpublish}',
                        'htmlOptions' => array('style' => 'width:100px;'),
                        //'viewButtonUrl' => 'Yii::app()->controller->createUrl(\'display\', array(\'id\' => $data->primaryKey))',
                        'viewButtonOptions' => array('target' => '_blank'),
                        'updateButtonOptions' => array('target' => '_blank'),
                        'buttons' => array(
                            'view' => array(
                                'visible' => '$data->isPrivileged(Yii::app()->user)'
                            ),
                            'update' => array(
                                'visible' => '$data->isPrivileged(Yii::app()->user)'
                            ),
                            'delete' => array(
                                'visible' => '$data->isPrivileged(Yii::app()->user)'
                            ),
                            'publish' => array(
                                'label' => 'Publish',
                                'imageUrl' => Yii::app()->request->baseUrl . "/images/icons/sound-icon-16px.png",
                                'url' => 'Yii::app()->controller->createUrl(\'publish\', array(\'id\' => $data->primaryKey))',
                                'visible' => '$data->visibility != Problem::VISIBILITY_PUBLIC && $data->isPrivileged(Yii::app()->user)'
                            ),
                            'unpublish' => array(
                                'label' => 'Unpublish',
                                'imageUrl' => Yii::app()->request->baseUrl . "/images/icons/sound-off-icon-16px.png",
                                'url' => 'Yii::app()->controller->createUrl(\'unpublish\', array(\'id\' => $data->primaryKey))',
                                'visible' => '$data->visibility != Problem::VISIBILITY_DRAFT && $data->isPrivileged(Yii::app()->user)'
                            ),
                            'download' => array(
                                'label' => 'Download',
                                'imageUrl' => Yii::app()->request->baseUrl . "/images/icons/save-16px.png",
                                'url' => 'Yii::app()->controller->createUrl(\'download\', array(\'id\' => $data->primaryKey))',
                                'options' => array('target' => '_blank'),
                                'visible' => '$data->isPrivileged(Yii::app()->user)'
                            )
                        )
                    ),
                ),
                'summaryText' => 'Menampilkan {start}-{end} dari {count}.',
                'template' => '{summary} {pager} <br/> {items} {pager}',
                'enablePagination' => true,
                'id' => 'problemgridview',
                'cssFile' => Yii::app()->request->baseUrl . '/css/yii/gridview/style.css',
            ));
?>

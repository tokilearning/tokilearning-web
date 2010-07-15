<?php $this->setPageTitle("File Manager"); ?>
<?php
Yii::app()->clientScript->registerCss('file_css', '
    #folder-path {margin: 10px 0px 4px 0px;border:1px solid #d0d0d0;padding:5px;}
    #folder-path a {text-decoration:none;}
    #folder-path a:hover {text-decoration:underline;}
    #folder-path a#current {text-decoration:underline;}
');
?>
<div id="folder-path"><b>Lokasi : </b>
    <?php foreach ($pathlist as $path) : ?>
    <?php if ($path['fullpath'] != '.') : ?>
    <?php echo CHtml::link($path['display'], $this->createUrl('index') . "?path=" . $path['fullpath'], array('style' => 'text-decoration:underline;')); ?>
    <?php else : ?>
    <?php echo CHtml::link($path['display'], $this->createUrl('index'), array('style' => 'text-decoration:underline;')); ?>
    <?php endif;?>
    <?php echo DIRECTORY_SEPARATOR; ?>
    <?php endforeach; ?>
    </div>
<?php
        $this->widget('zii.widgets.grid.CGridView',
                array(
                    'dataProvider' => $dataProvider,
                    'columns' => array(
                        array(
                            'name' => 'name',
                            'header' => 'Nama',
                            'value' => '\'<img src="\'.Yii::app()->request->baseUrl.\'/images/icons/\'.(($data[\'type\'] == \'dir\') ? \'folder-white-16px.png\':\'file-white-16px.png\').\'"/>  \'.' .
                            '(($data[\'type\'] == \'file\') ? $data[\'name\'] : \'<a href = "\'.Yii::app()->controller->createUrl(\'index\').\'?path=\'.$data[\'path\'].\'">\'.$data[\'name\']).\'</a>\'',
                            'type' => 'raw',
                        ),
                        array(
                            'name' => 'size',
                            'header' => 'Ukuran',
                            'value' => '$data[\'size\'].\'kb\'',
                        ),
                        array(
                            'name' => 'modified',
                            'header' => 'Modifikasi Terakhir',
                            'value' => 'CDateHelper::timespanAbbr($data[\'modified\'])',
                            'type' => 'raw',
                        ),
                        array(
                            'class' => 'CButtonColumn',
                            'template' => '{browse}{link}{download}',
                            'buttons' => array(
                                'browse' => array(
                                    'label' => 'Browse',
                                    'imageUrl' => Yii::app()->request->baseUrl . "/images/icons/folder-yellow-open-16px.png",
                                    'url' => 'Yii::app()->controller->createUrl(\'index\').\'?path=\'.$data[\'path\']',
                                    'visible' => '$data[\'type\'] == \'dir\'',
                                ),
                                'link' => array(
                                    'label' => 'Link',
                                    'imageUrl' => Yii::app()->request->baseUrl . "/images/icons/anchor-16px.png",
                                    'url' => 'Yii::app()->request->baseUrl.\'/public/\'.$data[\'path\']',
                                    'visible' => '$data[\'type\'] == \'file\'',
                                ),
                                'download' => array(
                                    'label' => 'Download',
                                    'imageUrl' => Yii::app()->request->baseUrl . "/images/icons/save-16px.png",
                                    'url' => 'Yii::app()->controller->createUrl(\'download\').\'?path=\'.$data[\'path\']',
                                    'visible' => '$data[\'type\'] == \'file\'',
                                )
                            )
                        ),
                    ),
                    'summaryText' => 'Menampilkan {start}-{end} dari {count}.',
                    'template' => '{summary} {pager} <br/> {items} {pager}',
                    'enablePagination' => true,
                    'id' => 'gridview',
                    'cssFile' => Yii::app()->request->baseUrl . '/css/yii/gridview/style.css',
                )
        );
?>
        <div class="dtable">
            <div class="drow">
                <span class="shead">Unggah Berkas</span>
                <span>
            <?php echo CHtml::beginForm($this->createUrl('upload') . "?path=" . $currentpath, 'post', array('enctype' => 'multipart/form-data')); ?>
            <?php echo CHtml::fileField('file'); ?>
            <?php echo CHtml::submitButton('Unggah'); ?>
            <?php echo CHtml::endForm(); ?>
        </span>
    </div>
    <!-- -->
    <div class="drow">
        <span class="shead">Buat direktori</span>
        <span>
            <?php echo CHtml::beginForm($this->createUrl('makedir') . "?path=" . $currentpath, 'post', array('enctype' => 'multipart/form-data')); ?>
            <?php echo CHtml::textField('foldername'); ?>
            <?php echo CHtml::submitButton('Buat'); ?>
            <?php echo CHtml::endForm(); ?>
        </span>
    </div>
</div>
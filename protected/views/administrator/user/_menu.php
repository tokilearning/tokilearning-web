<div id="content-nav-wrapper">
<?php
$this->widget('zii.widgets.CMenu', array(
    'items' => array(
            array('label' => 'Daftar', 'url' => array('index')),
            array('label' => 'Baru', 'url' => array('create')),
            array('label' => 'Cari', 'url' => array('search')),
            array('label' => 'Buat Massal', 'url' => array('batchcreate')),
            array('label' => 'Unggah Massal', 'url' => array('batchupload')),
        ),
    'htmlOptions' => array('class'=>'content-nav')
));
?>
     <div class="spacer"></div>
</div>
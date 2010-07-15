<div id="content-nav-wrapper">
<?php
$this->widget('zii.widgets.CMenu', array(
    'items' => array(
        array('label' => 'Daftar', 'url' => array('supervisor/contest/index')),
        array('label' => 'Baru', 'url' => array('supervisor/contest/create'))),
    'htmlOptions' => array('class'=>'content-nav')
));
?>
     <div class="spacer"></div>
</div>
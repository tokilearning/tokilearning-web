<div id="content-nav-wrapper">
<?php
$this->widget('zii.widgets.CMenu', array(
    'items' => array(
        array('label' => 'Daftar', 'url' => array('supervisor/problem/index')),
        array('label' => 'Baru', 'url' => array('supervisor/problem/create'))),
    'htmlOptions' => array('class'=>'content-nav')
));
?>
     <div class="spacer"></div>
</div>
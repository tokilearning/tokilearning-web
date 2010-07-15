<div id="content-nav-wrapper">
<?php
$this->widget('zii.widgets.CMenu', array(
    'items' => array(
        array('label' => 'Baru', 'url' => array('create')),
        //array('label' => 'Arsip', 'url' => array('archives')),
    ),
    'htmlOptions' => array('class'=>'content-nav')
));
?>
     <div class="spacer"></div>
</div>
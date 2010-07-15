<div id="content-nav-wrapper">
    <?php
    $this->widget('zii.widgets.CMenu', array(
        'items' => array(
            array('label' => 'Latihan', 'url' => array('supervisor/training/index')),
            array('label' => 'Bab Latihan', 'url' => array('supervisor/chapter/index'))
            ),
        'htmlOptions' => array('class' => 'content-nav')
    ));
    ?>
    <div class="spacer"></div>
</div>

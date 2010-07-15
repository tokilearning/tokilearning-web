<div id="content-nav-wrapper">
    <?php
    $this->widget('zii.widgets.CMenu', array(
        'items' => array(
                array('label' => 'Aktivitas', 'url' => array('activity')),
                array('label' => 'Peringkat', 'url' => array('rank')),
            ),
        'htmlOptions' => array('class' => 'content-nav')
    ));
    ?>
    <div class="spacer"></div>
</div>

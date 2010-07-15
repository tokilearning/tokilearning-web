<div id="content-nav-wrapper">
    <?php
    $cid = $this->action->id;
    $this->widget('zii.widgets.CMenu', array(
        'items' => array(
            array('label' => 'Umum', 'url' => array('contest/supervisor/configuration') , 'itemOptions' => array('class' => ($cid == 'contest') ? 'selected' : '')),
            array('label' => 'Spesifik', 'url' => array('contest/supervisor/configuration/specific') , 'itemOptions' => array('class' => ($cid == 'specific') ? 'selected' : '')),
            ),
        'htmlOptions' => array('class' => 'content-nav')
    ));
    ?>
    <div class="spacer"></div>
</div>

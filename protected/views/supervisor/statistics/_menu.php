<div id="content-nav-wrapper">
    <?php
    $this->widget('zii.widgets.CMenu', array(
        'items' => array(
            array('label' => 'Pengguna', 'url' => array('user')),
        ),
        'htmlOptions' => array('class' => 'content-nav')
    ));
    ?>
    <div class="spacer"></div>
</div>

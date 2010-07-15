<div id="content-nav-wrapper">
    <?php
    $this->widget('zii.widgets.CMenu', array(
        'items' => array(
            //array('label' => 'Daftar', 'url' => array('index')),
            array('label' => 'Baru', 'url' => array('contest/supervisor/news/create'))),
        'htmlOptions' => array('class' => 'content-nav')
    ));
    ?>
    <div class="spacer"></div>
</div>

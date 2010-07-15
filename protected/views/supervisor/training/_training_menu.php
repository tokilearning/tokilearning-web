<div id="content-nav-wrapper">
    <?php
    $this->widget('zii.widgets.CMenu', array(
        'items' => array(
            array('label' => 'Bab', 'url' => array('/supervisor/training/view/id/' . $_GET['id'] . '/section/index')),
            array('label' => 'Peserta', 'url' => array('/supervisor/training/view/id/' . $_GET['id'] . '/section/participants')),
            array('label' => 'Jawaban', 'url' => array('/supervisor/training/submission/id/' . $_GET['id'])),
            ),
        'htmlOptions' => array('class' => 'content-nav')
    ));
    ?>
    <div class="spacer"></div>
</div>

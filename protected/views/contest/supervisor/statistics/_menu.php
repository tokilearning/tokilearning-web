<div id="content-nav-wrapper">
    <?php
    $cid = Yii::app()->controller->action->id;
    $this->widget('zii.widgets.CMenu', array(
        'items' => array(
                array('label' => 'Aktivitas', 'url' => array('activity' , 'contestid' => $this->contest->id) , 'itemOptions' => array('class' => ($cid == 'activity') ? 'selected' : '')),
                array('label' => 'Peringkat', 'url' => array('rank' , 'contestid' => $this->contest->id) , 'itemOptions' => array('class' => ($cid == 'rank') ? 'selected' : '')),
				array('label' => 'Log', 'url' => array('log' , 'contestid' => $this->contest->id) , 'itemOptions' => array('class' => ($cid == 'log') ? 'selected' : '')),
            ),
        'htmlOptions' => array('class' => 'content-nav')
    ));
    ?>
    <div class="spacer"></div>
</div>

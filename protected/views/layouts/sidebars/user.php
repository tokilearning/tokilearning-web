<div id="user-widget">
    <div id="name"><?php echo Yii::app()->user->getRecord()->getFullnameLink(); ?></div>
    <div id="avatar">
        <img src="<?php echo Yii::app()->request->baseUrl?>/images/noprofile60.jpg" alt="<?php Yii::app()->user->getRecord()->full_name;?>"/>
    </div>
    <div id="menu">
        <?php
        $this->widget('zii.widgets.CMenu', array(
            'items' => array(
                array('label' => 'Sunting Profil', 'url' => array('/account/setting')),
                array('label' => 'Keluar', 'url' => array('/account/signout')),
            ),
            'htmlOptions' => array('class' => 'menu')
        ));
        ?>
    </div>
    <div style="clear:both;"></div>
</div>

<div class="widget">
    <?php if (Yii::app()->user->checkAccess('administrator')):?>
    <h4>Menu Administrator</h4>
    <div>
        <?php
        $this->widget('zii.widgets.CMenu', array(
            'items' => array(
                array('label' => 'Pengguna', 'url' => array('/administrator/user')),
                array('label' => 'Grup', 'url' => array('/administrator/groups')),
                array('label' => 'Pengumuman', 'url' => array('/administrator/announcement')),
                array('label' => 'Log Sistem', 'url' => array('/administrator/log')),
                //array('label' => 'Email', 'url' => array('/administrator/mailer')),
                //array('label' => 'Authentikasi', 'url' => array('/administrator/auth')),
            ),
            'htmlOptions' => array('class' => 'menu')
        ));
        ?>
    </div>
    <?php endif;?>
</div>
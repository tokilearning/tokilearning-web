<div class="widget" style="margin-bottom:0px;">
    <?php if (Yii::app()->user->checkAccess('learner')):?>
    <h4><?php echo Yii::t('menu', 'Menu Utama'); ?></h4>
    <div>
        <?php
        $this->widget('zii.widgets.CMenu', array(
            'items' => array(
                array('label' => Yii::t('menu', 'Bundel Soal'), 'url' => array('/problemset')),
                array('label' => Yii::t('menu', 'Jawaban'), 'url' => array('/submission')),
                array('label' => Yii::t('menu', 'Latihan'), 'url' => array('/training/2')),
                array('label' => Yii::t('menu', 'Kontes'), 'url' => array('/contest'))),
            'htmlOptions' => array('class' => 'menu')
        ));
        ?>
    </div>
    <?php endif;?>
</div>

<div style="text-align: right;margin:4px 0px 5px 0px;padding:2px;border-top: 1px solid #ccc;border-bottom: 1px solid #ccc;">
    <?php echo Yii::t('menu', 'n<=1#{n} pengguna online|n>1#{n} pengguna online', array(User::getOnlineUserCount(), '{n}' => User::getOnlineUserCount())); ?>
</div>

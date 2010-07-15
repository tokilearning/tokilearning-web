<div id="footer" class="clearfix">
    <div id="footer-left">
        Copyright &copy; <a href="#">TOKI Biro ITB</a>, design by <a href="http://www.arrastheme.com">Arras Theme</a>, and powered by <a href="http://www.yiiframework.com/">Yii Framework</a>.
    </div>
    <div id="footer-right">
        <?php
        $this->widget('zii.widgets.CMenu', array(
            'items' => array(
                array('label' => Yii::t('menu', 'Perihal'), 'url' => array('/about')),
                array('label' => Yii::t('menu', 'Kontak'), 'url' => array('/contact')),
                //array('label' => 'Bantuan', 'url' => array('/help')),
            ),
        ));
        ?>
    </div>
    <div style="clear:both;"></div>
</div>

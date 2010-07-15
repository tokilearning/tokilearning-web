<div class="widget">
    <?php if (Yii::app()->user->checkAccess('learner')):?>
    <h4>Menu Utama</h4>
    <div>
        <?php
        $this->widget('zii.widgets.CMenu', array(
            'items' => array(
                array('label' => 'Bundel Soal', 'url' => array('/problemset')),
                array('label' => 'Jawaban', 'url' => array('/submission')),
                array('label' => 'Kontes', 'url' => array('/contest'))),
            'htmlOptions' => array('class' => 'menu')
        ));
        ?>
    </div>
    <?php endif;?>
</div>
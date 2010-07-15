<div class="widget">
    <?php if (Yii::app()->user->checkAccess('supervisor')):?>
    <h4>Menu Supervisor</h4>
    <div>
        <?php
        $this->widget('zii.widgets.CMenu', array(
            'items' => array(
                array('label' => 'Bundel Soal', 'url' => array('/supervisor/problemset')),
                array('label' => 'Soal', 'url' => array('/supervisor/problem')),
                array('label' => 'Tipe Soal', 'url' => array('/supervisor/problemtypes')),
                array('label' => 'Jawaban', 'url' => array('/supervisor/submission')),
                array('label' => 'Kontes', 'url' => array('/supervisor/contest')),
                array('label' => 'PasteBin', 'url' => array('/supervisor/pastebin'))),
            'htmlOptions' => array('class' => 'menu')
        ));
        ?>
    </div>
    <?php endif;?>
</div>
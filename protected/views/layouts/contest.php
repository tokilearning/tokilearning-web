<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . "/css/arrastheme/layouts/2column.css"); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . "/css/arrastheme/layouts/contest.css"); ?>
<?php Yii::app()->clientScript->registerCoreScript("jquery.js"); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/scripts/jquery.timers.js"); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/scripts/dateformat.js"); ?>
<?php Yii::app()->clientScript->registerScript('timer-js', '
    $(\'#clock-wrapper\').html(dateFormat());
    $(document).everyTime(\'1s\',function(i) {
        $(\'#clock-wrapper\').html(dateFormat());
    });
');?>


<?php $this->beginContent('application.views.layouts.main'); ?>
<div id="main-left">
    <?php echo $this->renderPartial('application.views.layouts.sidebars.user'); ?>
    <?php echo $this->renderPartial('application.views.layouts.sidebars.main'); ?>
    <?php echo $this->renderPartial('application.views.layouts.sidebars.supervisor'); ?>
    <?php echo $this->renderPartial('application.views.layouts.sidebars.administrator'); ?>
</div><!-- end div#left -->

<div id="main-right">
    <div class="section" id="contest-wrapper">
        <h2 class="title"><?php echo $this->getContest()->name; ?></h2>
        <div id="contest-nav-wrapper">
            <?php
            $contestid = $this->getContest()->id;
            $contestlinkitems = array(
                array('label' => 'Pengumuman', 'url' => array('contest/news')),
                array('label' => 'Soal', 'url' => array('contest/problem')),
                array('label' => 'Jawaban', 'url' => array('contest/submission')),
                array('label' => 'Klarifikasi', 'url' => array('contest/clarification')),
                array('label' => 'Peringkat', 'url' => array('contest/rank')),
                array('label' => 'Keluar', 'url' => array('contest/contest/signout'), 'itemOptions' => array('id' => 'signout', 'class' => 'right')),
                array('label' => 'Petunjuk', 'url' => array('contest/help'), 'itemOptions' => array('id' => 'help', 'class' => 'right')),
            );
            
            $this->widget('zii.widgets.CMenu', array(
                'items' => $contestlinkitems,
                'htmlOptions' => array('class' => 'content-nav')
            ));
            ?>
            <div class="spacer"></div>
        </div>
        <?php if (!$this->getContest()->hasStarted()):?>
        <div id="contest-expired" class="error">
            Kontes ini belum dimulai
        </div>
        <?php elseif ($this->getContest()->hasEnded()):?>
        <div id="contest-expired" class="error">
            Kontes ini telah berakhir
        </div>
        <?php endif;?>
        <div id="contestbar-wrapper">
            <div id="clock-wrapper"></div>
            <?php if ($this->isSupervisor()):?>
            | <?php echo CHtml::link('Pindah ke Mode Manajer', $this->createUrl('contest/supervisor'), array('id' => 'changemode'));?>
            <?php endif;?>
        </div>
        <?php echo $content; ?>
        </div>
    </div><!-- end div#center -->
<?php $this->endContent(); ?>
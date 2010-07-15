<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . "/css/arrastheme/layouts/2column.css"); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . "/css/jquery.tooltip/jquery.tooltip.css"); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . "/css/arrastheme/layouts/contest.css"); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/scripts/jquery.timers.js"); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/scripts/jquery.tooltip.pack.js"); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/scripts/dateformat.js"); ?>
<?php Yii::app()->clientScript->registerScript('timer-js', '
	var secondsLeft = '.$this->getContest()->getSecondsLeft().';
	$("#time-left").text(Math.floor(secondsLeft / 3600) + ":" + Math.floor(secondsLeft % 3600 / 60) + ":" + secondsLeft % 60);
    //$(\'#clock-wrapper\').html(dateFormat());
    $(document).everyTime(\'1s\',function(i) {
		if (secondsLeft > 0)
			secondsLeft--;
		else
			secondsLeft = 0;
        $("#time-left").text(Math.floor(secondsLeft / 3600) + ":" + Math.floor(secondsLeft % 3600 / 60) + ":" + secondsLeft % 60);
    });
');?>
<?php Yii::app()->clientScript->registerScript('clarification-update-js','
    $(document).everyTime(\'10s\',function(i) {
        //alert($("#contest-nav-wrapper #clarification-link > a").text());
        $.ajax({
            type: "GET",
            url: "'.Yii::app()->controller->createUrl("contest/supervisor/clarification/getunreadclar" , array('contestid' => $this->getContest()->id)).'",
            success: function(data,status) {
                if (data != 0)
                    $("#contest-nav-wrapper #clarification-link > a").html("Klarifikasi <span style=\"color: #F50505;\"><strong>(" + data + ")</strong></span>");
            }
        });
    });
    $.ajax({
        type: "GET",
        url: "'.Yii::app()->controller->createUrl("contest/supervisor/clarification/getunreadclar").'",
        success: function(data,status) {
            if (data != 0)
                $("#contest-nav-wrapper #clarification-link > a").html("Klarifikasi <span style=\"color: #F50505;\"><strong>(" + data + ")</strong></span>");
        }
    });
');?>

<?php $this->beginContent('application.views.layouts.main'); ?>
<div id="main-left">
    <?php echo $this->renderPartial('application.views.layouts.sidebars.user'); ?>
    <?php echo $this->renderPartial('application.views.layouts.sidebars.main'); ?>
    <?php echo $this->renderPartial('application.views.layouts.sidebars.supervisor'); ?>
    <?php echo $this->renderPartial('application.views.layouts.sidebars.administrator'); ?>
    <?php echo $this->renderPartial('application.views.layouts.sidebars.facebook'); ?>
</div><!-- end div#left -->

<div id="main-right">
    <div class="section" id="contest-wrapper">
        <h2 class="title"><?php echo $this->getContest()->name;?></h2>
        <div id="contest-nav-wrapper">
        <?php
        $cid = Yii::app()->controller->id;
        $contestid = $this->getContest()->id;

		$contestTypeHandler = $this->getContest()->getContestTypeHandler();

		$additionalMenus = array();
		foreach ($contestTypeHandler->getSupervisorMenu() as $key => $menuName) {
			$additionalMenus[] = array('label' => $menuName, 'url' => array('contest/supervisor/menu' , 'index' => $key));
		}

                $contestlinkitems = array(
                    array('label' => 'Pengumuman', 'url' => array('contest/supervisor/news/index')),
                    array('label' => 'Anggota', 'url' => array('contest/supervisor/member/index')),
                    array('label' => 'Konfigurasi', 'url' => array('contest/supervisor/configuration/contest')),
                    array('label' => 'Soal', 'url' => array('contest/supervisor/problem/index')),
                    array('label' => 'Jawaban', 'url' => array('contest/supervisor/submission/index')),
                    array('label' => 'Klarifikasi', 'url' => array('contest/supervisor/clarification/index'), 'itemOptions' => array('id' => 'clarification-link')),
                    array('label' => 'Statistik', 'url' => array('contest/supervisor/statistics/activity')),
                );
                $contestlinkitems[] = array('label' => 'Keluar', 'url' => array('contest/contest/signout'), 'itemOptions' => array('id' => 'signout','class' => 'right'));

		$contestlinkitems = array_merge($contestlinkitems , $additionalMenus);
                $this->widget('zii.widgets.CMenu', array(
                    'items' => $contestlinkitems,
                    'htmlOptions' => array('class'=>'content-nav')
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
            <div id="clock-wrapper">
				<span id="time-left">
					<?php echo round($this->getContest()->getSecondsLeft() / 60) . ':' .  $this->getContest()->getSecondsLeft() % 60;?>
				</span> menit tersisa
			</div>
            <div style="float: left;" id="server-clock"><strong>Server Time : <?php
		$date = date("Y-M-d h:i:s");
		echo $date;
		?></strong</div>
            <?php if ($this->isSupervisor()):?>
             | <?php echo CHtml::link('Pindah ke Mode Kontestan', $this->createUrl('contest/news'), array('id' => 'changemode'));?>
            <?php endif;?>
        </div>
        
        <?php echo $content; ?>
    </div>
</div><!-- end div#center -->
</div>
<?php $this->endContent(); ?>

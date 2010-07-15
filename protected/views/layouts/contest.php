<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . "/css/arrastheme/layouts/2column.css"); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . "/css/arrastheme/layouts/contest.css"); ?>
<?php Yii::app()->clientScript->registerCoreScript("jquery.js"); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/scripts/jquery.timers.js"); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/scripts/dateformat.js"); ?>
<?php Yii::app()->clientScript->registerScript('timer-js', '
	var secondsLeft = '.$this->getContest()->getSecondsLeft().';
	$("#time-left").text(Math.floor(secondsLeft / 3600) + ":" + Math.floor(secondsLeft % 3600 / 60) + ":" + secondsLeft % 60);
    //$(\'#clock-wrapper\').html(dateFormat());
    $(document).everyTime(\'1s\',function(i) {
		if (secondsLeft > 0 )
			secondsLeft--;
		else
			secondsLeft = 0;
			
        $("#time-left").text(Math.floor(secondsLeft / 3600) + ":" + Math.floor(secondsLeft % 3600 / 60) + ":" + secondsLeft % 60);

		if (secondsLeft <= 300)
			$("#time-left").css("color" , "#F50505");
		else if (secondsLeft <= 15 * 60)
			$("#time-left").css("color" , "#DAA520");
		else
			$("#time-left").css("color" , "#05F505");
    });
');?>
<?php Yii::app()->clientScript->registerCss('align', '
   #main-right {text-align:left;font-weight:normal;}
   div.article {text-align:left;font-weight:normal;}
   div#display {text-align:left;font-weight:normal;}
   div.problem-view {text-align:left;font-weight:normal;}
   #time-left {color: #05F505;}
');?>

<?php $this->beginContent('application.views.layouts.main'); ?>
<div id="main-left">
    <?php echo $this->renderPartial('application.views.layouts.sidebars.user'); ?>
    <?php echo $this->renderPartial('application.views.layouts.sidebars.main'); ?>
    <?php echo $this->renderPartial('application.views.layouts.sidebars.supervisor'); ?>
    <?php echo $this->renderPartial('application.views.layouts.sidebars.administrator'); ?>
    <?php echo $this->renderPartial('application.views.layouts.sidebars.facebook'); ?>
    <?php echo $this->renderPartial('application.views.layouts.sidebars.twitter'); ?>
</div><!-- end div#left -->

<div id="main-right">
    <div class="section" id="contest-wrapper">
        <h2 class="title"><?php echo $this->getContest()->name; ?></h2>
        <div id="contest-nav-wrapper">
            <?php
            $cid = Yii::app()->controller->id;
            $contestid = $this->getContest()->id;

			$contestTypeHandler = $this->getContest()->getContestTypeHandler();

			$additionalMenus = array();
			foreach ($contestTypeHandler->getContestantMenu() as $key => $menuName) {
				$additionalMenus[] = array('label' => $menuName, 'url' => array('contest/menu' , 'index' => $key) , 'itemOptions' => array('class' => ($cid == 'contest/menu') ? 'selected' : ''));
			}

            $contestlinkitems = array(
                array('label' => Yii::t('contest', 'Pengumuman'), 'url' => array('contest/news/index')),
                array('label' => Yii::t('contest', 'Soal'), 'url' => array('contest/problem/index')),
                array('label' => Yii::t('contest', 'Jawaban'), 'url' => array('contest/submission/index')),
                array('label' => Yii::t('contest', 'Klarifikasi'), 'url' => array('contest/clarification/index')),
                array('label' => Yii::t('contest', 'Peringkat'), 'url' => array('contest/rank/index')),
                array('label' => Yii::t('contest', 'Keluar'), 'url' => array('contest/contest/signout/index'), 'itemOptions' => array('id' => 'signout', 'class' => 'right')),
                array('label' => Yii::t('contest', 'Petunjuk'), 'url' => array('contest/help/index'), 'itemOptions' => array('id' => 'help', 'class' => 'right')),
            );

			$contestlinkitems = array_merge($contestlinkitems , $additionalMenus);
            
            $this->widget('zii.widgets.CMenu', array(
                'items' => $contestlinkitems,
                'htmlOptions' => array('class' => 'content-nav')
            ));
            ?>
            <div class="spacer"></div>
        </div>
        <?php if (!$this->getContest()->hasStarted()):?>
        <div id="contest-expired" class="error">
            <?php echo Yii::t('contest', 'Kontes ini belum dimulai'); ?>
        </div>
        <?php elseif ($this->getContest()->hasEnded()):?>
        <div id="contest-expired" class="error">
            <?php echo Yii::t('contest', 'Kontes ini telah berakhir'); ?>
        </div>
        <?php endif;?>
        <div id="contestbar-wrapper">
            <div id="clock-wrapper">
				<span id="time-left">
					<?php echo round($this->getContest()->getSecondsLeft() / 60) . ':' .  $this->getContest()->getSecondsLeft() % 60;?>
				</span> <?php echo Yii::t('contest', 'menit tersisa'); ?>
			</div>
			<div style="float: left;" id="server-clock">
				<strong><?php echo Yii::t('contest', 'Waktu Server'); ?> : <?php
					$date = date("Y-M-d h:i:s");
					echo $date;
				?></strong
			</div>
			
            <?php if ($this->isSupervisor()):?>
            | <?php echo CHtml::link('Pindah ke Mode Manajer', $this->createUrl('contest/supervisor'), array('id' => 'changemode'));?>
            <?php endif;?>
        </div>
        <?php echo $content; ?>
        </div>
    </div><!-- end div#center -->
</div>
<?php $this->endContent(); ?>

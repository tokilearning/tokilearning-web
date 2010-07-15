<?php $this->setPageTitle("Lihat Pengguna - ".$model->full_name);?>
<?php $this->renderPartial('_menu');?>

<?php
Yii::app()->clientScript->registerCss('profile_information_css', '
    #profile-wrapper {padding:15px;border:1px solid #bbb;margin-bottom:5px;}
    #avatar-wrapper {width:150px;float:left;}
    #information-wrapper {width:430px;float:right;}
    #profile-wrapper .spacer {clear:both;}
    #information-wrapper div.dtable {display:table;}
    #information-wrapper div.dtable div.drow {display:table-row;}
    #information-wrapper div.dtable div.drow span {display:table-cell;padding:0px 5px 0px 5px;}
    #information-wrapper div.dtable div.drow span.name {font-weight:bold;text-align:right;}
');
?>


<?php Yii::app()->clientScript->registerCss('statistics', '
    .stats_container {border:1px solid #bbb;margin-bottom:5px;}
    .stats_container h3 {border-bottom:1px solid #000;margin:6px 6px 6px 6px;}
    #general_stats {}
    #problem_stats h4 {margin-bottom:2px;}
'); ?>
<?php
$statistics = StatisticsHandler::instance();
$problemstat = $statistics->getProblemStat();
$userstat = $statistics->getUserStat();
$mystat = $userstat['users'][$model->id];
?>

<div id="profile-wrapper">
    <div class="spacer"></div>
    <div id="avatar-wrapper">
        <img src="<?php echo Yii::app()->request->baseUrl?>/images/noprofile.jpg" alt="<?php echo $model->full_name; ?>"/>
    </div>
    <div id="information-wrapper">
        <div class="button" style="float:right">
        <?php echo CHtml::link('Edit', $this->createUrl('update', array('id' => $model->id)));?>
    </div>
        <div class="dtable">
            <div class="drow">
                <span class="name">Full Name</span>
                <span><?php echo $model->full_name; ?></span>
            </div>
            <div class="drow">
                <span class="name">Username</span>
                <span><?php echo $model->username; ?></span>
            </div>
            <div class="drow">
                <span class="name">Email</span>
                <span><?php echo $model->email; ?></span>
            </div>
            <div class="drow">
                <span class="name">Join Date</span>
                <span><?php echo $model->join_time; ?></span>
            </div>
            <div class="drow">
                <span class="name">Logins</span>
                <span><?php echo $model->logins; ?></span>
            </div>
            <div class="drow">
                <span class="name">Last Login</span>
                <span><?php echo CDateHelper::timespanAbbr($model->last_login); ?></span>
            </div>
            <div class="drow">
                <span class="name">Last IP</span>
                <span><?php echo $model->last_ip; ?></span>
            </div>
        </div>
    </div>
    <div class="spacer"></div>
</div>

<div class="stats_container" id="general_stats">
    <h3>Statistik Umum</h3>
    <div class="dtable">
        <div class="drow">
            <span>Peringkat</span>
            <span>:</span>
            <span><?php echo (isset($mystat) ? $mystat['rank'] : 'n/a')?></span>
        </div>
        <div class="drow">
            <span>Soal Terselesaikan</span>
            <span>:</span>
            <span><?php echo (isset($mystat) ? count($mystat['problems']['accepted']) : 'n/a')?></span>
        </div>
        <div class="drow">
            <span>Jumlah Jawaban</span>
            <span>:</span>
            <span><?php echo (isset($mystat) ? $mystat['submissions']['count'] : 'n/a')?></span>
        </div>
    </div>
</div>
<div class="stats_container" id="problem_stats">
    <h3>Statistik Soal</h3>
    <div class="dtable" style="width:90%;margin:auto;">
        <div class="drow">
            <div style="display:table-cell;width:50%">
                <h4>Soal Terselesaikan</h4>
                <div>
                <?php if(isset($mystat['problems']['accepted']) && (count($mystat['problems']['accepted'])) > 0):?>
                <?php $acproblems = $mystat['problems']['accepted'];?>
                <?php sort($acproblems);?>
                    <ol>
                        <?php foreach($acproblems as $pid):?>
                        <?php $problem = Problem::model()->findByPk($pid, array('select' => array('id', 'title')));?>
                        <li><?php echo CHtml::link($problem->title, $this->createUrl('problem/view', array('id' => $problem->id)),array('target' => '_blank')); ?></li>
                        <?php endforeach;?>
                    </ol>
                <?php else:?>
                    <em>Belum ada soal terselesaikan</em>
                <?php endif;?>
                </div>
            </div>
            <div style="display:table-cell;width:50%">
                <h4>Soal Masih Dicoba</h4>
                <div>
                <?php if(isset($mystat['problems']['not_accepted']) && (count($mystat['problems']['not_accepted'])) > 0):?>
                <?php $nacproblems = $mystat['problems']['not_accepted'];?>
                <?php sort($nacproblems);?>
                    <ol>
                        <?php foreach($nacproblems as $pid):?>
                        <?php if (in_array($pid, $acproblems)) continue;?>
                        <?php $problem = Problem::model()->findByPk($pid, array('select' => array('id', 'title')));?>
                        <li><?php echo CHtml::link($problem->title, $this->createUrl('problem/view', array('id' => $problem->id)),array('target' => '_blank')); ?></li>
                        <?php endforeach;?>
                    </ol>
                <?php else:?>
                    <em>Belum ada soal terselesaikan</em>
                <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>

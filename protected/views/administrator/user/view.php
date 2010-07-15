<?php $this->setPageTitle("Lihat Pengguna - ".$model->full_name);?>
<?php $this->renderPartial('_menu');?>

<?php
Yii::app()->clientScript->registerCss('profile_information_css', '
    #profile-wrapper {padding:15px;}
    #avatar-wrapper {width:150px;float:left;}
    #information-wrapper {width:430px;float:right;}
    #profile-wrapper .spacer {clear:both;}
    #information-wrapper div.dtable {display:table;}
    #information-wrapper div.dtable div.drow {display:table-row;}
    #information-wrapper div.dtable div.drow span {display:table-cell;padding:0px 5px 0px 5px;}
    #information-wrapper div.dtable div.drow span.name {font-weight:bold;text-align:right;}
');
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
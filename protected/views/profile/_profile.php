<?php
Yii::app()->clientScript->registerCss('profile_information_css', '
    #profile-wrapper {padding:15px;}
    #avatar-wrapper {width:150px;float:left;}
    #information-wrapper {width:430px;float:right;}
    #profile-spacer {clear:both;}
    #information-wrapper div.dtable {display:table;}
    #information-wrapper div.dtable div.drow {display:table-row;}
    #information-wrapper div.dtable div.drow span {display:table-cell;padding:0px 5px 0px 5px;}
    #information-wrapper div.dtable div.drow span.name {font-weight:bold;text-align:right;}
');
?>
<div id="profile-wrapper">
    <div id="avatar-wrapper">
        <img src="<?php echo Yii::app()->request->baseUrl?>/images/noprofile.jpg" alt="<?php echo $user->full_name; ?>"/>
    </div>
    <div id="information-wrapper">
        <div class="dtable">
            <div class="drow">
                <span class="name">Nama Panjang</span>
                <span><?php echo $user->full_name; ?></span>
            </div>
            <?php if ($user->city != null && strlen($user->city) > 0) : ?>
                <div class="drow">
                    <span class="name">Kota</span>
                    <span><?php echo $user->city; ?></span>
                </div>
            <?php endif; ?>
            <?php if ($user->institution != null && strlen($user->institution) > 0) : ?>
                    <div class="drow">
                        <span class="name">Institusi</span>
                        <span>
                            <?php echo $user->institution;?><br/>
                            <?php echo $user->institution_address;?><br/>
                            <?php echo $user->institution_phone;?>
                        </span>
                    </div>
            <?php endif; ?>
                    <div class="drow">
                        <span class="name">Bergabung</span>
                        <span><?php echo date("D d M Y", strtotime($user->join_time)); ?></span>
            </div>
            <div></div>
        </div>
    </div>
    <div id="profile-spacer"></div>
</div>
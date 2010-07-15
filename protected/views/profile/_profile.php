<?php
Yii::app()->clientScript->registerCss('profile_information_css', '
    #profile-wrapper {padding:15px;}
    #avatar-wrapper {width:150px;float:left;}
    #information-wrapper {width:430px;float:right;}
    #profile-spacer {clear:both;}
    #information-wrapper div.dtable {display:table;}
    #information-wrapper div.dtable div.drow {}
    #information-wrapper div.dtable div.drow span {padding:3px 7px 3px 7px;}
    #information-wrapper div.dtable div.drow span.name {}
    #information-wrapper .site_url {display:block;text-decoration:none;}
    #information-wrapper .site_url:hover {text-decoration:underline;}
');
?>
<div id="profile-wrapper">
    <div id="avatar-wrapper">
        <img src="<?php echo Yii::app()->request->baseUrl?>/images/noprofile.jpg" alt="<?php echo $user->full_name; ?>"/>
    </div>
    <div id="information-wrapper">
        <div class="dtable">
            <div class="drow">
                <span class="name">Username</span>
                <span><?php echo $user->username; ?></span>
            </div>
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
            <?php if ($user->site_url != null && strlen($user->site_url) > 0) : ?>
                <div class="drow">
                    <span class="name">Alamat Situs</span>
                    <span>
                        <?php $sites = explode(',', $user->site_url);?>
                        <?php foreach($sites as $site):?>
                            <?php echo CHtml::link($site, $site, array('class' => 'site_url'));?>
                        <?php endforeach;?>
                    </span>
                </div>
            <?php endif;?>


                    <div class="drow">
                        <span class="name">Bergabung</span>
                        <span><?php echo CDateHelper::timespanAbbr($user->join_time); ?></span>
            </div>
            <div></div>
        </div>
    </div>
    <div id="profile-spacer"></div>
</div>
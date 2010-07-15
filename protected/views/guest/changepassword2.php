<?php $this->setPageTitle("Lupa Sandi");?>

<?php
Yii::app()->clientScript->registerCss('login-form-css', '
    #forgotwrapper {border:1px solid #bbb;padding:10px;text-align:center;}
    #forgotform {padding:5px;display:table;margin:15px auto;text-align:left;border:1px solid #bbb;}
    #forgotform div.row {margin:0px;;display:table-row;}
    #forgotform div.row span {display:table-cell;padding:1px 10px;}
    #forgotform label {margin:0px;}
    #forgotform input {margin:2px;padding:3px;display:}
    #forgotform input[type=text],  #forgotform input[type=password] {font-size:0.8em;color:#000;}
    #forgotform input[type=submit] {padding:3px;color:black;font-weight:bold;cursor:pointer;}
');
?>
<div id="forgotwrapper">
    Masukkan kata sandi kamu yang baru
<div id="forgotform">
    <div>
    </div>
    <?php echo CHtml::beginForm($this->createUrl('changePassword', array('user' => $user->username, 'key' => $user->activation_code))); ?>
    <div class="row">
        <span><?php echo CHtml::activeLabel($user, 'password'); ?></span>
        <span><?php echo CHtml::activePasswordField($user, 'password') ?></span>
    </div>

    <div class="row">
        <span><?php echo CHtml::activeLabel($user, 'password_repeat'); ?></span>
        <span><?php echo CHtml::activePasswordField($user, 'password_repeat') ?></span>
    </div>
    <div class="row">
        <span></span>
        <span>
            <?php echo CHtml::submitButton('Ubah Sandi'); ?>
        </span>
    </div>
    <?php echo CHtml::errorSummary($user); ?>
    <?php echo CHtml::endForm(); ?>
</div><!-- form -->
</div>
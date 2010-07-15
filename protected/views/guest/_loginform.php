<?php
Yii::app()->clientScript->registerCss('login-form-css', '
    #loginform {padding:5px;display:table;margin:auto;}
    #loginform div.row {margin:0px;;display:table-row;}
    #loginform div.row span {display:table-cell;padding:1px 10px;}
    #loginform label {font-size:0.8em;margin:0px;}
    #loginform input {margin:2px;padding:3px;display:}
    #loginform input[type=text],  #loginform input[type=password] {font-size:0.8em;}
    #loginform input[type=submit] {font-size:0.8em;padding:3px;color:black;font-weight:bold;cursor:pointer;}
    #loginform a.forgot {font-size:0.8em;}
');
?>

<div id="loginform">
    <?php echo CHtml::beginForm(array('guest/signin')); ?>
    <div class="row">
        <span class="name"><?php echo CHtml::activeLabel($loginform, 'username'); ?></span>
        <span><?php echo CHtml::activeTextField($loginform, 'username', array('size' => '25')) ?></span>
    </div>
    <div class="row">
        <span><?php echo CHtml::activeLabel($loginform, 'password'); ?></span>
        <span><?php echo CHtml::activePasswordField($loginform, 'password', array('size' => '25')) ?></span>
    </div>
    <div class="row">
        <span><?php echo CHtml::activeCheckBox($loginform, 'rememberMe'); ?>
        <?php echo CHtml::activeLabel($loginform, 'rememberMe'); ?></span>
        <span><?php echo CHtml::submitButton('Masuk'); ?>
            <?php echo CHtml::link('Lupa Sandi?', array('guest/forgot'), array('class'=>'forgot'))?>
        </span>
    </div>
    <div class="row">
        
    </div>
    <?php echo CHtml::endForm(); ?>
</div><!-- form -->
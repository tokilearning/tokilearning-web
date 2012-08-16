<?php /* @var $user User */; ?>
<div class="grid_12">
        <h1><?php echo $user->fullName; ?></h1>
        <p></p>
</div>
<div class="grid_12">
        <div class="block-border">
                <div class="block-header">
                        <h1><?php echo $user->fullName; ?> (<?php echo $user->username; ?>)</h1><span></span>
                </div>
                <form method="post" action="" class="block-content form" id="validate-form">
                        <?php if (Yii::app()->user->getFlash('userUpdateSuccess')): ?>
                                <div class="alert success">
                                        <strong><?php echo Yii::t('common', 'Success'); ?></strong>
                                        <?php echo Yii::t('translations', 'User successfully updated'); ?>
                                </div>
                        <?php endif; ?>
                        <div class="_100">
                                <p>
                                        <?php echo CHtml::activeLabel($user, 'fullName'); ?>
                                        <?php echo CHtml::activeTextField($user, 'fullName', array('class' => 'required text')); ?>
                                </p>
                                <?php echo CHtml::error($user, 'fullName'); ?>
                        </div>
                        <div class="_100">
                                <p>
                                        <?php echo CHtml::activeLabel($user, 'username'); ?>
                                        <?php echo CHtml::activeTextField($user, 'username', array('class' => 'required text')); ?>
                                </p>
                                <?php echo CHtml::error($user, 'username'); ?>
                        </div>
                        <div class="_100">
                                <p>
                                        <?php echo CHtml::activeLabel($user, 'email'); ?>
                                        <?php echo CHtml::activeTextField($user, 'email', array('class' => 'required text')); ?>
                                </p>
                                <?php echo CHtml::error($user, 'email'); ?>
                        </div>
                        <div class="clear"></div>
                        <div class="block-actions">
                                <ul class="actions-left">
                                        <li><?php echo CHtml::resetButton(Yii::t('common', 'Reset'), array('class' => 'button')); ?></li>
                                </ul>
                                <ul class="actions-right">
                                        <li><?php echo CHtml::submitButton(Yii::t('common', 'Submit'), array('class' => 'button')); ?></li>
                                </ul>
                        </div>
                </form>
        </div>
</div>
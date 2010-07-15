<?php $this->pageTitle = $post->title; ?>
<div class="article">
    <div class="post-meta">
        <?php echo Yii::t('contest', 'Ditulis pada'); ?> <?php echo date("D d M Y H:i", strtotime($post->created_date)); ?> <?php echo Yii::t('contest', 'oleh'); ?>
        <?php echo $post->author->getFullnameLink(); ?>
        <?php if (Yii::app()->user->checkAccess('administrator')): ?>
            | <?php echo CHtml::link('Edit', $this->createUrl('/administrator/announcement/update', array('id' => $post->id))); ?>
        <?php endif; ?>
        </div>
        <div><?php echo str_replace('[more]', '', $post->content); ?></div>
    </div>
<?php //if (true):// ?>
<?php if ((!IPChecker::isInITB()) && (!IPChecker::isLocal())): ?>
<?php
                $this->widget(
                        'application.components.widgets.facebook.FBCommentWidget',
                        array(
                            'title' => (isset($post) ? $post->title : ''),
                            'options' => array(
                                'width' => 692,
                            ),
                            'htmlOptions' => array(
                                'style' => 'background:#fff;width:696px; padding:2px;border:1px solid #bebebe;'
                            )
                        )
                );
?>
<?php endif; ?>
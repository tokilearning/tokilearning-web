<?php $this->pageTitle = $post->title; ?>
<div class="article">
    <h2 class="title"><?php echo CHtml::link($post->title, $this->createUrl('announcement/view', array('id' => $post->id))) ?></h2>
    <div class="post-meta">
        Ditulis pada <?php echo date("D d M Y H:i", strtotime($post->created_date)); ?> oleh
        <?php echo $post->author->getFullnameLink(); ?>
        <?php if (Yii::app()->user->checkAccess('administrator')):?>
         | <?php echo CHtml::link('Edit', $this->createUrl('/administrator/announcement/update', array('id' => $post->id)));?>
        <?php endif;?>
    </div>
    <div><?php echo str_replace('[more]', '', $post->content); ?></div>
</div>
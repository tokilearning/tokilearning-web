<?php $this->setPageTitle("Pengumuman - ".$model->title);?>
<?php $this->renderPartial('_menu');?>
<div class="article" style="border:1px solid #bbb;padding:5px;">
    <div class="button" style="float:right">
        <?php echo CHtml::link('Edit', $this->createUrl('update', array('id' => $model->id)));?>
    </div>
    <h2 class="title"><?php echo CHtml::link($model->title, $this->createUrl('announcement/view', array('id' => $model->id))) ?></h2>
    <div class="post-meta">
        <?php if ($model->status == Announcement::STATUS_DRAFT):?>
        <strong>[DRAFT]</strong>
        <?php endif;?>
        Ditulis pada <?php echo date("D d M Y H:i", strtotime($model->created_date)); ?> oleh
        <?php echo $model->author->getFullnameLink(); ?>
    </div>
    <div><?php echo str_replace('[more]', '', $model->content); ?></div>
</div>
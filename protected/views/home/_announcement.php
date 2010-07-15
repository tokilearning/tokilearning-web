    <div class="article">
        <h3><?php echo CHtml::link($data->title, $this->createUrl('announcement/view', array('id' => $data->id)))?></h3>
        <div class="post-meta">
            <?php echo Yii::t('contest', 'Ditulis pada'); ?> <?php echo date("D d M Y H:i", strtotime($data->created_date)); ?> <?php echo Yii::t('contest', 'oleh'); ?>
            <?php echo $data->author->getFullnameLink(); ?>
        </div>
        <div>
            <?php $pos = strpos ($data->content, '[more]');?>
            <?php if ($pos):?>
                <?php echo substr($data->content, 0, $pos);?>
                <?php echo CHtml::link('Baca Lanjut', $this->createUrl('announcement/view', array('id' => $data->id)), array('class' => 'readmore'));?>
            <?php else:?>
                <?php echo $data->content;?>
            <?php endif;?>
        </div>
    </div>
    <div class="clear post-spt"></div>
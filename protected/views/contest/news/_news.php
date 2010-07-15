    <div class="article">
        <h3><?php echo CHtml::link($data->title, $this->createUrl('view', array('id' => $data->id)))?></h3>
        <div class="post-meta">
            Ditulis pada <?php echo date("D d M Y H:i", strtotime($data->created_date)); ?> oleh
            <?php echo $data->author->getFullnameLink(); ?>
        </div>
        <div><?php echo $data->content; ?></div>
    </div>
    <div class="clear post-spt"></div>
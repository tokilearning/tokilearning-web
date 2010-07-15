<?php $this->setPageTitle("Kontes - ".$model->name);?>
<div class="dtable">
    <div class="drow">
        <span class="shead"><?php echo Yii::t('contest', 'Sifat'); ?></span>
        <span><?php echo ($model->span_type == Contest::CONTEST_SPAN_TYPE_FIXED) ? Yii::t('contest', 'Waktu Tetap') : Yii::t('contest', 'Waktu Virtual');?></span>
    </div>
    <div class="drow">
        <span class="shead"><?php echo Yii::t('contest', 'Waktu Dibuka'); ?></span>
        <span><?php echo $model->start_time;?></span>    
    </div>
    <div class="drow">
        <span class="shead"><?php Yii::t('contest', 'Waktu Ditutup'); ?></span>
        <span><?php echo $model->end_time;?></span>    
    </div>
    <?php if ($model->span_type == Contest::CONTEST_SPAN_TYPE_VIRTUAL) : ?>
    <div class="drow">
        <span class="shead"><?php echo Yii::t('contest', 'Durasi'); ?></span>
        <span><?php echo $model->getConfig('timespan');?> <?php echo Yii::t('contest', 'menit'); ?></span>
    </div>
    <?php endif;?>
</div>
<hr /> 
<?php if ($model->hasEnded() && false) : ?>
<div id="contest-expired" class="error">
    <?php Yii::t('contest', 'Kontes ditutup pada'); ?> <?php echo CDateHelper::timespanAbbr($model->end_time);?>
</div>
<?php else :?>
    <?php 
    if ($model->isMember(Yii::app()->user))
        if ($model->hasStarted()) 
            echo CHtml::link(Yii::t('contest','Masuk') , $this->createUrl('contest/contest/signin' , array('contestid' => $model->id)) , array('class' => 'linkbutton' , 'onclick' => 'return confirm("' . Yii::t('contest', 'Apakah anda yakin ingin memasuki kontes? Pastikan anda membaca peraturan/pengumuman. Timer akan dimulai begitu anda masuk.') . '");'));
        else
            echo '<div class="error">'. Yii::t('contest', 'Kontes dibuka pada') . ' '. CDateHelper::timespanAbbr($model->start_time) .'</div>';
    else if ($model->isRegistrant(Yii::app()->user))
        echo "<div class=\"error\">". Yii::t('contest', 'Pendaftaran anda masih menunggu konfirmasi') . "</div>";
    ?>
<?php endif;?>
<?php;?>
<br /><br />
<h3><?php echo Yii::t('contest','Pengumuman');?></h3>
<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_news',   // refers to the partial view named '_post'
    'emptyText' => Yii::t('contest', 'Belum ada pengumuman'),
    'summaryText' => Yii::t('contest', 'Menampilkan {end} pengumuman dari {count}.'),
    'enableSorting' => false,
    'cssFile' => Yii::app()->request->baseUrl.'/css/yii/listview/style.css',
));
?>
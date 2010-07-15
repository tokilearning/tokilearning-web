<?php $this->setPageTitle(Yii::t('menu', 'Kontes'));?>
<div>
    <h4><?php echo Yii::t('contest', 'Kontes yang kamu ikuti'); ?></h4>
    <?php
    $this->widget('zii.widgets.CListView', array(
        'dataProvider' => $activeContestDataProvider,
        'itemView' => '_contest',
        'summaryText' => Yii::t('contest', 'Menampilkan {start}-{end} dari {count}.'),
        'emptyText' => Yii::t('contest', 'Kamu tidak sedang mengikuti kontes apapun'),
        'cssFile' => Yii::app()->request->baseUrl.'/css/yii/listview/style.css',
    ));
    ?>
</div>
<br/>
<?php echo CHtml::link(Yii::t('contest', 'Lihat semua kontes yang pernah kamu ikut'), $this->createUrl('list', array('filter' => 'active')));?>
<hr/>
<div>
    <h4><?php echo Yii::t('contest', 'Kontes yang dapat diikuti'); ?></h4>
    <?php if (Yii::app()->user->hasFlash('contestRegisterSucces')):?>
    <?php $contest = Yii::app()->user->getFlash('contestRegisterSucces');?>
        <div class="errorMessage">
            <?php echo Yii::t('contest', 'Kamu telah mendaftar di kontes <strong>{contest_name}</strong>. Pendaftaran kamu akan segera dikonfirmasi.', array('{contest_name}' => $contest->name)); ?>
        </div>
        <br/>
    <?php endif;?>
    <?php
    $this->widget('zii.widgets.CListView', array(
        'dataProvider' => $publicContestDataProvider,
        'itemView' => '_opencontest',
        'summaryText' => Yii::t('contest', 'Menampilkan {start}-{end} dari {count}.'),
        'emptyText' => Yii::t('contest', 'Tidak ada kontes terbuka yang sedang berlangsung'),
        'cssFile' => Yii::app()->request->baseUrl.'/css/yii/listview/style.css',
    ));
    ?>
</div>
<br/>
<?php echo CHtml::link(Yii::t('contest', 'Lihat semua kontes terbuka yang pernah berlangsung'), $this->createUrl('list', array('filter' => 'all')));?>

<?php $this->setPageTitle(Yii::t('menu', 'Kontes')); ?>
<div>
    <?php if ($filter == 'active'): ?>
        <h4><?php echo Yii::t('contest', 'Semua kontes yang pernah kamu ikuti'); ?></h4>
    <?php
        $this->widget('zii.widgets.CListView', array(
            'dataProvider' => $dataProvider,
            'itemView' => '_listcontest',
            'summaryText' => Yii::t('contest', 'Menampilkan {start}-{end} dari {count}.'),
            'emptyText' => Yii::t('contest', 'Kamu tidak pernah mengikuti kontes apapun'),
            'template' => '{summary}{pager}<br/>{items}{pager}',
            'cssFile' => Yii::app()->request->baseUrl . '/css/yii/listview/style.css',
        ));
    ?>
    <?php elseif ($filter == 'all'): ?>
            <h4><?php echo Yii::t('contest', 'Semua kontes terbuka yang pernah berlangsung'); ?></h4>
    <?php
            $this->widget('zii.widgets.CListView', array(
                'dataProvider' => $dataProvider,
                'itemView' => '_listcontest',
                'summaryText' => Yii::t('contest', 'Menampilkan {start}-{end} dari {count}.'),
                'emptyText' => Yii::t('contest', 'Belum pernah ada kontes terbuka'),
                'template' => '{summary}{pager}<br/>{items}{pager}',
                'cssFile' => Yii::app()->request->baseUrl . '/css/yii/listview/style.css',
            ));
    ?>
    <?php endif; ?>
</div>

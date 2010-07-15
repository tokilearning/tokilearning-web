<?php
Yii::app()->clientScript->registerCss('contest-css', '
    .contest-wrapper {border:1px solid #bbb;margin-bottom:5px;padding:5px;}
    .contest-wrapper:hover {border:1px solid #000;cursor:pointer;}
    .contest-wrapper h3 {margin:0px 0px 3px 0px;padding:0px 0px 2px 0px;border-bottom:1px dotted #ccc;}
    .contest-wrapper .description {margin:3px 0px 3px 0px;padding:2px 0px 2px 10px;}
    .contest-wrapper .meta {margin:0px 0px 10px 0px;font-size:10px;}
    .contest-wrapper .footer {border-top:1px dotted #bbb;padding:3px 0px 0px 0px;text-align:center;}
    .contest-wrapper .footer a {text-decoration:none;font-weight:bold;}
    .contest-wrapper .footer a:hover {text-decoration:underline;}
');
?>
<div class="contest-wrapper">
    <h3><?php echo $data->name; ?></h3>
    <div class="meta">
        <?php echo Yii::t('labels', 'Dari');?> <?php echo CDateHelper::timespanAbbr($data->start_time); ?> <?php echo Yii::t('labels', 'sampai');?> <?php echo CDateHelper::timespanAbbr($data->end_time); ?>.
    </div>
    <div class="description"><?php echo $data->description; ?></div>
    <?php if ($data->hasEnded()): ?>
        <div id="contest-expired" class="error">
            <?php echo Yii::t('contest', 'Kontes ini telah berakhir'); ?>
        </div>
    <?php endif; ?>
        <div class="footer">
        <?php if ($data->isRegistrant(Yii::app()->user->getRecord())): ?>
            Pendaftaran sedang menunggu konfirmasi
        <?php else: ?>
        <?php echo CHtml::link(Yii::t('contest', 'Lihat'), $this->createUrl('contest/contest/view', array('contestid' => $data->id))); ?>
        <?php endif; ?>
    </div>
</div>
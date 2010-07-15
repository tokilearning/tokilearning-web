<?php $this->setPageTitle("Pengguna");?>
<?php $this->renderPartial('_menu'); ?>

<?php $userOnlineCount = User::getOnlineUserCount();?>
<div class="dtable">
    <div class="drow">
        <span>Ada <?php echo $userOnlineCount?> pengguna sedang online</span>
        <?php if ($userOnlineCount > 0):?>
        <span>: 
            <?php $userOnline = User::getOnlineUsers();?>
            <?php $listuser = array();?>
            <?php foreach ($userOnline as $user):?>
                <?php $listuser[] = CHtml::link($user->full_name, $this->createUrl('view', array('id' => $user->id)));?>
            <?php endforeach;?>
            <?php echo implode(', ', $listuser);?>
        </span>
        <?php endif;?>
    </div>
</div>
<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        'id',
        'username',
        array(
            'name' => 'full_name',
            'value' => '$data->getFullnameLink()',
            'type' => 'raw'
        ),
        //'join_time',
        array(
            'name' => 'last_login',
            'value' => 'CDateHelper::timespanAbbr($data->last_login)',
            'type' => 'raw'
        ),
        array(
            'name' => 'last_activity',
            'value' => 'CDateHelper::timespanAbbr($data->last_activity)',
            'type' => 'raw'
        ),
        array(// display a column with "view", "update" and "delete" buttons
            'class' => 'CButtonColumn',
        ),
    ),
    'summaryText' => 'Menampilkan {start}-{end} dari {count}.',
    'enablePagination' => true,
    'cssFile' => Yii::app()->request->baseUrl.'/css/yii/gridview/style.css',
));
?>

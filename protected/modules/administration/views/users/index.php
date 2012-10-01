<?php
/* @var $this UsersController */
/* @var $dataProvider \CActiveDataProvider */
?>

<div class="row-fluid sortable ui-sortable">		
        <div class="box span12">
                <div data-original-title="" class="box-header well">
                        <h2><i class="icon-user"></i> <?php echo \Yii::t('messages', 'Members'); ?></h2>
                        <div class="box-icon">
                                <a class="btn btn-setting btn-round" href="#"><i class="icon-cog"></i></a>
                                <a class="btn btn-minimize btn-round" href="#"><i class="icon-chevron-up"></i></a>
                                <a class="btn btn-close btn-round" href="#"><i class="icon-remove"></i></a>
                        </div>
                </div>
                <div class="box-content">
                        <?php
                        /* @var $grid \CGridView */
                        $grid = $this->widget('zii.widgets.grid.CGridView', array(
                                'columns' => array(
                                        'id',
                                        'username',
                                        'fullName',
                                        'email',
                                        'createdTime',
                                ),
                                'dataProvider' => $dataProvider,
                                'htmlOptions' => array(
                                        'role' => 'grid',
                                        'class' => 'grid grid-table-bordered',
                                )
                                ));
                        ?>
                </div>
        </div><!--/span-->

</div>
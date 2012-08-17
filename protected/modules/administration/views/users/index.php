<div class="grid_12">
        <h1><?php $this->pageTitle; ?></h1>
        <p></p>
</div>
<div class="grid_12">
        <div class="block-border">
                <div class="block-content">
                        <div class="block-actions">
                                <ul>
                                        <li><?php echo CHtml::link(Yii::t('admin', 'Create User'), array('create'), array('class' => 'button')); ?></li>
                                </ul>
                        </div>
                        <?php
                        Yii::app()->clientScript->registerCss('test', <<<CSS
CSS
);
                        $this->widget('zii.widgets.grid.CGridView', array(
                                'cssFile' => false,
                                'columns' => array(
                                        'id',
                                        array(
                                                'name' => 'username',
                                                'type' => 'raw',
                                                'value' => function($data) {
                                                        return CHtml::link($data->username);
                                                }
                                        ),
                                        array(
                                                'name' => 'fullName',
                                                'type' => 'raw',
                                                'value' => function($data) {
                                                        return CHtml::link($data->fullName);
                                                }
                                        ),
                                        array(
                                                'class' => 'CButtonColumn',
                                                'buttons' => array(
                                                        'password' => array(
                                                                'label' => Yii::t('common', 'Change Password'),
                                                                'imageUrl' => $this->module->getImage('icons/key_16x16.png'),
                                                                'url' => function($data, $row) {
                                                                        /* @var $data User */
                                                                        return array('users/password', 'id' => $data->id);
                                                                }
                                                        )
                                                ),
                                                'template' => '{update} {password}',
                                        )
                                ),
                                'dataProvider' => $dataProvider,
                        ));
                        ?>
                </div>
        </div>
</div>
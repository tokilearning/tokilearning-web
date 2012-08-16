<div class="grid_12">
        <h1><?php $this->pageTitle; ?></h1>
        <p></p>
</div>
<div class="grid_12">
        <div class="block-border">
                <div class="block-content">
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
                                                'template' => '{update}'
                                        )
                                ),
                                'dataProvider' => $dataProvider,
                        ));
                        ?>
                </div>
        </div>
</div>
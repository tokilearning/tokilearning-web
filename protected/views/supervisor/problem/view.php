<?php $this->setPageTitle("Lihat Soal - ".$model->title);?>
<?php $this->renderPartial('_menu');?>

<div>
    <div class="dtable">
        <div class="drow">
            <span class="name"><?php echo CHtml::activeLabel($model, 'id');?></span>
            <span><?php echo $model->id;?></span>
            <span class="name"><?php echo CHtml::activeLabel($model, 'title');?></span>
            <span><?php echo $model->title?></span>
        </div>
        <div class="drow">
            <span class="name"><?php echo CHtml::activeLabel($model, 'author');?></span>
            <span><?php echo $model->author->getFullnameLink();?></span>
            <span class="name"><?php echo CHtml::activeLabel($model, 'problem_type_id');?></span>
            <span><?php echo $model->problemtype->name;?></span>
        </div>
    </div>
</div>
<hr>
<div>
    <?php
    if (!isset($activeTab) || $activeTab == null){
        $activeTab = 'problem';
    }
    $this->widget('CTabView',
            array(
                'tabs' => array(
                    'problem' => array(
                        'title' => 'Soal',
                        'view' => 'view/_problem',
                        'data' => array('model' => $model)
                    ),
                    'submit' => array(
                        'title' => 'Kumpul Jawaban',
                        'view' => 'view/_submit',
                        'data' => array('model' => $model, 'submission' => $submission)
                    ),
                    'submission' => array(
                        'title' => 'Jawaban',
                        'view' => 'view/_submissions',
                        'data' => array('model' => $model,'submissionDataProvider' => $submissionDataProvider)
                    )
                ),
                'id' => 'problem-tab',
                'htmlOptions' => array('class' => 'tab'),
                'cssFile' => Yii::app()->request->baseUrl . "/css/arrastheme/tabs.css",
                'activeTab' => $activeTab
           ));

    ?>

    <?php// echo ProblemHelper::renderDescription($model);?>
</div>
<div class="content-nav-wrapper">
<?php
$this->widget('zii.widgets.CMenu', array(
    'items' => array(
        array('label' => 'Soal', 'url' => Yii::app()->controller->createUrl('training/' . $training->id . '/chapter/' . $chapter->id . '/problem/' . $model->id)),
        array('label' => 'Jawaban', 'url' => Yii::app()->controller->createUrl('training/' . $training->id . '/chapter/' . $chapter->id . '/submission/' . $model->id))
    ),
    'htmlOptions' => array('class'=>'content-nav')
));
?>
     <div class="spacer"></div>
</div>
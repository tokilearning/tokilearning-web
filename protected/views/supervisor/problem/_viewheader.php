<div>
    <div class="dtable">
        <div class="drow">
            <span class="name"><?php echo CHtml::activeLabel($model, 'id');?></span>
            <span><?php echo $model->id;?></span>
            <span class="name"><?php echo CHtml::activeLabel($model, 'title');?></span>
            <span><?php echo $model->title?></span>
            <span><?php echo CHtml::link('Ubah Soal Ini', array('supervisor/problem/update/id/' . $model->id) , array('class' => 'linkbutton')); ?></span>
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
<div class="content-nav-wrapper">
<?php
$this->widget('zii.widgets.CMenu', array(
    'items' => array(
        array('label' => 'Soal', 'url' => array('supervisor/problem/view', 'id' => $model->id)),
        array('label' => 'Jawaban', 'url' => array('supervisor/problem/submissions', 'id' => $model->id))
        ),
    'htmlOptions' => array('class'=>'content-nav')
));
?>
     <div class="spacer"></div>
</div>
<div class="content-nav-wrapper">
<?php
$this->widget('zii.widgets.CMenu', array(
    'items' => array(
        array('label' => 'Soal', 'url' => array('problem/view', 'id' => $model->id)),
        array('label' => 'Jawaban', 'url' => array('problem/submissions', 'id' => $model->id))
        ),
    'htmlOptions' => array('class'=>'content-nav')
));
?>
     <div class="spacer"></div>
</div>
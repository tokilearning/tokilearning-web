<a style="font-style: italic;" href="<?php echo $this->createUrl('supervisor/problem/view' , array('id' => $model->id));?>"><h3>Soal #<?php echo $model->id;?> <?php echo $model->title;?></h3></a>
<div class="content-nav-wrapper">
<?php
$this->widget('zii.widgets.CMenu', array(
    'items' => array(
        array('label' => 'Informasi', 'url' => array('supervisor/problem/update', 'id' => $model->id)),
        array('label' => 'Konfigurasi', 'url' => array('supervisor/problem/configure', 'id' => $model->id)),
        array('label' => 'Privilege', 'url' => array('supervisor/problem/privilege', 'id' => $model->id)),
        array('label' => 'Arena', 'url' => array('supervisor/problem/arena', 'id' => $model->id)),
        ),
    'htmlOptions' => array('class'=>'content-nav')
));
?>
</div>
<div id="content-nav-wrapper">
<?php
$aid = Yii::app()->controller->getAction()->getId();
$this->widget('zii.widgets.CMenu', array(
    'items' => array(
        array('label' => Yii::t('menu', 'Soal'), 'url' => array('contest/problem/view/alias/' . $this->getProblemAlias($model))),
        array('label' => Yii::t('menu', 'Jawaban'), 'url' => array('contest/problem/submissions/alias/' . $this->getProblemAlias($model)))
        ),
    'htmlOptions' => array('class'=>'content-nav')
));
?>
     <div class="spacer"></div>
</div>

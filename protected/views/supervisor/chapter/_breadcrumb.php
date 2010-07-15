<?php
    $crumb = array();
    $chap = $chapter;
    while ($chap->getParentChapter() !== NULL) {
        $crumb[] = $chap;
        $chap = $chap->getParentChapter();
    }
    $crumb[] = $chap;

    while ($chap->previousChapter !== NULL) {
        $chap = $chap->previousChapter;
    }

    $crumb[] = $chap->training;
    $tid = $chap->training->id;

    //echo CHtml::link($chap->training->name , Yii::app()->controller->createUrl('training/' . $tid));
    for ($i = count($crumb) - 2 ; $i >= 0 ; $i--) {
	for ($j = 0 ; $j < count($crumb) - $i - 2 ; $j++)
            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        if ($i != count($crumb) - 2) echo ' &raquo; ';
        echo CHtml::link($crumb[$i]->name , Yii::app()->controller->createUrl('supervisor/chapter/view' , array('id' => $crumb[$i]->id))) . "<br />";
    }
?>
<br /><br />

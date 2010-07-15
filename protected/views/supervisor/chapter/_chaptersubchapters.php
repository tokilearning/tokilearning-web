<?php 
    $completeSubChapters = $model->getCompleteSubChapters();

    foreach ($completeSubChapters as $chapter) {
        for($i = 0 ; $i < $chapter['level'] ; $i++)
            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo CHtml::link($chapter['chapter']->name, array('view', 'id' => $chapter['chapter']->id )) . "<br /><br />";
    }
?>
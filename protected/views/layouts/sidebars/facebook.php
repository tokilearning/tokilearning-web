<?php //if (true):?>
<?php if ((!IPChecker::isInITB()) && (!IPChecker::isLocal())): ?>
<?php

$this->widget(
        'application.components.widgets.facebook.FBActivityWidget',
        array(
            'title' => "TOKI Learning Center",
            'htmlOptions' => array(
                'width' => '200px',
                'height' => '400px',
                'style' => 'background:#fff;margin:2px 0px;'
            ),
            'options' => array(
                'width' => '200px',
                'height' => '400px',
                'recommendations' => 'true'
            )
        )
);
?>
<?php endif; ?>

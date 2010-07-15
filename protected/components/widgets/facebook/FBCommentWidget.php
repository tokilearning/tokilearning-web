<?php

Yii::import('application.components.widgets.facebook.CFBWidget');

class FBCommentWidget extends CFBWidget {

    public $title;
    public $description = NULL;
    public $htmlOptions = array();
    public $options = array();

    public function run() {
        if (!isset($description)) {
            $description = $this->fb_app_title . " " . $this->title;
        }
        $this->render('fbcomment', array(
            'title' => $this->title,
            'description' => $this->description,
            'htmlOptions' => $this->htmlOptions,
            'options' => $this->options
        ));
    }

}
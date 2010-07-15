<?php

Yii::import('application.components.widgets.facebook.CFBWidget');

class FBActivityWidget extends CFBWidget {

    public $title;
    public $description = NULL;
    public $htmlOptions = array();
    public $options = array();
    public $use_app_id = false;

    public function run() {
        if (!isset($description)) {
            $description = $this->fb_app_title . " " . $this->title;
        }
        $this->render('fbactivity', array(
            'title' => $this->title,
            'type' => $this->type,
            'description' => $this->description,
            'htmlOptions' => $this->htmlOptions,
            'options' => $this->options
        ));
    }

}
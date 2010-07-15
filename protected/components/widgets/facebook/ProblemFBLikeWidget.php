<?php

Yii::import('application.components.widgets.facebook.CFBWidget');

class ProblemFBLikeWidget extends CFBWidget {

    public $problem;
    public $htmlOptions = array();
    public $options = array();
    public $use_app_id = false;

    public function run() {
        $this->render('problemfblike', array(
            'problem' => $this->problem,
            'htmlOptions' => $this->htmlOptions,
			'options' => $this->options
        ));
    }

}

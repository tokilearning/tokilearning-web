<?php

class AboutController extends Controller {

    public $layout = 'application.views.layouts.guest';

    public function actionIndex() {
        $this->render('index');
    }

}
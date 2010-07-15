<?php

class AcmicpcConfigurationWidget extends CWidget {

    public $contest;

    public function run() {
        if ($_POST) {
            if ($_POST['config']['freezetime'] !== "")
                $this->contest->setConfig('freezetime', $_POST['config']['freezetime']);
            else
                $this->contest->setConfig('freezetime', 0);
            $this->contest->save();
        }
        $this->render('config' , array('contest' => $this->contest));
    }

}

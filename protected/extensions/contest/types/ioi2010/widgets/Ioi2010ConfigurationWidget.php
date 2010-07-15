<?php

class Ioi2010ConfigurationWidget extends CWidget {

    public $contest;

    public function run() {
        if ($_POST) {
            $this->contest->setConfig('secret', isset($_POST['config']['secret']));
            $this->contest->setConfig('token', isset($_POST['config']['token']));
            $this->contest->setConfig('fullfeedback', isset($_POST['config']['fullfeedback']));
            if ($_POST['config']['token_regen'] !== "")
                $this->contest->setConfig('token_regen', $_POST['config']['token_regen']);
            else
                $this->contest->setConfig('token_regen', null);

            if ($_POST['config']['max_token'] !== "")
                $this->contest->setConfig('max_token', $_POST['config']['max_token']);
            else
                $this->contest->setConfig('max_token', 0);

            $this->contest->save();
        }

        $this->render('config', array('contest' => $this->contest));
    }

}

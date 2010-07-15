<?php

class BatchUserCreateForm extends CFormModel {

    public $usernamePrefix = 'p_';
    public $usernamePostfix = '_x';
    public $digits = '3';
    public $start = '1';
    public $end = '100';
    public $mailPrefix = 'p_';
    public $mailPostfix = '_x';
    public $mailDomain = 'lc.toki.if.itb.ac.id';
    public $mail;
    public $passwordLength = '6';
    public $uniformPassword = false;

    private $_generatedUsers;
    
    public function rules(){
        return array(
            array('usernamePrefix, digits, start, end, mailPrefix, mailDomain, passwordLength', 'required'),
            array('usernamePostfix, mailPostfix', 'safe'),
            array('start, end, digits', 'numerical', 'min' => 0),
            array('start', 'compare', 'compareAttribute' => 'end', 'operator' => '<='),
            array('passwordLength', 'numerical', 'min' => 6, 'max' => 16),
            array('usernamePrefix', 'checkValidUsername'),
            array('mailDomain', 'checkValidEmail'),
            array('uniformPassword', 'boolean'),
        );
    }

    public function afterValidate() {
        $this->checkUsernameExists();
        $this->checkEmailExists();
        return parent::afterValidate();
    }

    public function checkUsernameExists(){
        $d = $this->digits;
        $usernames = array();
        for ($i = $this->start; $i <= $this->end; $i++){
            $username = sprintf("%s%0".$d."d%s", $this->usernamePrefix, $i, $this->usernamePostfix);
            $usernames[] = $username;
        }
        foreach($usernames as $username){
            if (User::model()->exists("username = '$username'")){
                $this->addError('usernamePrefix', 'Username '.$username.' exists');
            }
        }
    }

    public function checkEmailExists(){
        $d = $this->digits;
        $emails = array();
        for ($i = $this->start; $i <= $this->end; $i++){
            $email = sprintf("%s%0".$d."d%s@%s", $this->mailPrefix, $i, $this->mailPostfix, $this->mailDomain);
            $emails[] = $email;
        }
        foreach($emails as $email){
            if (User::model()->exists("email = '$email'")){
                $this->addError('mailDomain', 'Email '.$email.' exists');
            }
        }
    }

    public function checkValidUsername($attribute, $params){
        $username = $this->usernamePrefix.'000'.$this->usernamePostfix;
        if (!preg_match('/^[a-zA-Z][a-zA-Z0-9_]+$/', $username)){
            $this->addError('usernamePrefix','Username combination is not valid username');
        }
    }

    public function checkValidEmail($attribute, $params){
        $email = $this->mailPrefix.'000'.$this->mailPostfix.'@'.$this->mailDomain;
        if (!preg_match("/^[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/", $email)){
            $this->addError('mailDomain','Mail combination is not valid email');
        }
    }

    public function generateUsers(){
        $this->_generatedUsers = array();
        $d = $this->digits;
        for ($i = $this->start; $i <= $this->end; $i++){
            $username = sprintf("%s%0".$d."d%s", $this->usernamePrefix, $i, $this->usernamePostfix);
            $email = sprintf("%s%0".$d."d%s@%s", $this->mailPrefix, $i, $this->mailPostfix, $this->mailDomain);

            if ($this->uniformPassword)
                $password = $username;
            else
                $password = CTextHelper::random('distinct', $this->passwordLength);

            $this->_generatedUsers[] = array(
                'username' => $username,
                'email' => $email,
                'full_name' => $username,
                'password' => $password,
            );
        }
        return $this->_generatedUsers;
    }
}
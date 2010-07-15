<?php

class LoginForm extends CFormModel {

    public $username;
    public $password;
    public $rememberMe = false;
    public $identity;

    public function rules() {
        return array(
            array('username, password', 'required'),
            array('rememberMe', 'boolean'),
            array('password', 'authenticate'),
        );
    }

    public function authenticate($attribute, $params) {
        $this->identity = new UserIdentity($this->username, $this->password);
        if (!$this->identity->authenticate()){
            $this->addError('password', 'Incorrect username or password.');
        }
    }

    public function attributeLabels() {
        return array(
            'username' => 'Username/Email',
            'password' => 'Sandi',
            'rememberMe' => 'Ingat saya'
        );
    }

}
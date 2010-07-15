<?php

/**
 *
 */
class User extends CActiveRecord {

    public $password_repeat;
    public $email_repeat;
    public $verifyCode;

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public static function checkUsernameEmail($username){
        if (preg_match("/^[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/", $username)) {
            $record = User::model()->exists('LOWER(email)=?', array(strtolower($username)));
        } else {
            $record = User::model()->exists('LOWER(username)=?', array(strtolower($username)));
        }
        return $record;
    }

    public static function findbyUsernameEmail($username){
        if (preg_match("/^[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/", $username)) {
            $record = User::model()->find('LOWER(email)=?', array(strtolower($username)));
        } else {
            $record = User::model()->find('LOWER(username)=?', array(strtolower($username)));
        }
        return $record;
    }
    
    public function tableName() {
        return '{{users}}';
    }

    public function rules(){
        return array(
            array('username, password', 'length', 'max'=>35, 'min'=>3),
            array('username', 'match', 'pattern' => '/^[a-zA-Z][a-zA-Z0-9_]+$/', 'message' => '{attribute} is invalid. Only number, alphabet, and underscore allowed'),
            array('full_name', 'match', 'pattern' => '/^[\p{L}\s]+$/',  'message' => '{attribute} is invalid. Only alphabet allowed'),
            array('email', 'length', 'max' => 40),
            array('email', 'email'),
            array('username, email', 'unique', 'caseSensitive'=>false),
            //            
            array('full_name, username, password, password_repeat, email, email_repeat, verifyCode', 'required', 'on' => 'register'),
            array('verifyCode', 'captcha', 'allowEmpty'=>!extension_loaded('gd'), 'on' => 'register'),
            array('password, email', 'compare', 'on' => 'register'),
            //
            array('full_name, username, password, email', 'required', 'on' => 'create'),
            array('full_name, username, email', 'required', 'on' => 'setting'),
            //
            array('password, password_repeat', 'required', 'on' => 'forgotpassword'),
            array('password', 'compare', 'on' => 'forgotpassword'),
        );
    }

    public function getProfileUrl(){
        return Yii::app()->createUrl('profile/view', array('id' => $this->id));
    }

    public function getFullnameLink(){
        return CHtml::link($this->full_name, $this->getProfileUrl());
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'full_name' => 'Nama Panjang',
            'username' => 'Username',
            'email_repeat' => 'Ulang Email',
            'password' => 'Sandi',
            'password_repeat' => 'Ulang Sandi',
            'verifyCode' => 'Kode Verifikasi',
            'join_date' => 'Bergabung'
        );
    }

    public function safeAttributes(){
        return array(
            'register'=>'username, full_name, password_repeat, email_repeat, password, email, verifyCode',
            'forgotpassword' => 'password_repeat, password',
        );
    }

    public function generateActivationCode(){
        $this->activation_code = CTextHelper::random('alnum', 32);
        $this->save(false);
    }

    
}
//end of file
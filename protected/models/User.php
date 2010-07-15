<?php

/**
 *
 */
class User extends CActiveRecord {
    //TODO: Reserved for future use
    const USER_TYPE_USER = 0;
    const USER_TYPE_DUMMY = 1;

    public $password_repeat;
    public $email_repeat;
    public $verifyCode;
    private $original_password;

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public static function checkUsernameEmail($username) {
        if (preg_match("/^[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/", $username)) {
            $record = User::model()->exists('LOWER(email)=?', array(strtolower($username)));
        } else {
            $record = User::model()->exists('LOWER(username)=?', array(strtolower($username)));
        }
        return $record;
    }

    public static function findbyUsernameEmail($username) {
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

    public function afterFind() {
        $this->original_password = $this->password;
        return parent::afterFind();
    }

    public function beforeSave() {
        if ($this->isNewRecord) {
            $this->password = sha1($this->password);
        } else {
            if ($this->password != $this->original_password) {
                $this->password = sha1($this->password);
            }
        }
        //
        //$notags = array('site_url', 'institution',
        //    'institution_address', 'institution_phone',
        //    'city');
        //foreach ($notags as $ntags) {
        //    $this->$ntags = strip_tags($this->$ntags);
        //    $this->$ntags = CHtml::encode($this->$ntags);
        //}
		$this->purifyAttributes();
        return parent::beforeSave();
    }

	private function purifyAttributes(){
		if (in_array($this->scenario, array('adminUpdate, updateGeneral'))){
			$purifier = new CHtmlPurifier();
			$this->site_url = $purifier->purify($this->site_url);
			$this->institution = $purifier->purify($this->institution);
			$this->institution_address = $purifier->purify($this->institution_address);
			$this->institution_phone = $purifier->purify($this->institution_phone);
			$this->city = $purifier->purify($this->city);
		}
		
	}

    public function rules() {
        return array(
            array('username', 'length', 'max' => 35, 'min' => 3),
            array('password', 'length', 'min' => 6),
            array('username', 'match', 'pattern' => '/^[a-zA-Z][a-zA-Z0-9_]+$/', 'message' => '{attribute} is invalid. Only number, alphabet, and underscore allowed'),
            array('full_name', 'match', 'pattern' => '/^[\p{L}\s]+$/', 'message' => '{attribute} is invalid. Only alphabet allowed'),
            array('email', 'length', 'max' => 40),
            array('email', 'email'),
            array('username, email', 'unique', 'caseSensitive' => false),
            array('verifyCode', 'captcha', 'allowEmpty' => !extension_loaded('gd'), 'on' => 'register'),
            array('password', 'compare', 'on' => 'register, forgotPassword'),
            array('password', 'compare', 'on' => 'register'),
            //required
            array('full_name', 'required', 'on' => 'register, create, setting, adminUpdate'),
            array('username', 'required', 'on' => 'register, create, setting, adminUpdate'),
            array('email', 'required', 'on' => 'register, create, setting, adminUpdate'),
            array('password', 'required', 'on' => 'register, create, forgotPassword'),
            array('password_repeat', 'required', 'on' => 'register, forgotPassword'),
            array('email_repeat, verifyCode', 'required', 'on' => 'register'),
            array('type', 'required', 'on' => 'adminUpdate'),
            //safe
            array('address, phone', 'safe'),
            array('site_url, institution, institution_address, institution_phone, city, additional_information', 'safe'),
			//array('site_url, institution, institution_address, institution_phone, city, additional_information', 'safe', 'on' => 'adminUpdate, updateGeneral'),			
			//array('site_url, institution, institution_address, institution_phone, city, additional_information', 'filter','filter'=>array($obj=new CHtmlPurifier(),'purify')),
        );
    }

    public function relations() {
        return array(
            'groups' => array(self::MANY_MANY, 'Group', 'groups_users(user_id, group_id)'),
        );
    }

    public function getProfileUrl() {
        return Yii::app()->createUrl('profile/view', array('id' => $this->id));
    }

    public function getFullnameLink() {
        return CHtml::link($this->full_name, $this->getProfileUrl());
    }

    public function isDummy() {
        return ($this->type == self::USER_TYPE_DUMMY);
    }

    public static function getOnlineUsers($seconds = 300){
        //SELECT COUNT(*) FROM `users` WHERE TIME_TO_SEC(TIMEDIFF(NOW(), last_activity)) < 300
        $users = self::model()->findAll(array(
            'select' => array('id', 'username', 'full_name'),
            'condition' => "TIME_TO_SEC(TIMEDIFF(NOW(), last_activity)) < $seconds",
        ));
        return $users;
    }

    public static function getOnlineUserCount($seconds = 300){
        $usercount = self::model()->count(array(
            'condition' => "TIME_TO_SEC(TIMEDIFF(NOW(), last_activity)) < $seconds",
        ));
        return $usercount;
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'address' => 'Alamat',
            'phone' => 'Nomor Telepon',
            'full_name' => 'Nama Panjang',
            'username' => 'Username',
            'email_repeat' => 'Ulang Email',
            'password' => 'Sandi',
            'password_repeat' => 'Ulang Sandi',
            'verifyCode' => 'Kode Verifikasi',
            'join_date' => 'Bergabung',
            'site_url' => 'Alamat Situs',
            'institution' => 'Institusi/Sekolah',
            'institution_address' => 'Alamat Institusi/Sekolah',
            'institution_phone' => 'Telepon Institusi/Sekolah',
            'city' => 'Provinsi/Kota',
        );
    }

    public function generateActivationCode() {
        $this->activation_code = CTextHelper::random('alnum', 32);
        $this->save(false);
    }

}

//end of file

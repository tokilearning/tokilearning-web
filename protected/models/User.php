<?php

/**
 * This is the model class for table "Users".
 *
 * The followings are the available columns in table 'Users':
 * @property string $id primary key for the User.
 * @property string $username user's identifier name.
 * @property string $email user's email.
 * @property string $password user's password.
 * @property string $fullName user's display name.
 * @property string $createdTime time when user created by user or registered.
 * @property string $updatedTime time when user data being updated by admin or user him/herself.
 * @property string $lastLoginTime time when user last logged in.
 * @property string $lastActivityTime time when user last accessed a controller.
 * @property string $loginCount how many times user logged in.
 * @property string $removedTime time when the problem is marked as removed.
 * @property boolean $isRemoved flag whether a user is removed or not.
 *
 * The followings are additional properties in model 'User':
 * //TODO: Add additional properties when needed.
 * //Additional properties are properties that are accessed by PHP's magic method
 * //i.e. not declared explicitly.
 * @property Problem $problems the problems authored by this user.
 * @property Submission $submissions the submissions authored by this user.
 *
 * @author Petra Barus <petra.barus@gmail.com>
 * @package application.models
 */
class User extends CActiveRecord {
        /**
         * Scenario lists.
         *
         * This lists scenario that will be used for attribute validation.
         *
         * TODO: Put scenario with SCENARIO_ prefix. Put note if really needed.
         * SCENARIO_LOGIN_BY_EMAIL
         * SCENARIO_LOGIN_BY_USERNAME
         * SCENARIO_REGISTER
         * SCENARIO_UPDATE
         * SCENARIO_ADMIN_UPDATE
         *
         */

        const SCENARIO_LOGIN_BY_EMAIL = "login_email";
        const SCENARIO_LOGIN_BY_USERNAME = "login_username";
        const SCENARIO_REGISTER = "register";
        const SCENARIO_UPDATE = "update";
        const SCENARIO_ADMIN_UPDATE = "admin_update";

        /**
         * Additional properties in model 'User':
         */

        /**
         *
         * @var string property to store user's password repeat in register form.
         */
        public $passwordRepeat;

        /**
         * Returns the static model of the specified AR class.
         * @param string $className active record class name.
         * @return User the static model class
         */
        public static function model($className = __CLASS__) {
                return parent::model($className);
        }

        /**
         * @return string the associated database table name
         */
        public function tableName() {
                return 'Users';
        }

        /**
         * @return array the behavior configurations (behavior name=>behavior configuration).
         */
        public function behaviors() {
                return array(
                        'removable' => 'application.components.behaviors.RemovableBehavior',
                );
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules() {
                return array(
                        // general rule
                        array('username', 'match', 'pattern' => '/^[a-zA-Z][a-zA-Z0-9_]+$/', 'message' => Yii::t('rules', '{attribute} is invalid. Only alphabet, number, and underscore allowed')),
                        array('username, email', 'length', 'max' => 255, 'min' => 6),
                        array('isRemoved', 'numerical', 'integerOnly' => true),
                        array('email', 'email', 'allowName' => true),
                        array('password', 'length', 'max' => 32, 'min' => 4),
                        array('loginCount', 'length', 'max' => 20),
                        // safe
                        array('createdTime, updatedTime, lastLoginTime, lastActivityTime', 'safe'),
                        // login by username scenario || update scenario
                        array('username, password', 'required', 'on' => self::SCENARIO_LOGIN_BY_USERNAME),
                        array('username',
                                'application.components.validators.LXExistValidator',
                                'criteria' => array(
                                        'condition' => 'password=SHA1(:pwd)',
                                        'params' => array(':pwd' => 'password'),
                                ),
                                'on' => self::SCENARIO_LOGIN_BY_USERNAME
                        ),
                        // login by email scenario
                        array('email, password', 'required', 'on' => self::SCENARIO_LOGIN_BY_EMAIL),
                        array('email',
                                'application.components.validators.LXExistValidator',
                                'criteria' => array(
                                        'condition' => 'password=SHA1(:pwd)',
                                        'params' => array(':pwd' => 'password'),
                                ),
                                'on' => self::SCENARIO_LOGIN_BY_EMAIL
                        ),
                        // register scenario
                        array('username, email, password, passwordRepeat, fullName', 'required', 'on' => self::SCENARIO_REGISTER),
                        array('password', 'compare', 'compareAttribute' => 'passwordRepeat', 'on' => self::SCENARIO_REGISTER),
                        array('username, email', 'unique', 'on' => self::SCENARIO_REGISTER),
                );
        }

        /**
         * @return array relational rules.
         */
        public function relations() {
                return array(
                        'problems' => array(self::HAS_MANY, 'User', 'authorId'),
                        'submissions' => array(self::HAS_MANY, 'Submission','submitterId'),
                );
        }

        /**
         * @return array scopes.
         */
        public function scopes() {
                $t = $this->tableAlias;
                return array(
                        'sortNewestCreatedTime' => array(
                                'order' => "`{$t}`.`createdTime` DESC",
                        ),
                );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */
        public function attributeLabels() {
                return array(
                        'id' => Yii::t('labels', 'ID'),
                        'username' => Yii::t('labels', 'Username'),
                        'email' => Yii::t('labels', 'Email'),
                        'password' => Yii::t('labels', 'Password'),
                        'fullName' => Yii::t('labels', 'Full Name'),
                        'createdTime' => Yii::t('labels', 'Created Time'),
                        'updatedTime' => Yii::t('labels', 'Updated Time'),
                        'lastLoginTime' => Yii::t('labels', 'Last Login Time'),
                        'lastActivityTime' => Yii::t('labels', 'Last Activity Time'),
                        'loginCount' => Yii::t('labels', 'Login Count'),
                        'removedTime' => Yii::t('labels', 'Removed Time'),
                        'isRemoved' => Yii::t('labels', 'Is Removed'),
                );
        }

}

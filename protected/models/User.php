<?php

/**
 * This is the model class for table "Users".
 *
 * The followings are the available columns in table 'Users':
 * @property string $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $fullName
 * @property string $createdTime
 * @property string $updatedTime
 * @property string $lastLoginTime
 * @property string $lastActivityTime
 * @property string $loginCount
 * @property integer $isRemoved
 * 
 * The followings are additional properties in model 'User':
 * //TODO: Add additional properties when needed.
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
         */

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
         * @return array validation rules for model attributes.
         */
        public function rules() {
                return array(
                        array('username', 'length', 'min' => 6),
                        array('username', 'match', 'pattern' => '/^[a-zA-Z][a-zA-Z0-9_]+$/', 'message' => Yii::t('rules', '{attribute} is invalid. Only alphabet, number, and underscore allowed')),
                        array('username, email, password, fullName', 'required'),
                        array('isRemoved', 'numerical', 'integerOnly' => true),
                        array('username, email', 'length', 'max' => 255),
                        array('password', 'length', 'max' => 32),
                        array('loginCount', 'length', 'max' => 20),
                        array('createdTime, updatedTime, lastLoginTime, lastActivityTime', 'safe'),
                );
        }

        /**
         * @return array relational rules.
         */
        public function relations() {
                return array(
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
                        'isRemoved' => Yii::t('labels', 'Is Removed'),
                );
        }

}


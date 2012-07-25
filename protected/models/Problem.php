<?php

/**
 * This is the model class for table "Problems".
 *
 * The followings are the available columns in table 'Problems':
 * @property string $id problem's id.
 * @property string $title problem's title.
 * @property string $authorId the id of this problem's author.
 * @property string $shortDescription problem's short description.
 * @property string $description problem's long description.
 * @property integer $privacyLevel //TODO what's this?
 * @property string $createdTime time when the problem is first created by user.
 * @property string $modifiedTime time when the problem is last modified by user.
 * @property string $removedTime time when the problem is marked as removed.
 * @property boolean $isRemoved flag whether the problem is removed or not.
 *
 * The followings are the available model relations:
 * @property User $author problem's author
 * 
 * @author Muhammad Adinata <mail.dieend@gmail.com>
 * @package application.models
 */
class Problem extends CActiveRecord {

        /**
         * Returns the static model of the specified AR class.
         * @param string $className active record class name.
         * @return Problem the static model class
         */
        public static function model($className = __CLASS__) {
                return parent::model($className);
        }

        /**
         * @return string the associated database table name
         */
        public function tableName() {
                return 'Problems';
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
                        array('title, authorId, createdTime', 'required'),
                        array('privacyLevel', 'numerical', 'integerOnly' => true),
                        array('authorId', 'length', 'max' => 20),
                        array('shortDescription, description, modifiedTime', 'safe'),
                );
        }

        /**
         * @return array relational rules.
         */
        public function relations() {
                return array(
                        'author' => array(self::BELONGS_TO, 'User', 'authorId'),
                );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */
        public function attributeLabels() {
                return array(
                        'id' => Yii::t('labels', 'ID'),
                        'title' => Yii::t('labels', 'Title'),
                        'authorId' => Yii::t('labels', 'Author'),
                        'shortDescription' => Yii::t('labels', 'Short Description'),
                        'description' => Yii::t('labels', 'Description'),
                        'privacyLevel' => Yii::t('labels', 'Privacy Level'),
                        'createdTime' => Yii::t('labels', 'Created Time'),
                        'modifiedTime' => Yii::t('labels', 'Modified Time'),
                        'removedTime' => Yii::t('labels', 'Removed Time'),
                        'isRemoved' => Yii::t('labels', 'Is Removed'),
                );
        }

}
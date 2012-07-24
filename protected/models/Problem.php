<?php

/**
 * This is the model class for table "Problems".
 *
 * The followings are the available columns in table 'Problems':
 * @property string $id
 * @property string $title
 * @property string $authorId
 * @property string $shortDescription
 * @property string $description
 * @property integer $privacyLevel
 * @property string $createdDate
 * @property string $modifiedDate
 *
 * The followings are the available model relations:
 * @property Users $author
 */
class Problem extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Problem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Problems';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, authorId, createdDate', 'required'),
			array('privacyLevel', 'numerical', 'integerOnly'=>true),
			array('authorId', 'length', 'max'=>20),
			array('shortDescription, description, modifiedDate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, authorId, shortDescription, description, privacyLevel, createdDate, modifiedDate', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'author' => array(self::BELONGS_TO, 'Users', 'authorId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'authorId' => 'Author',
			'shortDescription' => 'Short Description',
			'description' => 'Description',
			'privacyLevel' => 'Privacy Level',
			'createdDate' => 'Created Date',
			'modifiedDate' => 'Modified Date',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('authorId',$this->authorId,true);
		$criteria->compare('shortDescription',$this->shortDescription,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('privacyLevel',$this->privacyLevel);
		$criteria->compare('createdDate',$this->createdDate,true);
		$criteria->compare('modifiedDate',$this->modifiedDate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
<?php

/**
 * This is the model class for table "Submissions".
 *
 * The followings are the available columns in table 'Submissions':
 * @property string $id submission's id
 * @property string $problemId target problem of the submission
 * @property string $submitterId the submitter id
 * @property string $content JSON input of the submitter
 * @property string $submittedTime the time submission received
 * @property string $gradeTime last time the submission graded
 * @property integer $gradeStatus grading status. 3 completed, 2 grading, 1 in queue, 0 submitted.
 * @property string $gradeResult JSON result of the submission
 * @property string $file submission's file used for output only // can we put it as part of JSON input?
 * @property integer $context what context the submission for
 * @property integer $contextId id of the context
 *
 * The followings are the available model relations:
 * @property Users $problem
 */
class Submission extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Submission the static model class
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
		return 'Submissions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('problemId, submitterId, content', 'required'),
			array('gradeStatus, context, contextId', 'numerical', 'integerOnly'=>true),
			array('problemId, submitterId', 'length', 'max'=>20),
			array('gradeTime, gradeResult, file', 'safe'),
			// The following rule is used by search().
			array('id, problemId, submitterId, submittedTime, gradeTime, gradeStatus, context, contextId', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'submitter' => array(self::BELONGS_TO, 'User', 'problemId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('labels','ID'),
			'problemId' => Yii::t('labels','Problem'),
			'submitterId' => Yii::t('labels','Submitter'),
			'content' => Yii::t('labels','Content'),
			'submittedTime' => Yii::t('labels','Submitted Time'),
			'gradeTime' => Yii::t('labels','Grade Time'),
			'gradeStatus' => Yii::t('labels','Grade Status'),
			'gradeResult' => Yii::t('labels','Grade Result'),
			'file' => Yii::t('labels','File'),
			'context' => Yii::t('labels','Context Type'),
			'contextId' => Yii::t('labels','Context ID'),
		);
	}

}
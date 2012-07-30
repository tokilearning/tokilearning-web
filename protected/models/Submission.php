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
			// Please remove those attributes that should not be searched.
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
			'id' => 'ID',
			'problemId' => 'Problem',
			'submitterId' => 'Submitter',
			'content' => 'Content',
			'submittedTime' => 'Submitted Time',
			'gradeTime' => 'Grade Time',
			'gradeStatus' => 'Grade Status',
			'gradeResult' => 'Grade Result',
			'file' => 'File',
			'context' => 'Context Type',
			'contextId' => 'Context ID',
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
		$criteria->compare('problemId',$this->problemId,true);
		$criteria->compare('submitterId',$this->submitterId,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('submittedTime',$this->submittedTime,true);
		$criteria->compare('gradeTime',$this->gradeTime,true);
		$criteria->compare('gradeStatus',$this->gradeStatus);
		$criteria->compare('gradeResult',$this->gradeResult,true);
		$criteria->compare('file',$this->file,true);
		$criteria->compare('context',$this->context);
		$criteria->compare('contextId',$this->contextId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
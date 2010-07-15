<?php
/**
 *
 */
class Announcement extends CActiveRecord {
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function getStatus(){
        $strings = array(
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_PUBLISHED => 'Published'
        );
        return $strings[$this->status];
    }

    public function tableName() {
        return '{{announcements}}';
    }

    public function relations(){
        return array(
            'author' => array(self::BELONGS_TO, 'User', 'author_id')
        );
    }

    public function rules(){
        return array(
            array('title, content, status', 'required'),
        );
    }

    public function safeAttributes(){
        return array(
            'update'=>'title, status, content',
        );
    }

    public function scopes(){
        return array(
            'published' => array(
                'condition' => 'status='.self::STATUS_PUBLISHED
            )
        );
    }

    public function defaultScope(){
        return array('order'=>'created_date DESC',);
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'title' => 'Judul',
            'author_id' => 'Author'
        );
    }

    public function beforeSave(){
        if ($this->isNewRecord) {
            $this->created_date = new CDbExpression('NOW()');
        }
        return parent::beforeSave();
    }

    public function isPublished(){
        return $this->status == self::STATUS_PUBLISHED;
    }

    public function unpublish(){
        $this->status = self::STATUS_DRAFT;
        return $this;
    }

    public function publish(){
        $this->status = self::STATUS_PUBLISHED;
        return $this;
    }
}
//end of file
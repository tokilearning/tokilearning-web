<?php
/**
 *
 */
class Training extends CActiveRecord {

    const STATUS_CLOSED = 0;
    const STATUS_OPEN = 1;

    private $_chapters;

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{trainings}}';
    }

    public function relations(){
        return array(
            'creator' => array(self::BELONGS_TO, 'User', 'creator_id'),
            'first_chapter' => array(self::BELONGS_TO, 'Chapter', 'first_chapter_id')
            //firstChapter
        );
    }

    public function rules() {
        return array(
            array('name, description', 'required'),
            array('first_chapter_id' , 'safe', 'on' => 'update'),
            array('status' , 'safe', 'on' => 'update')
        );
    }

    public function defaultScope() {
        return array('order' => 'created_time DESC');
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Nama',
            'created_time' => 'Dibuat',
            'creator_id' => 'Pembuat',
            'first_chapter_id' => 'Bab Pertama'
        );
    }

    public function getChapters(){
        if (!isset($this->_chapters) && $this->first_chapter_id != NULL){
            //get first chapter
            $chapter = $this->first_chapter;
            $this->_chapters = array();
            //do chain iteration
            while ($chapter != NULL) {
                //echo $chapter->id . "<br />";
                $this->_chapters[] = $chapter;
                $chapter = $chapter->nextChapter;
            }
        }
        return $this->_chapters;
    }

    public function beforeSave(){
        if ($this->isNewRecord) {
            $this->created_time = new CDbExpression('NOW()');
        }
        return parent::beforeSave();
    }

    /**
     *
     * @param Chapter $chapter
     * @return boolean whether the training has the chapter as its child
     */
    public function hasChapter($chapter){
        return true;
    }

    /**
     *
     * @param Chapter $chapter
     * @return boolean whether the training has the chapter in the tree
     */
    public function hasChapterRecursive($chapter){
        return true;
    }
}
//end of file
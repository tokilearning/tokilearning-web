<?php

class MultiplesourceArchive extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{multiplesourcearchives}}';
    }

    public function relations() {
        return array(
            'submission' => array(self::BELONGS_TO, 'Submission', 'submission_id')
        );
    }

    public function extract($pDir = "") {
        $zipfile = "/tmp/".$this->submission->submitter_id."-".$this->submission->id.".zip";
        $handle = fopen($zipfile , "w");
        fclose($handle);
        file_put_contents($zipfile, $this->file);

        if ($pDir == "")
            $pDir = "/tmp/".time()."-".$this->submission->submitter_id."-".$this->submission->id;

        $extractdir = $pDir;
        $retval = false;

        $ar = new ZipArchive;
        if ($ar->open($zipfile)) {
            if ($ar->extractTo($extractdir))
                $retval = $extractdir;
            else
                $retval = false;
        }

        unlink($zipfile);
        return $retval;
    }

    public static function listFiles($pDir) {
        $retval = array();
        $handle = opendir($pDir);
        while (false !== ($file = readdir($handle))) {
            if ($file != '.' && $file != '..')
                $retval[] = $pDir . "/" . $file;
        }
        closedir($handle);
        return $retval;
    }

    /*public function rules(){
        return array(
            array('title, content, status', 'required'),
        );
    }*/
}

?>

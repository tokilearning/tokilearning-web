<?php

/**
 * 
 */
class Problem extends CActiveRecord {
    const VISIBILITY_DRAFT = 0;
    const VISIBILITY_PUBLIC = 1;
    const VISIBILITY_PRIVATE = 2;

    private static $problemRepositoryPath;
    public $configurationFilePath;
    public $directoryPath;
    public $viewPath;
    public $descriptionPath;
    private $_config;

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public static function getVisibilityStrings(){
        return array(
            self::VISIBILITY_DRAFT => 'Draft',
            self::VISIBILITY_PRIVATE => 'Private',
            self::VISIBILITY_PUBLIC => 'Public'
        );
    }

    public function tableName() {
        return '{{problems}}';
    }

    public function relations(){
        return array(
            'author' => array(self::BELONGS_TO, 'User', 'author_id'),
            'problemtype' => array(self::BELONGS_TO, 'ProblemType', 'problem_type_id'),
        );
    }

    public function rules(){
        return array(
            array('title, problem_type_id, visibility, description', 'required'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'title' => 'Judul',
            'description' => 'Komentar',
            'problem_type_id' => 'Tipe Soal',
            'author_id' => 'Author'
        );
    }

    public function defaultScope(){
        return array('order'=>'created_date DESC');
    }

    public function beforeSave(){
        if ($this->isNewRecord) {
            $this->created_date = new CDbExpression('NOW()');
            $this->modified_date = new CDbExpression('NOW()');
            $this->token = $this->generateToken();
            $this->createProblemDirectory();
        } else {
            $this->modified_date = new CDbExpression('NOW()');
        }
        $configs = CJSON::encode($this->_config);
        file_put_contents($this->getConfigurationFilePath(), $configs);
        return parent::beforeSave();
    }

    public function afterFind(){
        //echo $this->getConfigurationFilePath();
        $config_content = file_get_contents($this->getConfigurationFilePath());
        $this->_config = CJSON::decode($config_content);
        return parent::afterFind();
    }

    public function afterDelete(){
        $problem_directory = $this->getDirectoryPath();
        $this->rmdirRecurse($problem_directory);
        rmdir($problem_directory);
        return parent::afterDelete();
    }

    public function getVisibility(){
        $visibility = self::getVisibilityStrings();
        return $visibility[$this->visibility];
    }

    public function generateToken(){
        $exists = false;
        $token = '';
        do {
            $token = CTextHelper::random('alnum', 32);
            $token = strtoupper($token);
            //TODO
            $exists = (self::model()->exists("token = '$token'"));
            //$exists = (bool) ORM::factory('problem')->where('token', $token)->count_all();
        } while($exists);
        return $token;
    }

    public function init(){
        self::$problemRepositoryPath = Yii::app()->params->config['evaluator']['problem']['problem_repository_path']."/";
    }

    /**
     * 
     */

    public function createProblemDirectory(){
        $directory_path = $this->getDirectoryPath();
        if (!file_exists($directory_path)){
            mkdir($directory_path, 0777);
        }else if (!is_dir($directory_path)){
            ulink($directory_path);
        }
        mkdir($directory_path . 'evaluator/', 0777);
        mkdir($directory_path . 'evaluator/files/', 0777);
        mkdir($directory_path . 'view/', 0777);
        mkdir($directory_path . 'view/files/', 0777);
        //
        copy($this->problemtype->getViewDirectoryPath().'description.html', $directory_path.'view/description.html');
        
    }

    public function checkDirectory($path){
        if (!file_exists($path)){
            mkdir($path, 0777);
        }else if (!is_dir($path)){
            unlink($path);
            mkdir($path, 0777);
        }
        return $path;
    }

    public function getDirectoryPath(){
        return $this->checkDirectory(self::$problemRepositoryPath . $this->token . '/');
    }

    public function getEvaluatorPath(){
        return $this->checkDirectory($this->getDirectoryPath().'evaluator'.'/');
    }

    public function getEvaluatorFile($filename){
        $filename = $this->getEvaluatorPath().'files/'.$filename;
        if (file_exists($filename)){
            return $filename;
        }else{
            return NULL;
        }
    }

    public function deleteEvaluatorFile($filename){
        $filename = $this->getEvaluatorPath().'files/'.$filename;
        unlink($filename);
    }

    public function getEvaluatorFileList($noindex = true){
        $path = $this->getEvaluatorPath()."/files";
        $ar_file = array();
        $ff = array();
        if(is_dir($path)){
            $dh = opendir($path);
            while (($file = readdir($dh)) !== false) {
                $absolutepath = $path."/".$file;
                if (filetype($absolutepath) == 'file'){
                    if (!$noindex){
                        $ff[] = $file;
                        $ar_file[$file] = array (
                                'name' => $file,
                                'path' => $absolutepath,
                                'size' => filesize($absolutepath),
                                'modified' => filemtime($absolutepath),
                        );
                    } else {
                        $ar_file[] = array (
                                'name' => $file,
                                'path' => $absolutepath,
                                'size' => filesize($absolutepath),
                                'modified' => filemtime($absolutepath),
                        );
                    }
                }
            }
            closedir($dh);
        }
        if (!$noindex){
            $ar_file2 = array();
            sort($ff);
            foreach($ff as $ff1)
            {
                $ar_file2[$ff1] = array(
                    'name' => $ar_file[$ff1]['name'],
                    'path' => $ar_file[$ff1]['path'],
                    'size' => $ar_file[$ff1]['size'],
                );
            }
            return $ar_file2;
        } else {
            return $ar_file;
        }
    }

    public function getDescriptionPath(){
        $filepath = $this->getViewPath().'description.html';
        if (file_exists($filepath) && !is_file($filepath)){
            if (is_dir($filepath)){
                $this->rmdirRecurse($filepath);
                rmdir($filepath);
            } else {
                unlink($filepath);
            }
        }
        if (!file_exists($filepath)){
            copy($this->problemtype->getViewDirectoryPath().'description.html', $filepath);
        }
        return $filepath;
    }

    public function getViewPath(){
        return $this->checkDirectory($this->getDirectoryPath().'view'.'/');
    }

    public function deleteViewFile($filename){
        $filename = $this->getViewPath().'files/'.$filename;
        unlink($filename);
    }

    public function getViewFileList($noindex = true){
        $path = $this->getViewPath()."/files";
        $ar_file = array();
        $ff = array();
        if(is_dir($path)){
            $dh = opendir($path);
            while (($file = readdir($dh)) !== false) {
                $absolutepath = $path."/".$file;
                if (filetype($absolutepath) == 'file'){
                    if (!$noindex){
                        $ff[] = $file;
                        $ar_file[$file] = array (
                                'name' => $file,
                                'path' => $absolutepath,
                                'size' => filesize($absolutepath),
                                'modified' => filemtime($absolutepath),
                        );
                    } else {
                        $ar_file[] = array (
                                'name' => $file,
                                'path' => $absolutepath,
                                'size' => filesize($absolutepath),
                                'modified' => filemtime($absolutepath),
                        );
                    }
                }
            }
            closedir($dh);
        }
        if (!$noindex){
            $ar_file2 = array();
            sort($ff);
            foreach($ff as $ff1)
            {
                $ar_file2[$ff1] = array(
                    'name' => $ar_file[$ff1]['name'],
                    'path' => $ar_file[$ff1]['path'],
                    'size' => $ar_file[$ff1]['size'],
                );
            }
            return $ar_file2;
        } else {
            return $ar_file;
        }
    }

    public function getConfigurationFilePath(){
        $filepath = $this->getEvaluatorPath().'config.json';
        if (file_exists($filepath) && !is_file($filepath)){
            if (is_dir($filepath)){
                $this->rmdirRecurse($filepath);
                rmdir($filepath);
            } else {
                unlink($filepath);
            }
        }
        if (!file_exists($filepath)){
            $configs = $this->problemtype->getConfigs();
            $strconfigs = CJSON::encode($configs);
            file_put_contents($filepath, $strconfigs);
        }
        return $filepath;
    }

    public function getConfig($name){
        $var = $this->_config[$name];
        if (isset($var)) {
            return $var;
        } else {
            return null;
        }
    }

    public function setConfig($name, $value){
        $this->_config[$name] = $value;
    }

    public function getConfigs(){
        return $this->_config;
    }

    public function setConfigs($configs){
        $this->_config = $configs;
    }

    private function rmdirRecurse($path){
        $path= rtrim($path, '/').'/';
        $handle = opendir($path);
        for (;false !== ($file = readdir($handle));)
        if($file != "." and $file != ".." ){
            $fullpath= $path.$file;
            if(is_dir($fullpath)){
                $this->rmdirRecurse($fullpath);
                rmdir($fullpath);
            } else {
                unlink($fullpath);
            }
        }
        closedir($handle);
    }
}
//end of file
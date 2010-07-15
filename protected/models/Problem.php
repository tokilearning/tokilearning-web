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
    public $availableLanguages;
    private $_config;

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public static function getVisibilityStrings() {
        return array(
            self::VISIBILITY_DRAFT => 'Draft',
            self::VISIBILITY_PRIVATE => 'Private',
            self::VISIBILITY_PUBLIC => 'Public'
        );
    }

    public function tableName() {
        return '{{problems}}';
    }

    public function relations() {
        return array(
            'author' => array(self::BELONGS_TO, 'User', 'author_id'),
            'problemtype' => array(self::BELONGS_TO, 'ProblemType', 'problem_type_id'),
            'privileged_users' => array(self::MANY_MANY , 'User' , 'problem_privileges(problem_id , user_id)'),
            'arenas' => array(self::MANY_MANY , 'Arena' , 'arenas_problems(problem_id , arena_id)')
        );
    }

    public function rules() {
        return array(
            array('title, problem_type_id, visibility, description, availableLanguages', 'required'),
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

    public function scopes() {
        return array(
            'public' => array(
                'condition' => 'visibility = ' . self::VISIBILITY_PUBLIC
            ),
            'simplebatch' => array(
                'condition' => 'problem_type_id = 1'
            )
        );
    }

    public function defaultScope() {
        return array('order' => 'created_date DESC');
    }

    public function isPrivileged($pUser) {
        if ($this->visibility == self::VISIBILITY_PUBLIC)
            return true;
        
        if ($this->isOwner($pUser))
            return true;

        ///Check arenas
        $privileged = false;
        foreach ($this->arenas as $arena) {
            if ($arena->isMember($pUser))
                $privileged = true;
        }

        $sql = "SELECT user_id FROM problem_privileges WHERE problem_id = " . $this->id . " AND user_id = " . $pUser->id . ";";
        $command = $this->dbConnection->createCommand($sql);
        $result = $command->query();
        return $result->rowCount > 0 || $privileged;
    }

    public function isOwner($pUser) {
        return Group::checkMember("administrator", $pUser) || $this->author->id == $pUser->id;
    }

    public function addArena($pArena) {
        $this->removeArena($pArena);
        $sql = "INSERT INTO arenas_problems (problem_id, arena_id) VALUES (" . $this->id . ", " . $pArena->id . ");";
        $command = $this->dbConnection->createCommand($sql);
        $command->execute();
    }

    public function removeArena($pArena) {
        $sql = "DELETE FROM arenas_problems WHERE problem_id = " . $this->id . " AND arena_id = " . $pArena->id . ";";
        $command = $this->dbConnection->createCommand($sql);
        $command->execute();
    }

    public function grantPrivilege($pUser) {
        $this->revokePrivilege($pUser);
        $sql = "INSERT INTO problem_privileges (problem_id, user_id) VALUES (" . $this->id . ", " . $pUser->id . ");";
        $command = $this->dbConnection->createCommand($sql);
        $command->execute();
    }

    public function revokePrivilege($pUser) {
        $sql = "DELETE FROM problem_privileges WHERE problem_id = " . $this->id . " AND user_id = " . $pUser->id . ";";
        $command = $this->dbConnection->createCommand($sql);
        $command->execute();
    }
    
    public function generateChecksum() {
        $retval = array();
        $retval['config.json'] = md5_file($this->getConfigurationFilePath());     
    
        return array_merge($retval , $this->generateChecksumRec("evaluator/files"));
    }
    
    public function generateChecksumRec($path) {
        $retval = array();
        $dir = opendir($this->getDirectoryPath() . "/" . $path);
        $retval[$path] = '.';
        
        while (($file = readdir($dir)) !== false) {
            $apath = realpath($this->getDirectoryPath() . "/" . $path . "/" . $file);        
        
            if (!is_dir($apath)) {
                //echo $file . "\n";
                $retval[$path . "/" . $file] = md5_file($apath);
            }
            else if ($file != '.' && $file != '..') {
                $retval = array_merge($retval , $this->generateChecksumRec($path . "/" . $file));
            }
        }        
          
        closedir($dir);
        return $retval;
    }

    public function beforeSave() {
        if ($this->isNewRecord) {
            $this->created_date = new CDbExpression('NOW()');
            $this->modified_date = new CDbExpression('NOW()');
            $this->token = $this->generateToken();
            $this->createProblemDirectory();
            //Initialize
            Yii::import('ext.evaluator.ProblemTypeHandler');
            $handler = ProblemTypeHandler::getHandler($this);
            $handler->initializeProblem($this);
        } else {
            $this->modified_date = new CDbExpression('NOW()');
            $configs = CJSON::encode($this->_config);
            file_put_contents($this->getConfigurationFilePath(), $configs);
        }

        if (count($this->availableLanguages) == 0)
            $this->availableLanguages = array("c" , "cpp" , "pas");

        $this->available_languages = CJSON::encode($this->availableLanguages);
        return parent::beforeSave();
    }

    public function afterFind() {
        //echo $this->getConfigurationFilePath();
        $config_content = file_get_contents($this->getConfigurationFilePath());
        $this->_config = CJSON::decode($config_content);
        $this->availableLanguages = CJSON::decode($this->available_languages);
        return parent::afterFind();
    }

    public function afterDelete() {
        $problem_directory = $this->getDirectoryPath();
        $this->rmdirRecurse($problem_directory);
        rmdir($problem_directory);
        return parent::afterDelete();
    }

    public function getVisibility() {
        $visibility = self::getVisibilityStrings();
        return $visibility[$this->visibility];
    }

    public function generateToken() {
        $exists = false;
        $token = '';
        do {
            $token = CTextHelper::random('alnum', 32);
            $token = strtoupper($token);
            //TODO
            $exists = (self::model()->exists("token = '$token'"));
            //$exists = (bool) ORM::factory('problem')->where('token', $token)->count_all();
        } while ($exists);
        return $token;
    }

    public function init() {
        self::$problemRepositoryPath = Yii::app()->params->config['evaluator']['problem']['problem_repository_path'] . "/";
    }

    /**
     * 
     */
    public function createProblemDirectory() {
        $directory_path = $this->getDirectoryPath();
        if (!file_exists($directory_path)) {
            mkdir($directory_path, 0777);
        } else if (!is_dir($directory_path)) {
            ulink($directory_path);
        }
    }

    public function checkDirectory($path) {
        if (!file_exists($path)) {
            mkdir($path, 0777);
        } else if (!is_dir($path)) {
            unlink($path);
            mkdir($path, 0777);
        }
        return $path;
    }

    public function isProblemDirectoryExists() {
        return file_exists(self::$problemRepositoryPath . $this->token . '/');
    }

    public function getDirectoryPath() {
        $path = $this->checkDirectory(self::$problemRepositoryPath . $this->token . '/');
        return realpath($path) . DIRECTORY_SEPARATOR;
    }

    public function getFile($filename) {
        $filename = realpath($this->getDirectoryPath() . $filename);
        if (file_exists($filename) && (strpos($filename, $this->getDirectoryPath()) !== false)) {
            return $filename;
        } else {
            return NULL;
        }
    }

    public function deleteFile($filename) {
        $filename = realpath($this->getDirectoryPath() . $filename);
        if (file_exists($filename) && (strpos($filename, $this->getDirectoryPath()) !== false)) {
            if (is_dir($filename)) {
                self::rmdirRecurse($filename);
            } else {
                unlink($filename);
            }
        }
    }

    public function getFileList($dirname, $noindex = true) {
        $dirpath = $this->getDirectoryPath();
        $path = realpath($dirpath . $dirname);

        $ar_file = array();
        $ff = array();
        if (is_dir($path)) {
            $dh = opendir($path);
            while (($file = readdir($dh)) !== false) {
                $absolutepath = $path . "/" . $file;
                if (filetype($absolutepath) == 'file') {
                    if (!$noindex) {
                        $ff[] = $file;
                        $ar_file[$file] = array(
                            'name' => $file,
                            'path' => $absolutepath,
                            'size' => filesize($absolutepath),
                            'modified' => filemtime($absolutepath),
                        );
                    } else {
                        $ar_file[] = array(
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
        if (!$noindex) {
            $ar_file2 = array();
            sort($ff);
            foreach ($ff as $ff1) {
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

    public function getConfigurationFilePath() {
        $filepath = $this->getDirectoryPath() . 'config.json';
        if (file_exists($filepath) && !is_file($filepath)) {
            if (is_dir($filepath)) {
                $this->rmdirRecurse($filepath);
                rmdir($filepath);
            } else {
                unlink($filepath);
            }
        }
        if (!file_exists($filepath)) {
            $strconfigs = CJSON::encode($this->_config);
            file_put_contents($filepath, $strconfigs);
        }
        return $filepath;
    }

    public function getConfig($name) {
        $var = $this->_config[$name];
        if (isset($var)) {
            return $var;
        } else {
            return null;
        }
    }

    public function setConfig($name, $value) {
        $this->_config[$name] = $value;
    }

    public function getConfigs() {
        return $this->_config;
    }

    public function setConfigs($configs) {
        $this->_config = $configs;
    }

    private function rmdirRecurse($path) {
        $path = rtrim($path, '/') . '/';
        $handle = opendir($path);
        for (; false !== ($file = readdir($handle));)
            if ($file != "." and $file != "..") {
                $fullpath = $path . $file;
                if (is_dir($fullpath)) {
                    $this->rmdirRecurse($fullpath);
                    rmdir($fullpath);
                } else {
                    unlink($fullpath);
                }
            }
        closedir($handle);
    }
    
    public static function exportProblem($pProblems , &$output , $target = "") {
        if ($target == "")
            $target = tempnam("/tmp", "lx-export-") . ".zip";
        
        $execstring = "zip -r $target ";
        
        foreach ($pProblems as $problem) {
            $execstring .= $problem->getDirectoryPath() . " ";
        }
        
        exec($execstring , $output);
        
        $output = implode("\n", $output) . "\n";
        
        return $target;
    }

    public function getProblemTypeClass() {
        Yii::import('ext.evaluators.ProblemTypeFactory');
    }

}

//end of file

<?php

class FileController extends CSupervisorController {

    public $pageTitle = "File Manager";
    private $publicPath = '';
    private $publicUrl = '';

    public function init() {
        parent::init();
        $this->publicPath = realpath(Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "public");
        $this->publicUrl = Yii::app()->createAbsoluteUrl("/public");
    }

    public function actionIndex() {
        $currentpath = ((!isset($_GET['path'])) ? '.' : $_GET['path']);
        $path = $this->getFileRealPath($currentpath);
        $arfiles = $this->createFileList($path);
        $dataProvider = new CArrayDataProvider($arfiles, array(
                    'id' => 'name',
                    'sort' => array(
                        'attributes' => array('type', 'name')
                    ),
                    'pagination' => array(
                        'pageSize' => 10
                    ),
                ));
        $pathlist = $this->createFilePathList($path);
        $this->render('index', array(
            'dataProvider' => $dataProvider,
            'pathlist' => $pathlist,
            'currentpath' => $currentpath
        ));
    }

    public function actionDownload() {
        ob_clean();
        $path = $this->getFileRealPath(((!isset($_GET['path'])) ? '.' : $_GET['path']));
        if (filetype($path) == 'file') {
            header('Content-type: ' . CFileHelper::getMimeType($path));
            header('Content-Disposition: attachment; filename="' . basename($path) . '"');
            readfile($path);
            exit;
        } else {
            throw new CHttpException(404, "File not found");
        }
    }

    public function actionUpload() {
        $currentpath = ((!isset($_GET['path'])) ? '.' : $_GET['path']);
        $path = $this->getFileRealPath($currentpath);
        if (filetype($path) == 'dir') {
            $tmp_path = $_FILES['file']['tmp_name'];
            $new_path = $path . DIRECTORY_SEPARATOR . $_FILES['file']['name'];
            move_uploaded_file($tmp_path, $new_path);
            $this->redirect($this->createUrl('index') . "?path=" . $currentpath);
        } else {
            throw new CHttpException(404, "Folder not found");
        }
    }

    public function actionMakedir() {
        $currentpath = ((!isset($_GET['path'])) ? '.' : $_GET['path']);
        $foldername = $_POST['foldername'];
        $folderpath = $this->getFileRealPath($currentpath);
        $folderpath = $folderpath . DIRECTORY_SEPARATOR . $foldername;
        if (!file_exists($folderpath) && mkdir($folderpath)) {
            file_put_contents($folderpath . DIRECTORY_SEPARATOR . "index.html", '');
        }
        $this->redirect($this->createUrl('index') . "?path=" . $currentpath);
    }

    private function getFileRealPath($path, $check = true) {
        $newpath = realpath($this->publicPath . DIRECTORY_SEPARATOR . $path);
        if ((strlen($newpath) === 0) && $check) {
            throw new CHttpException(404, "Folder/File not found");
        } else if (strpos($newpath, $this->publicPath) === false) {
            throw new CHttpException(403, "Unathorized access");
        }
        return $newpath;
    }

    /**
     * Creating breadcrumb
     * @param string $path
     */
    private function createFilePathList($path) {
        $realpath = $path;
        $relativepath = str_replace($this->publicPath, '', $realpath);
        $relativepath = str_replace("\\", "/", $relativepath);
        $arpath = explode("/", $relativepath);
        $i = 0;
        $result = array();
        foreach ($arpath as $p) {
            $result[$i] = array(
                'name' => $p,
                'display' => $p,
                'fullpath' => ((isset($result[$i - 1])) ? $result[$i - 1]['fullpath'] . '/' . $p : '.'),
            );
            $i++;
        }
        $result[0]['display'] = $this->publicPath;
        return $result;
    }

    private function createFileList($path) {
        $realpath = $path;
        $ar_files = array();
        if (is_dir($realpath)) {
            $dh = opendir($realpath);
            while (($file = readdir($dh)) !== false) {
                if (($file == '.') || ($file == '.svn') || ($file == '..' && ($realpath == $this->publicPath)) || ($file == '.htaccess'))
                    continue;
                $absolutepath = $realpath . DIRECTORY_SEPARATOR . $file;
                $relativepath = str_replace($this->publicPath, '', $absolutepath);
                $relativepath = str_replace("\\", "/", $relativepath);
                $relativepath = substr($relativepath, 1);
                if (filetype($absolutepath) == 'file') {
                    $ar_file[] = array(
                        'name' => $file,
                        'type' => 'file',
                        'path' => $relativepath,
                        'size' => filesize($absolutepath),
                        'modified' => date("D d M Y H:i", filemtime($absolutepath)),
                    );
                } else if (filetype($absolutepath) == 'dir') {
                    $ar_file[] = array(
                        'name' => $file,
                        'type' => 'dir',
                        'path' => $relativepath,
                        'size' => filesize($absolutepath),
                        'modified' => date("D d M Y H:i", filemtime($absolutepath)),
                    );
                }
            }
            closedir($dh);
        } else {
            throw new CHttpException(404, "Folder not found");
        }
        return $ar_file;
    }

}
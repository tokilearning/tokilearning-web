<?php


class MultiplesourceProblemUpdateWidget extends CWidget {

    public $problem;

    public function run(){
        $assetpath = dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'assets';
        $assets = Yii::app()->getAssetManager()->publish($assetpath, false, -1, true);
        $cs = Yii::app()->getClientScript()->registerScriptFile($assets.'/style.css');
        $action = isset($_GET['action']) ? $_GET['action'] : '' ;
        switch($action){
            case 'display':
                $this->updateDisplay();
                break;
            case 'configuration' :
                $this->updateConfiguration();
                break;
            case 'files' :
                $this->updateFiles();
                break;
	    case 'zipupload' :
                $this->uploadZipTC();
                break;
            case 'renderviewfile' :
                $this->renderViewFile();
                break;
        }

        $this->render('problemupdate', 
                    array(
                        'problem' => $this->problem,
                        'action' => $_GET['action'],
                        'assets' => $assets,
                        )
        );
    }

    private function uploadZipTC() {
	$folderpath = $this->problem->getDirectoryPath() . 'evaluator/files';
	$tmp_name = $_FILES['file']['tmp_name'];
	$zip = new ZipArchive;
	$arfiles = array();
	$testcases = array();
	if ($zip->open($tmp_name)) {
	    for ($i = 0; $i < $zip->numFiles; $i++) {
		$entry = $zip->statIndex($i);
		$name = $entry['name'];
		//assume only one dot
		$rname = explode('.', $name);
		if (count($rname) == 2) {
		    $pname = $rname[0];
		    $ename = $rname[1];
		    if (strpos($pname, DIRECTORY_SEPARATOR) === false) { //assume no directory
			if (!isset($arfiles[$pname]))
			    $arfiles[$pname] = 0;
			$arfiles[$pname] += ( $ename == 'in') ? 1 : (($ename == 'out') ? 1 : 0);
			if ($arfiles[$pname] == 1) {
			    $testcases[] = array(
				'input' => $pname . '.in'/*,
				'output' => $pname . '.out'*/
			    );
			}
		    }
		}
	    }
	    $origtestcases = $this->problem->getConfig('testcases');
	    $testcases = array_merge($origtestcases, $testcases);
	    if ($zip->extractTo($folderpath)) {
		uasort($testcases, 'Reactive1ProblemUpdateWidget::compare');
		$this->problem->setConfig('testcases', $testcases);
		$this->problem->save();
		foreach($testcases as $testcase){
		    exec(sprintf("/usr/bin/dos2unix %s", $this->problem->getDirectoryPath().'evaluator/files/'.$testcase['input']));
		    exec(sprintf("/usr/bin/dos2unix %s", $this->problem->getDirectoryPath().'evaluator/files/'.$testcase['output']));
		}
	    }
	    $zip->close();
	}
    }

    private static function compare($a , $b) {
        //return $a['input'] < $b['input'];
        $name_1 = $a['input']; $numcode_1 = preg_replace('/[^0-9]/' , '' , $name_1);
        $name_2 = $b['input']; $numcode_2 = preg_replace('/[^0-9]/' , '' , $name_2);
        return $numcode_1 > $numcode_2;
    }

    private function updateDisplay(){
        if (isset($_POST['descriptionfile'])){
            file_put_contents($this->problem->getFile('view/description.html'), $_POST['descriptionfile']);
        }
    }

    private function updateConfiguration(){
        if (isset($_POST['config'])){
            $config = $_POST['config'];
            $this->problem->setConfig('time_limit', $config['time_limit']);
            $this->problem->setConfig('memory_limit', $config['memory_limit']);
            $this->problem->setConfig('command_line', $config['command_line']);
			$this->problem->setConfig('checker_source', $config['checker_source']);
            $this->problem->setConfig('sample_contest', $config['sample_contest']);
            $testcases = array();
            if (isset($config['testcases']))
            {
                ksort(&$config['testcases']);
                foreach($config['testcases'] as $val)
                {
                    $testcases[] = $val;
                }
            }

			$batchpoints = array();
			if (isset($config['batchpoints']))
            {
                foreach($config['batchpoints'] as $key => $val)
                {
                    $batchpoints[$key] = $val;
                }
            }

            $this->problem->setConfig('testcases', $testcases);
			$this->problem->setConfig('batchpoints' , $batchpoints);
            $this->problem->save();
            return true;
        }
    }

    private function updateFiles(){
        $action2 = isset($_GET['action2'])?$_GET['action2']:'';
        switch($action2){
            case 'uploadviewfile' :
                if (isset($_FILES['viewfileupload'])){
                    $uploads_dir = $this->problem->getDirectoryPath().'view/files';
                    foreach ($_FILES["viewfileupload"]["error"] as $key => $error) {
                        if ($error == UPLOAD_ERR_OK) {
                            $tmp_name = $_FILES["viewfileupload"]["tmp_name"][$key];
                            $name = $_FILES["viewfileupload"]["name"][$key];
                            move_uploaded_file($tmp_name, "$uploads_dir/$name");
                        }
                    }
                    $this->problem->save();
                }
                break;
            case 'uploadevaluatorfile' :
                if (isset($_FILES['evaluatorfileupload'])){
                    $uploads_dir = $this->problem->getDirectoryPath().'evaluator/files';
                    foreach ($_FILES["evaluatorfileupload"]["error"] as $key => $error) {
                        if ($error == UPLOAD_ERR_OK) {
                            $tmp_name = $_FILES["evaluatorfileupload"]["tmp_name"][$key];
                            $name = $_FILES["evaluatorfileupload"]["name"][$key];
                            if ($_FILES["evaluatorfileupload"]["type"][$key] == 'application/zip') {
                                $this->uploadZip($_FILES["evaluatorfileupload"]["tmp_name"][$key]);
                            }
                            move_uploaded_file($tmp_name, "$uploads_dir/$name");
                            exec(sprintf("/usr/bin/dos2unix %s", $this->problem->getDirectoryPath()."evaluator/files/$name"));
                        }
                    }
                    $this->problem->save();
                }
                break;
            case 'deleteviewfile' :
                $filename = $_GET['filename'];
                $path = $this->problem->deleteFile('view/files/'.$filename);
                break;
            case 'deleteevaluatorfile' :
                $filename = $_GET['filename'];
                $path = $this->problem->deleteFile('evaluator/files/'.$filename);
                break;
            case 'downloadviewfile' :
                ob_clean();
                $filename = $_GET['filename'];
                $path = $this->problem->getFile('view/files/'.$filename);
                if ($path !== null){
                    header('Content-type: '.CFileHelper::getMimeType($path));
                    header('Content-Disposition: attachment; filename="'.$filename.'"');
                    readfile($path);
                    exit;
                } else {
                    throw new CHttpException(404, "File not found");
                }
                exit;
                break;
            case 'downloadevaluatorfile' :
                ob_clean();
                $filename = $_GET['filename'];
                $path = $this->problem->getFile('evaluator/files/'.$filename);
                if ($path !== null){
                    header('Content-type: '.CFileHelper::getMimeType($path));
                    header('Content-Disposition: attachment; filename="'.$filename.'"');
                    readfile($path);
                    exit;
                } else {
                    throw new CHttpException(404, "File not found");
                }
                exit;
                break;
        }
    }

    public function renderViewFile(){
        ob_clean();
        $filename = $_GET['filename'];
        $filepath = $this->problem->getFile('view/files/'.$filename);
        header('Content-Type: '.CFileHelper::getMimeType($filepath));
        header('Content-Length: '.filesize($filepath));
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        readfile($filepath);
        exit;
    }

    public function renderDescription(){
        $filepath = $this->problem->getFile('view/description.html');
        $pattern = "/\< *[img][^\>]*[src] *= *[\"\']{0,1}([^\"\'\ >]*)/";
        $contents =  file_get_contents($filepath);
        return $contents;
    }

    public function uploadZip($tmp_name) {
        //if ($_FILES['file']['type'] == 'application/zip') {
            $folderpath = $this->problem->getDirectoryPath() . 'evaluator/files';
            //$tmp_name = $file['tmp_name'];
            $zip = new ZipArchive;
            if ($zip->open($tmp_name)) {
                if ($zip->extractTo($folderpath)) {
                    /*$this->problem->setConfig('testcases', $testcases);
                    $this->problem->save();
                    foreach($testcases as $testcase){
                        exec(sprintf("/usr/bin/dos2unix %s", $this->problem->getDirectoryPath().'evaluator/files/'.$testcase['input']));
                        exec(sprintf("/usr/bin/dos2unix %s", $this->problem->getDirectoryPath().'evaluator/files/'.$testcase['output']));
                    }*/
                }
                $zip->close();
            }
        //}
    }
}

<?php


class BatchioiProblemViewWidget extends CWidget {

    public $problem;
    public $contest;
    public $chapter;
    public $submitter;
    public $submitLocked;
    public $submitLockedText;
    public $submitSuccessUrl;
    public $submitStatus = Submission::GRADE_STATUS_PENDING;
    public $submission;
    public $options = array();
    
    public function run(){
        $assetpath = dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'assets';
        $assets = Yii::app()->getAssetManager()->publish($assetpath, false, -1, true);
        $cs = Yii::app()->getClientScript()->registerScriptFile($assets.'/style.css');
        $action = isset($_GET['action']) ? $_GET['action'] : '' ;
        switch($action){
            case 'enlarge':
                $this->renderEnlarged();
                break;
            case 'renderviewfile' :
                $this->renderViewFile();
                break;
            case 'submit';
                $this->submitAnswer();
                break;
            default:
                break;
        }
        $this->render('problemview', array(
            'problem' => $this->problem,
            'assets' => $assets,
            'submission' => $this->submission,
            'action' => $action,
        ));
    }

    public function submitAnswer(){
        if (!$this->submitLocked) {
            if (isset($_POST['Submission'])){
                $this->submission = new Submission();
                $this->submission->submitter_id = $this->submitter->id;
                $this->submission->problem_id = $this->problem->id;
                $this->submission->contest_id = ($this->contest == null) ? null : $this->contest->id;
                $this->submission->chapter_id = ($this->chapter == null) ? null : $this->chapter->id;
                $this->submission->grade_status = $this->submitStatus;
                try {
                    if ($_FILES['Submission']['error']['submissionfile'] != UPLOAD_ERR_OK) throw new Exception("Upload failed");
                    $sourcefilename = $_FILES['Submission']['name']['submissionfile'];
                    $filetype = CSourceHelper::getSourceExtension($sourcefilename);
                    if ($filetype == null) throw new Exception("Unknown file type");
                    $filecontent = file_get_contents($_FILES['Submission']['tmp_name']['submissionfile']);
                    $this->submission->setSubmitContent('source_lang', $filetype);
                    $this->submission->setSubmitContent('original_name', $sourcefilename);
                    $this->submission->setSubmitContent('source_content', $filecontent);
                    $this->submission->save();
					if ($this->submission->contest !== null)
						$this->submission->contest->getContestTypeHandler()->afterSubmit($this->submission->contest , $this->submission);
                    $this->owner->redirect($this->submitSuccessUrl);
                } catch (Exception $ex) {
                    $this->submission->addError('answer', $ex->getMessage());
                }
            }
        }
    }

    public function renderDescription(){
        $filepath = $this->problem->getFile('view/description.html');
        $pattern = "/\< *[img][^\>]*[src] *= *[\"\']{0,1}([^\"\'\ >]*)/";
        $contents =  file_get_contents($filepath);
        return $contents;
    }

    public function renderEnlarged(){
        ob_clean();
        $this->owner->layout = 'application.views.layouts.column1';
        $this->owner->render('ext.evaluator.types.simplebatch.widgets.views.problemview.enlarged', array(
            'description' => $this->renderDescription()
        ));
        exit;
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
}
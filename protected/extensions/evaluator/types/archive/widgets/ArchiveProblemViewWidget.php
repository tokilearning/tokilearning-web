<?php

Yii::import("ext.evaluator.base.StandardProblemViewWidgetBase");

class ArchiveProblemViewWidget extends StandardProblemViewWidgetBase {

	public function submitAnswer() {
		if (!$this->submitLocked) {
			if (isset($_POST['Submission'])) {
				$this->submission = new Submission();
				$this->submission->submitter_id = $this->submitter->id;
				$this->submission->problem_id = $this->problem->id;
				$this->submission->contest_id = ($this->contest == null) ? null : $this->contest->id;
				$this->submission->chapter_id = ($this->chapter == null) ? null : $this->chapter->id;
				$this->submission->grade_status = $this->submitStatus;
				try {
					if ($_FILES['Submission']['error']['submissionfile'] != UPLOAD_ERR_OK)
						throw new Exception("Upload failed");
					$sourcefilename = $_FILES['Submission']['name']['submissionfile'];
					$filetype = CSourceHelper::getSourceExtension($sourcefilename);
					if ($filetype == null)
						throw new Exception("Unknown file type");
					else if ($filetype != 'zip')
						throw new Exception("Unacceptable file type");
					$filecontent = file_get_contents($_FILES['Submission']['tmp_name']['submissionfile']);
					$this->submission->setSubmitContent('source_lang', 'zip');
					$this->submission->setSubmitContent('original_name', $sourcefilename);
					$this->submission->file = $filecontent;
					$this->submission->save();
					if ($this->submission->contest !== null)
						$this->submission->contest->getContestTypeHandler()->afterSubmit($this->submission->contest, $this->submission);
					$this->owner->redirect($this->submitSuccessUrl);
				} catch (Exception $ex) {
					echo $ex->getMessage();
					$this->submission->addError('answer', $ex->getMessage());
				}
			}
		}
	}

}

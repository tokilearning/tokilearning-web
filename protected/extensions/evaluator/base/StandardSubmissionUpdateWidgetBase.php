<?php

Yii::import("ext.evaluator.base.ParameterizedWidget");

abstract class StandardSubmissionUpdateWidgetBase extends ParameterizedWidget {

	public $submission;

	public function run() {
		parent::run();

		$this->render('submissionupdate', array(
			'submission' => $this->submission,
		));
	}

	protected function processPost() {
		parent::processPost();
		if (isset($_POST['Submission'])) {
			$this->submission->setScenario('update');
			$this->submission->setAttributes($_POST['Submission']);
			$this->submission->save();
		}
	}

	protected function processAction() {
		if ($_GET['action'] == 'download') {
			$this->downloadSource();
		}
	}

	protected function getDownloadableContent() {
		return $this->submission->getSubmitContent('source_content');
	}

	protected function downloadSource() {
		ob_clean();

		$contest = Contest::model()->findByPk($this->submission->contest_id);
		$submitter = User::model()->findByPk($this->submission->submitter_id);

		header('Content-type: text/plain');
		header('Content-Disposition: attachment; filename="submission-' . $contest->name . '-' . $submitter->username . '-' . $this->submission->id . '.' . $this->submission->getSubmitContent('source_lang') . '"');
		echo $this->getDownloadableContent();
		exit;
	}

}

?>

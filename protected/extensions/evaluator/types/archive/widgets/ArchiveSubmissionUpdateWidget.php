<?php

Yii::import("ext.evaluator.base.StandardSubmissionUpdateWidgetBase");

class ArchiveSubmissionUpdateWidget extends StandardSubmissionUpdateWidgetBase {

	protected function getDownloadableContent() {
		return $this->submission->file;
	}

}

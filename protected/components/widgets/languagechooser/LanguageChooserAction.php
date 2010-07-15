<?php

/**
 * LanguageChooserAction sets language into the database.
 * 
 * @author Petra Barus <petra.barus@gmail.com>
 * @since 2011.11.04
 */
class LanguageChooserAction extends CAction {

	/**
	 * Runs the widget.
	 * @since 2011.11.04
	 */
	public function run() {
		$supportedLanguages = array_keys(LanguageChooser::getSupportedLanguages());
		if (isset($_POST['language']) && in_array($_POST['language'], $supportedLanguages)) {
			Yii::app()->user->setLanguage($_POST['language']);
		}
		echo json_encode(array(
		    'success' => true
		));
	}

}
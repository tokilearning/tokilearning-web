<?php

/**
 * Handles ajax requests to the widgets.
 */
class AjaxController extends CController {

	public function init() {
		parent::init();
		$this->importWidgets();
	}

	/**
	 * TODO: Refactor.
	 * @return array actions for this controllers.
	 */
	public function actions() {
		return array(
		    LanguageChooser::WIDGET_ACTION_PREFIX => 'application.components.widgets.languagechooser.LanguageChooser',
		);
	}

	/**
	 * Imports all widgets.
	 */
	private function importWidgets() {
		$imports = array(
		    'application.components.widgets.languagechooser.LanguageChooser',
		);
		foreach ($imports as $import)
			Yii::import($import);
	}

}
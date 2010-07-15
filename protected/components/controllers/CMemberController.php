<?php

class CMemberController extends CCommonController {
    public $layout = 'application.views.layouts.column2';

    /**
	 * @return array behavior of this controller.
	 */
	public function behaviors() {
		return array(
		    'application.components.widgets.languagechooser.LanguageChooserControllerBehavior',
		);
	}

    public function init() {
		//Load language
		$this->loadLanguage();
	}

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

}
<?php

/**
 * LanguageChooserControllerBehavior provides behavior for controller to change language.
 * This behavior is mainly intended for main controller.
 * 
 * @author Petra Barus <petra.barus@gmail.com>
 * @since 2011.11.04
 */
class LanguageChooserControllerBehavior extends CBehavior {

	/**
	 * Load language that will be used in the application for current user.
	 * @param string $language 
	 * @since 2011.11.04
	 */
	public function loadLanguage($language = NULL) {
		$app = Yii::app();
		$app->language = $app->user->getLanguage();
	}

}
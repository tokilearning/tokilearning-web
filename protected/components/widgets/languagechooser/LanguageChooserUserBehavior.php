<?php

/**
 * LanguageChooserUserBehavior provides behavior for user to change behavior.
 * This behavior is intended for WebUser.
 * @author Petra Barus <petra.barus@gmail.com>
 * @since 2011.11.02
 */
Yii::import('application.components.widgets.languagechooser.LanguageChooser');

class LanguageChooserUserBehavior extends CBehavior {
	/**
	 * Key for storing language.
	 * @since 2011.11.04
	 */
	const STATE_KEY_LANGUAGE = 'language';

	/**
	 * @since 2011.11.04
	 * @return string language for current user. Return Yii default language if no language set.
	 */
	public function getLanguage() {
		$defaultLanguage = Yii::app()->language;
		return $this->owner->getState(self::STATE_KEY_LANGUAGE, $defaultLanguage);
	}

	/**
	 * Sets language for current user.
	 * @param string $value language.
	 * @since 2011.11.04
	 */
	public function setLanguage($value) {
		$supportedLanguages = array_keys(LanguageChooser::getSupportedLanguages());
		if (in_array($value, $supportedLanguages)) {
			$this->owner->setState(self::STATE_KEY_LANGUAGE, $value);
		}
	}

}
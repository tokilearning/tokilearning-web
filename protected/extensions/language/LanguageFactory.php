<?php
Yii::import("ext.language.languages.*");

class LanguageFactory {
    private $mSupportedLanguages;

    public function __construct() {
        $this->mSupportedLanguages = require("language_list.php");
    }

    public function createLanguageFromName($name) {
        foreach ($this->mSupportedLanguages as $extension => $language) {
            if ($name == $extension)
                return new $language();
        }

        return NULL;
    }

    public function getSupportedLanguages() {
        return $this->mSupportedLanguages;
    }
}

?>

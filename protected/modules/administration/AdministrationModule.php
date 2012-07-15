<?php

/**
 * AdministrationModule handles all administrative functionality requires to
 * manage the application. 
 * 
 * @author Petra Barus <petra.barus@gmail.com>
 * @package administration
 */
class AdministrationModule extends CWebModule {

        /**
         * @var string url for assets.
         */
        private $_assetsUrl;

        /**
         * @var string the ID of the default controller for this module.
         */
        public $defaultController = 'dashboard';

        /**
         * Initializes the modules.
         * 
         * This method registers required models and components.
         */
        public function init() {
                $this->setImport(array(
                        'administration.models.*',
                        'administration.components.*',
                ));
        }

        /**
         * The pre-filter for controller actions.
         * This method is invoked before the currently requested controller action and all its filters
         * are executed.
         * 
         * @param CController $controller the controller
         * @param CAction $action the action
         * @return boolean whether the action should be executed.
         */
        public function beforeControllerAction($controller, $action) {
                if (parent::beforeControllerAction($controller, $action)) {

                        return true;
                }
                else
                        return false;
        }

        /**
         * @return string url for module's assets.
         */
        public function getAssetsUrl() {
                if ($this->_assetsUrl === null)
                        $this->_assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("{$this->id}.assets"));
                return $this->_assetsUrl;
        }

        /**
         * Sets url assets.
         * @param string $value assets url
         */
        public function setAssetsUrl($value) {
                $this->_assetsUrl = $value;
        }

        /**
         * @param string $file CSS filename
         * @return the url for the CSS file
         */
        public function getCssAssetsUrl($file) {
                return $this->assetsUrl . '/css/' . $file;
        }

        /**
         * Register CSS files in the module.
         * @param string $file the file.
         * @param string $media the media.
         */
        public function registerCssFile($file, $media = 'all') {
                $url = $this->getAssetsUrl() . '/css/' . $file;
                Yii::app()->clientScript->registerCssFile($url, $media);
        }

        /**
         * Return an image url stored in the assets.
         * @param string $file the file's name.
         * @return string image URL.
         */
        public function getImage($file) {
                return $this->getAssetsUrl() . '/images/' . $file;
        }

        /**
         * Return URL of a script file in the module
         * @param string $file the file's name
         * @return string file URL
         */
        public function getScriptFile($file) {
                return $this->getAssetsUrl() . '/js/' . $file;
        }

        /**
         * Register a stript file in the module.
         * @param string $file the file's name.
         * @param int $position the script's position.
         */
        public function registerScriptFile($file, $position = CClientScript::POS_END) {
                $url = $this->getScriptFile($file);
                Yii::app()->clientScript->registerScriptFile($url, $position);
        }

}

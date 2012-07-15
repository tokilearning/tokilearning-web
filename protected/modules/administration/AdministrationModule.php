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

}

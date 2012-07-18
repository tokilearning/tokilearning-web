<?php

/**
 * CAdministrationController is a base controller for all controllers in
 * administration module.
 * 
 * This controller will override all of the settings from the main application
 * for this administration module's purpose.
 *
 * @property AdministrationModule $module the module of this controller.
 * 
 * @author Petra Barus <petra.barus@gmail.com>
 * @package administration.components
 */
abstract class CAdministrationController extends CController {

        /**
         * @var string the layout name for controllers in administration module.
         */
        public $layout = 'admin';

        /**
         * @return string assets URL of this controller's module.
         */
        public function getAssetsUrl() {
                return $this->module->getAssetsUrl();
        }

}
<?php

/**
 * CAdministrationController is a base controller for all controllers in
 * administration module.
 * 
 * This controller will override all of the settings from the main application
 * for this administration module's purpose.
 * 
 * @author Petra Barus <petra.barus@gmail.com>
 * @package administration.components
 */
abstract class CAdministrationController extends CController {

        /**
         * @var string the layout name for controllers in administration module.
         */
        public $layout = 'main';

}
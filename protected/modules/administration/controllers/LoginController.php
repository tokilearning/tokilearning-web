<?php

/**
 * LoginController shows login page for administration module.
 * 
 * This controller will shows login form.
 * 
 * @author Petra Barus <petra.barus@gmail.com>
 * @package administration.controllers
 */
class LoginController extends \CAdministrationController {

        /**
         * @var string the layout name for login name.
         */
        public $layout = 'adminlogin';

        /**
         * Login form display action.
         */
        public function actionIndex() {
                $this->render('index');
        }

}
<?php

/**
 * DashboardController shows landing page for administration module.
 * 
 * This controller will shows list of current statistics for the application
 * and some important links for the administrator to start managing the
 * application.
 * 
 * @author Petra Barus <petra.barus@gmail.com>
 * @package administration.controllers
 */
class DashboardController extends CAdministrationController {

        /**
         * Landing page display action.
         */
        public function actionIndex() {
                $this->render('index');
        }

}
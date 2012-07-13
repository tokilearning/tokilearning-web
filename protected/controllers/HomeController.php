<?php

/**
 * HomeController shows landing page.
 * 
 * This controller will shows landing page. The content of the landing page will
 * most likely generated from widgets.
 * 
 * @author Petra Barus <petra.barus@gmail.com>
 * @package application.controllers
 */
class HomeController extends CController {

        /**
         * Landing apge display action.
         * 
         * This action only renders index view file.
         */
        public function actionIndex() {
                $this->render('index');
        }

}
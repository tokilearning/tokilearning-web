<?php

/**
 * ErrorController shows error page for administration module.
 * 
 * This controller will shows error page.
 * 
 * @author Petra Barus <petra.barus@gmail.com>
 * @package administration.controllers
 */
class ErrorController extends CAdministrationController {

        /**
         * @var string the layout name for error name.
         */
        public $layout = 'adminerror';

        /**
         * Error display form.
         */
        public function actionIndex() {
                $error = Yii::app()->errorHandler->getError();
                $this->render('index', array(
                        'error' => $error,
                ));
        }

}
<?php

/**
 * ErrorController shows error message.
 * 
 * This controllers catches error object from application error handler and 
 * displays the error message.
 * 
 * @author Petra Barus <petra.barus@gmail.com>
 * @package application.controllers
 */
class ErrorController extends CController {

        /**
         * Error display action.
         * 
         * This action process the error and displays the error message in the
         * view.
         */
        public function actionIndex() {
                $error = Yii::app()->errorHandler->getError();
                $this->render('index', array(
                        'error' => $error,
                ));
        }

}
<?php

/**
 * UsersController handles user management in administration model.
 * 
 * This controller will show list of users registered in the application and
 * some operations like create, update, and delete users.
 * 
 * @author Petra Barus <petra.barus@gmail.com>
 * @package administration.controllers
 */
class UsersController extends CAdministrationController {

        /**
         * User list display action.
         * 
         * This action displays table consisting of current users registered
         * in the application. There will be some details like full name,
         * username, email, and an action column.
         */
        public function actionIndex() {
                $dataProvider = new CActiveDataProvider(User::model(), array(
                                'criteria' => array(
                                        'select' => array(
                                                //TODO: Refactor this to a scope.
                                                'id', 'fullName', 'username', 'email',
                                        ),
                                        'scopes' => array(
                                                'sortNewestCreatedTime',
                                        )
                                ),
                                'pagination' => array(
                                        'pageSize' => 50,
                                ),
                        ));
                $this->render('index', array(
                        'dataProvider' => $dataProvider,
                ));
        }

}
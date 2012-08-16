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

        /**
         * User update form display action.
         * 
         * This action displays a form to update the user information.
         * 
         * @param int $id The ID of displayed user.
         */
        public function actionUpdate($id) {
                $user = User::model()->findByPk($id);
                if ($user === NULL)
                        throw new CHttpException(404);

                if (isset($_POST['User'])) {
                        $user->setScenario(User::SCENARIO_ADMIN_UPDATE);
                        $user->setAttributes($_POST['User']);
                        if ($user->save()) {
                                Yii::app()->user->setFlash('userUpdateSuccess', true);
                        }
                }
                $this->pageTitle = Yii::t('admin', 'Viewing User: {user}', array(
                                '{user}' => $user->fullName,
                        ));
                $this->render('update', array(
                        'user' => $user,
                ));
        }

}
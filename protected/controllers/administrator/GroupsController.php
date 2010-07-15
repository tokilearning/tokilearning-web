<?php

class GroupsController extends CAdminController {

    public $layout = 'application.views.layouts.column2';
    private $_model;

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Group', array(
                    'pagination' => array(
                        'pageSize' => 10,
                    ),
                ));
        $this->render('index', array('dataProvider' => $dataProvider));
    }

    public function actionView() {
        $group = $this->loadModel();
        $memberDataProvider=new CActiveDataProvider('User', array(
            'criteria'=>array(
                    'join' => 'JOIN groups_users ON user_id = id',
                    'condition' => 'group_id = '.$group->id,
                ),
            'pagination'=>array(
                'pageSize'=>5,
                ),
            )
        );
        $this->render('view', array('group' => $group, 'memberDataProvider' => $memberDataProvider));
    }

    public function actionCreate() {
        $model = new Group('adminCreate');
        if (isset($_POST['Group'])){
            $model->attributes = $_POST['Group'];
            if ($model->validate()){
                $model->save(false);
                Yii::app()->authManager->createRole($model->name, $model->description);
                $this->redirect($this->createUrl('update', array('id' => $model->id)));
            }
        }
        $this->render('create', array('model' => $model));
    }

    public function actionUpdate() {
        $model = $this->loadModel();
        if (isset($_POST['Group'])){
            $model->attributes = $_POST['Group'];
            if (!in_array($model->id, array(0, 1, 2, 3))) {
                if ($model->validate()){
                    $model->save(false);
                }
            }
        }
        $memberDataProvider=new CActiveDataProvider('User', array(
            'criteria'=>array(
                    'join' => 'JOIN groups_users ON user_id = id',
                    'condition' => 'group_id = '.$model->id,
                ),
            'pagination'=>array(
                'pageSize'=>5,
                ),
            )
        );
        $this->render('update', array('model' => $model, 'memberDataProvider' => $memberDataProvider));
    }

    public function actionDelete() {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $model = $this->loadModel();
            if (!in_array($model->id, array(0, 1, 2, 3))) {
                Yii::app()->authManager->removeAuthItem($model->name);
                $model->delete();
                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if (!isset($_GET['ajax']))
                    $this->redirect(array('index'));
            }
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionMemberLookup(){
        if (Yii::app()->request->isAjaxRequest && isset($_GET['q'])){
            $name = $_GET['q'];
            $limit = min($_GET['limit'], 10);
            $criteria = new CDbCriteria;
            $criteria->condition = "id LIKE :sterm OR username LIKE :sterm OR full_name LIKE :sterm OR email LIKE :sterm";
            $criteria->params = array(":sterm" => "%$name%");
            $criteria->limit = $limit;
            $users = User::model()->findAll($criteria);
            $retval = '';
            foreach($users as $user)
            {
                $retval .= $user->getAttribute('id'). '. '
                        .$user->getAttribute('full_name').' ('
                        .$user->getAttribute('username').' / '
                        .$user->getAttribute('email')
                        . ')'.'|'.$user->getAttribute('id')."\n";
            }
            echo $retval;
        }
    }

    public function actionRemoveMember(){
        if (Yii::app()->request->isPostRequest && isset($_GET['id']) && isset($_GET['memberid'])) {
            $model = $this->loadModel();
            //TODO:
            $user = User::model()->findByPk($_GET['memberid']);
            if ($user != null){
                Yii::app()->authManager->revoke($model->name, $user->id);
                $model->removeMember($user);
                if (!isset($_GET['ajax']))
                    $this->redirect(array('index'));
            }
        }
    }

    public function actionAddMember(){
        if (Yii::app()->request->isAjaxRequest && isset($_GET['id'])) {
            $model = $this->loadModel();
            if (isset($_GET['memberid'])){
                //TODO:
                $user = User::model()->findByPk($_GET['memberid']);
                if ($user != null){
                    Yii::app()->authManager->assign($model->name, $user->id);
                    $model->addMember($user);
                }
            }
        }
    }

    public function loadModel() {
        if ($this->_model === null) {
            if (isset($_GET['id']))
                $this->_model = Group::model()->findbyPk($_GET['id']);
            if ($this->_model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $this->_model;
    }

}

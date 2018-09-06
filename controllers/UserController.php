<?php
namespace app\controllers;

use app\components\Chid2ApkHelper;
use app\models\GroupItem;
use app\models\LoginCount;

use Yii;
use yii\data\Pagination;

use app\models\User;

class UserController extends CmController
{
    public function actionProfile()
    {
        $user_info = Yii::$app->user->identity->toArray(['uid', 'username', 'nickname', 'ctime']);
        
        return $this->render('profile', [
            'user_info' => $user_info,
        ]);
    }

    public function actionIndex() {
        $auth = Yii::$app->authManager;

        $query = User::find()->where(['<>', 'status',  User::STATAS_DELETE_CODE])->orderBy('uid DESC');
        $pagination = new Pagination(['totalCount' => $query->count(), 'pageSize' => Yii::$app->params['page_size']]);
        $users = $query->offset($pagination->offset)->limit($pagination->limit)->all();

        return $this->render('index', [
            'models' => $users,
            'pagination' => $pagination,
            'auth' => $auth
        ]);
    }

    public function actionAdd()
    {
        return $this->addView();
    }

    private function addView($user = null) {
        $auth = Yii::$app->authManager;
        $roles = $auth->getRoles();

        if(is_null($user)) {
            $user = new User();
            $user->setScenario(User::SCENARIO_REGISTER);
        }

        return $this->render('add', [
            'model' => $user,
            'auth' => $auth,
            'roles' => $roles
        ]);
    }

    public function actionAddSubmit()
    {
        $auth = Yii::$app->authManager;

        $user = new User();
        $user->setScenario(User::SCENARIO_REGISTER);
        $user->load(Yii::$app->request->post());
        $user->password = Yii::$app->security->generateRandomString(14);

        if(!$user->save()) return $this->addView($user);

        if(!empty(Yii::$app->request->post('User')['role'])) {
            foreach (Yii::$app->request->post('User')['role'] as $rolename) {
                $auth->assign($auth->getRole($rolename), $user->uid);
            }
        }

        return $this->redirect(['/user']);
    }

    public function actionEdit($uid)
    {
        return $this->editView($uid);
    }

    private function editView($uid, $user = null) {
        if(!is_null($user) || $user = User::findOne(['uid' => $uid])) {
            $user->setScenario(User::SCENARIO_EDIT_USER);
            $auth = Yii::$app->authManager;
            $roles = $auth->getRoles();

            return $this->render('edit', [
                'model' => $user,
                'auth' => $auth,
                'roles' => $roles
            ]);
        }

        return $this->goBack();
    }

    public function actionEditSubmit()
    {
        $uid = Yii::$app->request->post('User')['uid'];
        if($user = User::findOne($uid)) {
            $user->setScenario(User::SCENARIO_EDIT_USER);
            $user->load(Yii::$app->request->post());
            if($user->save()) {

                if(!empty(Yii::$app->request->post('User')['role'])) {
                    $auth = Yii::$app->authManager;
                    $auth->revokeAll($user->uid);
                    foreach (Yii::$app->request->post('User')['role'] as $rolename) {
                        $auth->assign($auth->getRole($rolename), $user->uid);
                    }

                    if(isset(Yii::$app->request->post('User')['role'])){
                        $roles = Yii::$app->request->post('User')['role'];
                    }
                }

                return $this->goBack();
            }
        }

        return $this->editView($uid, $user);
    }

    public function insertGroupItem($user_id)
    {
        $has = GroupItem::find()->where(['group_id'=>2,'user_id'=>$user_id])->one();
        if(!$has){
            $member = new GroupItem();
            $member->user_id = $user_id;
            $member->group_id = 2;  // 旅长归属旅部权限
            $member->status = 0;
            $member->is_admin = 0;
            $member->create_time = $member->update_time = time();
            $member->save();
        }
    }

    public function actionDelSubmit($uid)
    {
        if($user = User::findOne($uid)) {
            $user->status = User::STATAS_DELETE_CODE;
            $user->save();
        }

        return $this->goBack();
    }

    public function actionDisableUser($uid)
    {
        if($user = User::findOne($uid)) {
            $user->status = User::STATAS_BLOCK_CODE;
            $user->save();
        }

        return $this->goBack();
    }

    public function actionEnableUser($uid)
    {
        if($user = User::findOne($uid)) {
            $user->status = User::STATAS_NORMAL_CODE;
            $user->save();
        }

        return $this->goBack();
    }

    public function actionResetPassword($uid)
    {
        if($user = User::findOne($uid)) {
            $user->password = Yii::$app->security->generateRandomString(14);
            $user->auth_key = Yii::$app->security->generateRandomString(32);
            if($user->save()) {

            }
        }

        return $this->goBack();
    }
}

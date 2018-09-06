<?php
namespace app\controllers;

use Yii;
use app\models\Product;

class PsController extends CmController
{
    public function actionIndex() {
        $auth = Yii::$app->authManager;

        $roles = $auth->getRoles();
        $pss = array_filter($auth->getPermissions(), function($ps){
            return empty($ps->data); //不显示2级子权限
        });


        $role_sort_keys = [];
        foreach($roles as $role) {
            $role_sort_keys[] = $role->createdAt;
        }

        $ps_sort_keys = [];
        foreach($pss as $ps) {
            $ps_sort_keys[] = $ps->description;
        }

        array_multisort($role_sort_keys, SORT_DESC, $roles);
        array_multisort($ps_sort_keys, SORT_DESC, $pss);

        return $this->render('ps', [
            'auth' => $auth,
            'roles' => $roles,
            'pss' => $pss,
        ]);
    }

    public function actionAddPs() {
        $auth = Yii::$app->authManager;

        return $this->render('add-ps');
    }

    public function actionAddPsSubmit() {
        $data = Yii::$app->request->post();

        $auth = Yii::$app->authManager;
        if($ps = $auth->createPermission($data['ps-name'])) {
            $ps->description = $data['ps-desc'];
            $auth->add($ps);
            return $this->goBack();
        }

        return $this->render('add-ps');
    }

    public function actionEditPs($psname) {
        $auth = Yii::$app->authManager;
        $ps = $auth->getPermission($psname);

        return $this->render('edit-ps', [
            'ps' => $ps
        ]);
    }

    public function actionEditPsSubmit($psname) {
        $auth = Yii::$app->authManager;
        $data = Yii::$app->request->post();

        if($ps = $auth->createPermission($data['ps-name'])) {
            $ps->description = $data['ps-desc'];
            $auth->update($psname, $ps);

            return $this->goBack();
        }

        return $this->actionEditPs($psname);
    }

    public function actionDelPsSubmit($psname) {
        $auth = Yii::$app->authManager;
        if($ps = $auth->getPermission($psname)) {
            $auth->remove($ps);
        }

        return $this->goBack();
    }
}

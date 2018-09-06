<?php
namespace app\controllers;

use Yii;
use app\models\Product;

class RoleController extends CmController
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

        return $this->render('role', [
            'auth' => $auth,
            'roles' => $roles,
            'pss' => $pss,
        ]);
    }

    public function actionAddRole() {
        $auth = Yii::$app->authManager;
        $pss = $auth->getPermissions(); //不显示2级子权限

        return $this->render('add-role', [
            'auth' => $auth,
            'pss' => $pss,
        ]);
    }

    public function actionAddRoleSubmit() {
        $data = Yii::$app->request->post();
        $auth = Yii::$app->authManager;
        if($role = $auth->createRole($data['role-name'])) {
            $role->description = $data['role-desc'];
            $auth->add($role);

            foreach($data['role-ps'] as $psname) {
                if($ps = $auth->getPermission($psname)) {
                    $auth->addChild($role, $ps);
                    continue;
                }

                //如果还没有声明该权限，可能是二级子权限，需要这里单独声明下
                $top_psname = substr($psname, 0, strpos($psname, '?'));
                if($psname != $top_psname && $top_ps = $auth->getPermission($top_psname)) {
                    $ps = $auth->createPermission($psname);
                    $ps->description = $top_ps->description . '(' .  substr($psname, strpos($psname, '?') + 1) . ')';
                    $ps->data = $top_psname;
                    $auth->add($ps);
                    $auth->addChild($role, $ps);
                    continue;
                }
            }

            return $this->goBack();
        }

        return $this->render('add-role');
    }

    public function actionEditRole($rolename) {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($rolename);
        $pss = $auth->getPermissions();

        foreach($pss as $ps) {
            if(!empty($ps->data)) continue; //只有一级权限才走以下逻辑

            $ps_sort_keys[] = $ps->description;
            $top_pss[] = $ps->name;

            $pss_tree[] = [
                'role-ps' => $ps->name,
                'text' => $ps->description . '(' . $ps->name . ')',
                'population' => null,
                'flagUrl' => null,
                'state' => [
                    'checked' => $auth->hasChild($role, $ps),
                ],
            ];

        }
        array_multisort($ps_sort_keys, SORT_DESC, $pss_tree);

        return $this->render('edit-role', [
            'auth' => $auth,
            'pss' => $pss,
            'role' => $role,
        ]);
    }

    public function actionEditRoleSubmit($rolename) {
        $auth = Yii::$app->authManager;
        $data = Yii::$app->request->post();

        if($role = $auth->createRole($data['role-name'])) {
            $role->description = $data['role-desc'];
            $auth->update($rolename, $role);
            $auth->removeChildren($role);
            foreach($data['role-ps'] as $psname) {
                if($ps = $auth->getPermission($psname)) {
                    $auth->addChild($role, $ps);
                    continue;
                }

                //如果还没有声明该权限，可能是二级子权限，需要这里单独声明下
                $top_psname = substr($psname, 0, strpos($psname, '?'));
                if($psname != $top_psname && $top_ps = $auth->getPermission($top_psname)) {
                    $ps = $auth->createPermission($psname);
                    $ps->description = $top_ps->description . '(' .  substr($psname, strpos($psname, '?') + 1) . ')';
                    $ps->data = $top_psname;
                    $auth->add($ps);
                    $auth->addChild($role, $ps);
                    continue;
                }
            }

            return $this->goBack();
        }

        return $this->actionEditRole($rolename);
    }

    public function actionDelRoleSubmit($rolename) {
        $auth = Yii::$app->authManager;
        if($role = $auth->getRole($rolename)) {
            $auth->remove($role);
        }

        return $this->goBack();
    }
}

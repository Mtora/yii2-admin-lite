<?php
namespace app\controllers;

use Yii;
use app\models\User;
use yii\base\Exception;

class CmController extends \yii\web\Controller {
    public $_uid = null; //当前登录用户UID
    public $_user = null; //当前登录用户Model
    public $_ip = null; //当前访问者真实的IP

    public function beforeAction($action) {
        if(!parent::beforeAction($action)) return false;
        $this->_ip = $this->getIp();

        if(!Yii::$app->user->isGuest) {
            $this->_uid = Yii::$app->user->getId();
            $this->_user = User::findOne($this->_uid);
        }
        //未登录就可访问的控制器action
        $ignore_can_actions = ['site/index', 'site/start-captch', 'tf-event/callback-pack-status', 'my-game/pr', 'my-game/download'];
        if(in_array($action->uniqueId, $ignore_can_actions)) {
            return true;
        }

        //未登录用户，全部跳到登录页
        if(Yii::$app->user->isGuest) {
            $this->redirect(Yii::$app->user->loginUrl);
            return false;
        }

        $uri = '/' . $action->controller->getUniqueId() . '/';
        if(!$this->can($uri)) {
            Yii::$app->response->statusCode = 403;
            Yii::$app->response->content = '<h1>403 Forbidden</h1>';
            return false;
        }

        return true;
    }

    public function can($uri, $uid = null) {
        if($uri == '/my/') return true; //任何登录用户都可以访问的URI

        try {
            if(is_null($uid)) { //检查当前登录用户
                return Yii::$app->user->identity->isSuperAdmin() || Yii::$app->user->can($uri);
            } else { //检查指定用户
                $user = User::findOne($uid);
                if(!$user) return false;

                return $user->isSuperAdmin() || Yii::$app->authManager->checkAccess($uid, $uri);
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function can_v2($uri) {
        if(Yii::$app->user->identity->isSuperAdmin() || $uri == '/my/') return true;

        static $pss = [];
        if(empty($pss)) {
            foreach(Yii::$app->authManager->getPermissionsByUser($this->_uid) as $ps) {
                $pss[] = $ps->name;
            }
        }
        return in_array($uri, $pss);
    }

    public function getIp() {
        if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != '') {
            $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $ip = trim($ips[0]);
        } else if(isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } else {
            $ip = '0.0.0.0';
        }

        return $ip;
    }

    public function showSuccessPage($title, $url = null, $message = '', $delayMSec = 800) {
        return $this->render('//common/show_status_page', [
            'status' => 'success',
            'title' => $title,
            'message' => $message,
            'url' => $url,
            'delayMSec' => $delayMSec
        ]);
    }

    public function showErrorPage($title, $url = null, $message = '', $delayMSec = 2000) {
        return $this->render('//common/show_status_page', [
            'status' => 'danger',
            'title' => $title,
            'message' => $message,
            'url' => $url,
            'delayMSec' => $delayMSec
        ]);
    }

}
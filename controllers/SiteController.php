<?php

namespace app\controllers;

use app\components\GeetestLib;
use app\models\Game;
use app\models\GamePay;
use app\models\Spread;
use Yii;
use app\models\User;
use app\models\LoginCount;
use app\models\LoginLog;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use app\components\CommonUtil;

class SiteController extends CmController {
    public function actionIndex() {
        //var_dump(Yii::$app->request->post());die;
        if(Yii::$app->user->isGuest) {
            if($data = Yii::$app->request->post('User')) {  //提交登录
                if($user = User::findOne(['username' => $data['username']])) { //有此用户
                    $duration = Yii::$app->request->post("is_auto_login") ? 86400 * 7 : 0;
                    $user->setScenario(User::SCENARIO_LOGIN);
                    $user->password = $data['password'];
                    if($user->login($duration)) {
                        $is_reg = self::isRegular($data['password']);
                        //记录登录日志
                        $login = new LoginLog();
                        $login->email = $user->username;
                        $login->status = $is_reg ? 1 : 2;   // 1: 正常 2: 弱密码登录
                        $login->ua = $_SERVER['HTTP_USER_AGENT'];
                        $login->ip = $this->_ip;
                        $login->save();
                        //登录成功清零失败记次
                        //email关联
                        $ret_email = LoginCount::findOne(['content' => $user->username]);
                        if($ret_email){
                            $ret_email->count = 0;
                            $ret_email->save();
                        }
                        //ip关联
                        $ret_ip = LoginCount::findOne(['content' => $this->_ip]);
                        if($ret_ip){
                            $ret_ip->count = 0;
                            $ret_ip->save();
                        }
                        $my_data = $this->getMyData();  //统计数据
                        $my_level = $this->getMyLevel();  //我的等级
                        $my_game = $this->getMyGame(); //我的游戏
                        return $this->render('index',[
                            'data'=>$my_data,
                            'level'=>$my_level,
                            'game'=>$my_game
                        ]);
                    }
                }
                else {    //无此用户，超过次数误导登录
                    ////记录登录日志
                    $login = new LoginLog();
                    $login->email = $data['username'];
                    $login->status = 0;
                    $login->ua = $_SERVER['HTTP_USER_AGENT'];
                    $login->ip = $this->_ip;
                    $login->save();

                    $user = new User();
                    $user->addError('password', '用户名或密码错误');
                }
            } else {    //打开登录页面
                $user = new User();
            }
            $this->layout = 'main-login';
            return $this->render('login', [
                'model' => $user,
            ]);
        }
        else {
            $my_data = $this->getMyData();  //统计数据
            $my_level = $this->getMyLevel();  //我的等级
            $my_game = $this->getMyGame(); //我的游戏
            return $this->render('index',[
                'data'=>$my_data,
                'level'=>$my_level,
                'game'=>$my_game,
            ]);
        }
    }

    private function getMyData()
    {
        $my_data = [];
        $user_id = Yii::$app->user->getId();
        //当日个人新增所有付费
        $today = date("Y-m-d");
        $beginTime=date("Y-m-d H:i:s",mktime(0,0,0,date('m'),date('d'),date('Y')));
        $endTime=date("Y-m-d H:i:s",mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1);
        $sql = "SELECT SUM(order_amount) as day_money FROM game_pay WHERE userid = '{$user_id}' AND pay_time BETWEEN '{$beginTime}' and '{$endTime}'";
        $day_money = Yii::$app->db->createCommand($sql)->queryOne();
        if(is_null($day_money['day_money'])) $day_money['day_money'] = '0';
        $day_money['day_money'] = CommonUtil::sprintF2($day_money['day_money']);
        //当日个人所有新增设备
        $sql = "SELECT COUNT(id) as day_device FROM device_active  WHERE userid = '{$user_id}' AND add_time BETWEEN '{$beginTime}' and '{$endTime}'";
        $day_device = Yii::$app->db->createCommand($sql)->queryOne();
        if(is_null($day_device['day_device'])) $day_device['day_device'] = '0';
        // 当日个活跃用户
        $sql = "SELECT SUM(member_num) as day_user FROM person_day_sta  WHERE user_id = '{$user_id}' AND stat_time = '{$today}'";
        $day_user = Yii::$app->db->createCommand($sql)->queryOne();
        if(is_null($day_user['day_user'])) $day_user['day_user'] = '0';
        return $my_data = [
            "day_money"=>$day_money['day_money'],
            "day_device"=>$day_device['day_device'],
            "day_user"=>$day_user['day_user']
        ];
    }

    private function getMyGame()
    {
        $user_id = Yii::$app->user->getId();
        $query = Spread::find()->where(['user_id'=>$user_id,'default'=>1]);
        $pagination = new Pagination(['totalCount' => $query->count(), 'pageSize' => Yii::$app->params['page_size']]);
        $spread = $query->offset($pagination->offset)->limit($pagination->limit)->all();
        $game_bundle = ArrayHelper::index(Game::find()->select(['game_id','game_name'])->asArray()->all(), 'game_id');
        return $my_game = [ 'models' => $spread,
            'game' => $game_bundle,
            'pagination' => $pagination
        ];
    }

    private function getMyLevel()
    {
        $user_id = Yii::$app->user->getId();
        $user = User::findOne($user_id);
        $my_data = User::getLevel($user->level_score);
        $my_data['all_score'] = $this->getPersonAll();
        $my_data['month_score'] = CommonUtil::getAmountMonth();
        return $my_data?$my_data:$my_data = [];
    }

    public function getPersonAll()
    {
        // 个人所有经验值
        $user_id = Yii::$app->user->getId();
        $sql = "SELECT SUM(amount) as all_score from person_day_sta WHERE user_id = '{$user_id}'";
        $all_score = Yii::$app->db->createCommand($sql)->queryOne();
        return $all_score['all_score'] ? $all_score['all_score'] : '0';
    }


    public function actionRecover(){
        echo 'todo...';
    }

    //极验验证码响应
    public function actionStartCaptch() {
        $gee = Yii::$app->params['geetest'];
        $GtSdk = new GeetestLib($gee['CAPTCHA_ID'], $gee['PRIVATE_KEY']);
        //session_start();
        $data = array(
            "user_id" => "test", # 网站用户id
            "client_type" => "web", #web:电脑上的浏览器；h5:手机上的浏览器，包括移动应用内完全内置的web_view；native：通过原生SDK植入APP应用的方式
            "ip_address" => "127.0.0.1" # 请在此处传输用户请求验证时所携带的IP
        );
        $status = $GtSdk->pre_process($data, 1);
        $_SESSION['gtserver'] = $status;
        $_SESSION['user_id'] = $data['user_id'];
        echo $GtSdk->get_response_str();
    }
    //判断密码强度是否达标
    public function isRegular($pwd){
        if(!ctype_alnum($pwd)){
            return false;
        }
        //没满8位
        if(strlen($pwd) < 8){
            return false;
        }
        //重复6位
        if(self::is_repeat($pwd)){
            return false;
        }
        //连续6位递增
        if(self::is_up_con($pwd)){
            return false;
        }
        //连续6位递减
        if(self::is_dn_con($pwd)){
            return false;
        }
        return true;
    }
    //判断是否包含6位重复数字或字母
    public function is_repeat($str){
        $arr = str_split($str);
        $tmp_txt = '';
        $tmp_count = 0;
        foreach($arr as $value){
            if($tmp_txt == $value){
                $tmp_count++;
                if($tmp_count >= 5){
                    return true;
                }
            }else{
                $tmp_txt = $value;
                $tmp_count = 0;
            }
        }
    }
    //判断字符串是否包含 递增 6位数字串
    public function is_up_con($str){
        $arr = str_split($str);
        $tmp_num = -1;
        $tmp_count = 0;
        foreach($arr as $value){
            if(is_numeric($value)){
                if($tmp_count == 0){
                    $tmp_num = $value;
                    $tmp_count++;
                }
                elseif($value == $tmp_num + 1){
                    $tmp_count++;
                    $tmp_num = $value;
                    if($tmp_count >= 5){
                        return true;
                    }
                } else{
                    $tmp_num = $value;
                    $tmp_count = 0;
                }
            }
            else{
                $tmp_num = $value;
                $tmp_count = 0;
            }
        }
        return false;
    }
    //判断字符串是否包含 递减 6位数字串
    public function is_dn_con($str){
        $arr = str_split($str);
        $tmp_num = -1;
        $tmp_count = 0;
        foreach($arr as $value){
            if(is_numeric($value)){
                if($tmp_count == 0){
                    $tmp_num = $value;
                    $tmp_count++;
                }
                elseif($value == $tmp_num - 1){
                    $tmp_count++;
                    $tmp_num = $value;
                    if($tmp_count >= 5){
                        return true;
                    }
                } else{
                    $tmp_num = $value;
                    $tmp_count = 0;
                }
            }
            else{
                $tmp_num = $value;
                $tmp_count = 0;
            }
        }
        return false;
    }


}
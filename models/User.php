<?php
namespace app\models;
use Yii;
/**
/**
 * This is the model class for table "auth_user".
 *
 * @property integer $uid
 * @property string $username
 * @property string $email
 * @property string $pwd_hash
 * @property string $auth_key
 * @property string $nickname
 * @property string $phone
 * @property integer $is_admin
 * @property string $first_page
 * @property integer $status
 * @property integer $level_score
 * @property string $ctime
 */

class User extends \yii\db\ActiveRecord {
    public $password;
    public $password_repeat;
    public $password_old;
    const SCENARIO_LOGIN = 'login';
    const SCENARIO_REGISTER = 'register';
    const SCENARIO_EDIT_USER = 'edit_user';
    const SCENARIO_EDIT_SELF_PROFILE = 'edit_self_profile';
    const SCENARIO_EDIT_SELF_PWD = 'edit_self_pwd';
    const STATAS_NORMAL_CODE = 0;
    const STATAS_BLOCK_CODE = 10;
    const STATAS_DELETE_CODE = -1;
    const STATAS_IS_TRAINING_CODE = 0;
    const STATAS_IS_TRAINED_CODE = 1;
    public static function getDb()
    {
        return Yii::$app->get('db');
    }
    public static function tableName()
    {
        return 'auth_user';
    }
    public function rules()
    {
        return [
            [['email','nickname','username'], 'trim'],
            ['email', 'string', 'length' => [5, 128]],
            ['email', 'email'],
            ['email', 'unique'],
            [['password_old', 'password'], 'string', 'length' => [8, 128]],
            ['auth_key', 'string', 'length' => [32, 128]],
            ['nickname', 'string', 'length' => [2, 128]],
            ['username', 'string', 'length' => [2, 128]],
            ['phone', 'string', 'max' => 13],
            ['first_page', 'string', 'length' => [0, 4096]],
            ['is_admin', 'boolean', 'trueValue' => 1, 'falseValue' => 0],
            ['status', 'in', 'range' => [self::STATAS_NORMAL_CODE, self::STATAS_BLOCK_CODE, self::STATAS_DELETE_CODE]],
            //登录时
            [['nickname','username', 'password'], 'required', 'on' => self::SCENARIO_LOGIN],
            ['password', 'validatePassword', 'on' => self::SCENARIO_LOGIN],
            ['status', 'isAllowLoginUser', 'on' => self::SCENARIO_LOGIN],
            //注册
            [['email', 'nickname', 'username','password', 'is_admin'], 'required', 'on' => self::SCENARIO_REGISTER],
            //编辑用户
            [['email', 'nickname', 'password', 'is_admin'], 'required', 'on' => self::SCENARIO_EDIT_USER],
            //设置自己的信息
            [['username', 'email', 'nickname'], 'required', 'on' => self::SCENARIO_EDIT_SELF_PROFILE],
            //修改自已的密码
            [['password_old', 'password', 'password_repeat'], 'required', 'on' => self::SCENARIO_EDIT_SELF_PWD],
            ['password', 'compare', 'on' => self::SCENARIO_EDIT_SELF_PWD],
            ['password_old', 'validatePassword', 'on' => self::SCENARIO_EDIT_SELF_PWD],
        ];
    }
    public function scenarios()
    {
        //!号为要验证，但不要块赋值
        return [
            'default' => [],
            self::SCENARIO_LOGIN => ['!username', '!password', '!status','nickname','email'],
            self::SCENARIO_REGISTER => ['email', 'nickname','username', 'is_admin', '!password'],
            self::SCENARIO_EDIT_USER => ['email', 'nickname','username', 'is_admin', 'status'],
            self::SCENARIO_EDIT_SELF_PROFILE => ['email', 'nickname','username'],
            self::SCENARIO_EDIT_SELF_PWD => ['password_old', 'password', 'password_repeat']
        ];
    }
    public function attributeLabels()
    {
        return [
            'uid' => 'UID',
            'username' => '登陆用户名',
            'email' => 'Email',
            'password' => '密码',
            'password_repeat' => '确认密码',
            'password_old' => '原密码',
            'nickname' => '显示昵称',
            'phone' => '手机号',
            'first_page' => '首页地址',
            'is_admin' => '超级管理员',
        ];
    }
    public function validatePassword($attribute, $params)
    {
        if (Yii::$app->security->validatePassword($this->$attribute, $this->pwd_hash)) {
            return true;
        } else {
            $this->addError($attribute, $attribute == 'password' ? '用户名或密码错误' : '原密码错误');
            return false;
        }
    }
    public function isAllowLoginUser($attribute, $params)
    {
        if ($this->status == self::STATAS_NORMAL_CODE) {
            return true;
        } else if($this->status == self::STATAS_BLOCK_CODE) {
            $this->addError('password', '你的帐户已被锁定，请联系管理员');
            return false;
        } else {
            $this->addError('password', '用户名或密码错误');
            return false;
        }
    }
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = Yii::$app->security->generateRandomString(32);
            }
            if($this->password) $this->pwd_hash = Yii::$app->security->generatePasswordHash($this->password);
            return true;
        }
        return false;
    }
    public function login($duration = 0) {
        return $this->validate() ? Yii::$app->user->login(UserSession::findIdentity($this->uid), $duration) : false;
    }
    public function isSuperAdmin() {
        return $this->is_admin == 1;
    }

    public static function getLevel($level_score){
        switch (true){
            case  $level_score >=500000:
                return $return = ["level"=>"上校","diff"=>"-"];
                break;
            case  $level_score >=350000:
                return $return = ["level"=>"中校","diff"=>500000-$level_score];
                break;
            case  $level_score 	>=250000:
                return $return = ["level"=>"少校","diff"=>350000-$level_score];
                break;
            case  $level_score >=170000:
                return $return = ["level"=>"上尉","diff"=>250000-$level_score];
                break;
            case  $level_score >=100000:
                return $return = ["level"=>"中尉","diff"=>170000-$level_score];
                break;
            case  $level_score >= 50000:
                return $return = ["level"=>"少尉","diff"=>50000-$level_score];
                break;
            case  $level_score >= 20000:
                return $return = ["level"=>"士官","diff"=>100000-$level_score];
                break;
            default :
                return $return = ["level"=>"列兵","diff"=>20000-$level_score];
                break;
        }
    }
}
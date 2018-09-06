<?php

namespace app\modules\tpl\models;

use Yii;
use yii\base\Model;


/**
 * 这是一个测试用的Model
 * ContactForm is the model behind the contact form.
 */
class TemplateForm extends Model
{
    public $username;
    public $password;
    public $email;
    public $sex;
    public $photo;
    public $hobby;
    public $info;
    public $age;
    public $birthday;
    
    public function __construct()
    {
        $faker = \Faker\Factory::create();
        $this->username = $faker->name;
        $this->email    = $faker->email;
        $this->sex      = array_rand([0,1]);
        $this->hobby    = array_rand([0, 1, 2]);
        $this->info     = $faker->text;
        $this->age      = rand(1, 99);
    }

        /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['username', 'password', 'email', 'birthday'], 'required', 'message' => '内容不能为空'],
            [['username', 'password'], 'string', 'length' => [6, 32], 'message' => '最少6位'],
            [['age'], 'integer', 'message' => '内容必须为数字'],
            // email has to be a valid email address
            ['email', 'email', 'message' => '邮箱格式不正确'],
            // verifyCode needs to be entered correctly
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'password' => '密码',
            'email' => '邮箱',
            'sex' => '性别',
            'age' => '年龄',
            'photo' => '照片',
            'hobby' => '爱好',
            'info' => '简介',
            'birthday' => '生日',
        ];
    }

}

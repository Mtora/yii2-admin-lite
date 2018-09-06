<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "login_log".
 *
 * @property integer $id
 * @property string $email
 * @property integer $status
 * @property string $ua
 * @property string $ip
 * @property string $time
 */
class LoginLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'login_log';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['time'], 'safe'],
            [['email'], 'string', 'max' => 128],
            [['ua'], 'string', 'max' => 255],
            [['ip'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'status' => 'Status',
            'ua' => 'Ua',
            'ip' => 'Ip',
            'time' => 'Time',
        ];
    }
}

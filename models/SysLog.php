<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sys_log".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $route
 * @property string $req_params
 * @property string $tb_name
 * @property string $op_type
 * @property string $pk_data
 * @property string $ori_data
 * @property string $latest_data
 * @property string $msg
 * @property string $ip
 * @property string $add_time
 */
class SysLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_log';
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
            [['uid', 'route', 'op_type'], 'required'],
            [['uid'], 'integer'],
            [['req_params', 'op_type', 'pk_data', 'ori_data', 'latest_data', 'msg'], 'string'],
            [['add_time'], 'safe'],
            [['route', 'tb_name'], 'string', 'max' => 255],
            [['ip'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '索引ID',
            'uid' => 'UID',
            'route' => '操作路由',
            'req_params' => '请求参数',
            'tb_name' => '操作表名',
            'op_type' => '操作类型',
            'pk_data' => '主键信息',
            'ori_data' => '原始数据',
            'latest_data' => '更新数据',
            'msg' => '操作信息',
            'ip' => '操作IP',
            'add_time' => '添加时间',
        ];
    }
}
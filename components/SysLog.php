<?php
namespace app\components;
use Yii;
use yii\helpers\Url;
/**
 * 系统日志
 */
class SysLog
{
    /**
     *
     * @param type $event model
     * @return type
     */
    public static function write($event)
    {
        $sender = $event->sender;
        $tables = Yii::$app->params['table_desc'];

        if ($sender instanceof \app\models\SysLog || $sender instanceof \app\models\User || $sender instanceof \app\models\passport\LoginLog ||
            $sender instanceof \app\models\passport\Udid || $sender instanceof \app\models\passport\Uid || $sender instanceof \app\models\passport\Userinfo ||
            $sender instanceof \app\models\passport\Username || $sender instanceof \app\models\LoginLog || $sender instanceof \app\models\LoginCount) {
            return;
        }

        $model = new \app\models\SysLog();

        $labels = $sender->attributeLabels();
        $attr = $sender->getAttributes();
        $msg  = '【%s】【%s】【%s】 记录【%s】，原始数据【%s】, 更新数据【%s】';

        $model->uid = isset(Yii::$app->user) ? Yii::$app->user->id : 0;
        $model->route = Url::to();
        $model->req_params = json_encode(Yii::$app->request->bodyParams);
        $model->tb_name = $sender->tableSchema->name;
        $model->pk_data = json_encode($sender->getPrimaryKey(true));
        $model->ori_data = isset($event->changedAttributes) ? json_encode($event->changedAttributes) : '';
        $model->latest_data = json_encode($attr);
        $model->ip = \app\components\CommonUtil::getUserIP();

        $op_msg = '查询了';
        switch ($event->name) {
            case \yii\db\ActiveRecord::EVENT_AFTER_INSERT:
                $model->op_type = 'INSERT'; $op_msg = '添加了'; break;
            case \yii\db\ActiveRecord::EVENT_AFTER_UPDATE:
                $model->op_type = 'UPDATE'; $op_msg = '更新了'; break;
            case \yii\db\ActiveRecord::EVENT_AFTER_DELETE:
                $model->op_type = 'DELETE'; $op_msg = '删除了'; break;
            case \yii\db\ActiveRecord::EVENT_AFTER_FIND:
            default :
                $model->op_type = 'SELECT'; break;
        }

        $ori_data = $latest_data = $pk_data = array();

        foreach ($sender->getPrimaryKey(true) as $k => $v) {
            $pk_data[] = $labels[$k] . ':' . $v;
        }

        if (isset($event->changedAttributes)) {
            foreach ($event->changedAttributes as $k => $v) {
                if ($v != $attr[$k]) {
                    $ori_data[] = $labels[$k] . ':' . $v;
                    $latest_data[] = $labels[$k] . ':' . $attr[$k];
                }
            }
        }

        if ($model->op_type == 'INSERT') {
            $ori_data = array();
        }

        if ($model->op_type == 'DELETE') {
            $msg = "【%s】【%s】【%s】 记录【%s】，%s删除数据【%s】";
            foreach ($attr as $k => $v) {
                $latest_data[] = $labels[$k] . ':' . $attr[$k];
            }
        }
        
        $nickname = isset(\Yii::$app->controller->_user) ? \Yii::$app->controller->_user->nickname : 'anonymous';
        $model->msg = sprintf($msg, $nickname,  $op_msg, 
                // method_exists($sender, 'getTableDesc') ? $sender->getTableDesc() : '数据', 
                isset($tables[$model->tb_name]) ? $tables[$model->tb_name] : '数据',
                implode(',', $pk_data),
                implode(',', $ori_data), implode(',', $latest_data));
        
        $model->save();
    }
}
<?php

namespace app\components;

use yii;

/**
 * 格式化SDK响应类
 */
class SdkResponse
{
    const RESP_SUCC = 200;
    const RESP_NOT_FOUND = 404;
    const RESP_SIGNATURE_ERROR = 403;
    const RESP_REQUEST_METHOD_ERROR = 405;
    const RESP_PARAMS_ERROR = 406;
    const RESP_SYSTEM_BUSY = 500;
    const RESP_ORDER_REPEAT = 600;
    const RESP_UNKNOW_ERROR = 601;
    const RESP_NETWORK_ERROR = 602;
    
    static $response_map = array(
        self::RESP_SUCC  => '',
        self::RESP_UNKNOW_ERROR  => '未知错误',
        self::RESP_NOT_FOUND  => '数据不存在',
        self::RESP_SIGNATURE_ERROR  => '签名错误',
        self::RESP_PARAMS_ERROR => '参数错误',
        self::RESP_REQUEST_METHOD_ERROR  => '请求方法错误',
        self::RESP_SYSTEM_BUSY  => '系统繁忙',
        self::RESP_ORDER_REPEAT => '订单重复',
        self::RESP_NETWORK_ERROR => '网络错误',
    );

    /**
     * 
     * @param type $code
     * @param type $data
     * @param type $msg
     */
    public static function output($code, $data = array(), $msg = '')
    {
        $response = yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
  
        $ret['code'] = isset(self::$response_map[$code]) ? $code : self::RESP_UNKNOW_ERROR;
        $ret['msg']  = empty($msg) ? self::$response_map[$ret['code']] : $msg;
        $ret['data'] = (object)$data;
        
        $response->data = $ret;
    }
}
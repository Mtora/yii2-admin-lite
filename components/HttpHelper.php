<?php

namespace app\components;

use yii;

/**
 * HTTP请求核心类
 */
class HttpHelper {

    /**
     * 连接超时时间
     */
    protected static $_cTimeout = 2.0;

    /**
     * 读取超时时间
     */
    protected static $_rTimeout = 1.0;

    /**
     * 写入超时时间
     */
    protected static $_wTimeout = 1.0;

    /**
     * User Agent
     */
    protected static $_userAgent = 'FO UA v1.0';

    /**
     * 请求方式，默认为 curl
     * 支持 curl, socket，若以上2种扩展都没有，则使用 fsockopen()
     */
    protected static $_mode = 'curl';

    /**
     * CURL 请求完成后的信息
     */
    protected static $_info;
    protected static $_crlf = "\r\n";

    /**
     * 发起 HTTP GET 请求并获取返回值
     * @param string $url
     * @return string
     */
    public static function get($url) {
        return self::request($url);
    }

    /**
     * 获取最近 HTTP 请求的返回状态码
     * @return int
     */
    public static function getHttpCode() {
        if (!is_array(self::$_info)){
            return false;
        }
        return self::$_info['http_code'];
    }

    /**
     * 获取最近 HTTP 请求信息
     * @return array
     */
    public static function getHttpInfo() {
        return self::$_info;
    }

    /**
     * 发起 HTTP POST 请求并获取返回值
     * @param string $url
     * @param array|string $fields
     * @return string
     */
    public static function post($url, $fields = null) {
        return self::request($url, 'POST', $fields);
    }

    /**
     * 发起 HTTP 请求并获取返回值
     * @param string $url
     * @param string $method
     * @param array|string $postFields
     * @param array $headers
     * @return string
     */
    public static function request($url, $method = 'GET', $postFields = null, $headers = null) {

        if ('curl' == self::$_mode) {
            if (function_exists('curl_init')) {
                return self::_requestCurl($url, $method, $postFields, $headers);
            } else {
                self::$_mode = 'socket';
            }
        }

        if ('socket' == self::$_mode) {
            if (function_exists('socket_create')) {
                return self::_requestSocket($url, $method, $postFields, $headers);
            } else {
                self::$_mode = 'normal';
            }
        }

        return self::_requestNormal($url, $method, $postFields, $headers);
    }

    /**
     * 设置 HTTP 请求方式
     * @param string $mode
     * @return void
     */
    public static function setMode($mode) {
        self::$_mode = strtolower(trim($mode));
    }

    /**
     * 设置 HTTP 请求超时时间
     * @param float $cTimeout 连接超时时间
     * @param float $wTimeout 写入超时时间
     * @param float $rTimeout 读取超时时间
     * @return void
     */
    public static function setTimeout($cTimeout = 2.0, $wTimeout = 1.0, $rTimeout = 1.0) {
        self::$_cTimeout = $cTimeout;
        self::$_wTimeout = $wTimeout;
        self::$_rTimeout = $rTimeout;
    }

    /**
     * CURL 方式发起 HTTP 请求并获取响应值
     * @param string $url
     * @param string $method
     * @param array|string $postFields
     * @param array $headers
     * @return string
     */
    protected static function _requestCurl($url, $method = 'GET', $postFields = null) {

        $ci = curl_init();

        curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($ci, CURLOPT_URL, $url);
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);  // 不直接输出
        curl_setopt($ci, CURLOPT_HEADER, false); // 返回中不包含header
        curl_setopt($ci, CURLOPT_USERAGENT, self::$_userAgent);
        curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, self::$_cTimeout);
        curl_setopt($ci, CURLOPT_TIMEOUT, (self::$_cTimeout + self::$_rTimeout + self::$_wTimeout));

        if ('POST' == strtoupper($method)) {
            curl_setopt($ci, CURLOPT_POST, true);
            curl_setopt($ci, CURLOPT_POSTFIELDS, $postFields);
        }

        if (0 == strpos($url, 'https')) {
            curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, 2); 
        } 
        
        $ret = curl_exec($ci);

        self::$_info = curl_getinfo($ci);

        curl_close($ci);

        return $ret;
    }

    /**
     * Socket 方式发起 HTTP 请求并获取响应值
     * @param string $url
     * @param string $method
     * @param array|string $postFields
     * @param array $headers
     * @return string
     */
    protected static function _requestSocket($url, $method = 'GET', $postFields = null) {

        $params = parse_url($url);
        if (false === $params) {
            return false;
        }

        $host = strtolower(trim($params['host']));
        $ip = preg_match('/[a-z]/i', $host) ? gethostbyname($host) : $host;
        $port = isset($params['port']) ? intval($params['port']) :
                ('https' == strtolower(trim($params['scheme'])) ? 443 : 80);
        $address = 'tcp://' . $ip . ':' . $port;

        $method = strtoupper(trim($method));
        $uri = isset($params['path']) ? $params['path'] : '/';
        if (isset($params['query'])) {
            $uri .= '?' . $params['query'];
        }
        if (isset($params['fragment'])) {
            $uri .= '#' . $params['fragment'];
        }

        $content = $method . ' ' . $uri . ' HTTP/1.0' . self::$_crlf;
        $content .= 'Host: ' . $host . ':' . $port . self::$_crlf;
        $content .= 'Connection: Close' . self::$_crlf;
        $content .= 'User-Agent: 51com' . self::$_crlf;
        $content .= 'Accept: */*' . self::$_crlf;
        if ('POST' == $method) {
            if (is_array($postFields)) {
                $postFields = http_build_query($postFields);
            }
            $content .= 'Content-type: application/x-www-form-urlencoded' . self::$_crlf;
            $content .= 'Content-Length: ' . strlen($postFields) . self::$_crlf . self::$_crlf;
            $content .= $postFields . self::$_crlf;
        }
        $content .= self::$_crlf;

        $res = Pubhlp_Network_Socket::request($address, $content, $error);

        if (false === $res) {
            return false;
        }

        $ret = self::_parseResponse($res);

        return $ret;
    }

    /**
     * 解析 HTTP 请求原生的响应字符串
     * @param string $res
     * @return string
     */
    protected static function _parseResponse($res) {

        self::$_info = null;

        $pos = strpos($res, "\r\n\r\n");
        $header = substr($res, 0, $pos);
        $status = substr($header, 0, strpos($header, "\r\n"));
        $content = substr($res, $pos + 4, strlen($res) - ($pos + 4));
        if (1 != preg_match('/^HTTP\/\d\.\d\s([\d]+)\s.*$/', $status, $matches)) {
            return false;
        }

        self::$_info['http_code'] = intval($matches[1]);
        return $content;
    }

}
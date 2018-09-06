<?php
$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'app\commands',
    'bootstrap' => ['log'],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logFile' => '/data/logswww/web',
                    'maxLogFiles' => 20,
                    'maxFileSize' => 102400,  // kilo-bytes 100M
                ],
            ],
        ],
        'authManager' => [  
            'class' => 'yii\rbac\DbManager', 
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'messageConfig'=>[
                'charset'=>'UTF-8',
                'from'=>['no_reply@changmeng.com'=>'畅梦管理员']
            ],
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.exmail.qq.com',
                'username' => 'no_reply@changmeng.com',
                'password' => 'vHpSXd1bJlSlMN6r',
                'port' => '465',
                'encryption' => 'ssl',
                'streamOptions' => [
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                    ]
                ]
            ]
        ],
    ],
    'params' => require_once __DIR__ . '/params.php'
];

require_once __DIR__ . '/db.php';
//require_once __DIR__ . '/redis.php';
//require_once __DIR__ . '/other.php';

if(file_exists(__DIR__ . '/' . YII_ENV . '/config.php')) 
    require_once __DIR__ . '/' . YII_ENV . '/config.php';

return $config;
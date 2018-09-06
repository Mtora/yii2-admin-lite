<?php
$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'zh-CN',
    'on beforeRequest' => function($event) {
            \yii\base\Event::on(\yii\db\BaseActiveRecord::className(), \yii\db\BaseActiveRecord::EVENT_AFTER_INSERT, ['app\components\SysLog', 'write']);
            \yii\base\Event::on(\yii\db\BaseActiveRecord::className(), \yii\db\BaseActiveRecord::EVENT_AFTER_UPDATE, ['app\components\SysLog', 'write']);
            \yii\base\Event::on(\yii\db\BaseActiveRecord::className(), \yii\db\BaseActiveRecord::EVENT_AFTER_DELETE, ['app\components\SysLog', 'write']);
        },
    'components' => [
        
        'request' => [
            'cookieValidationKey' => 'pSaP8ViNS6Hof6u6ZJpKb6Wn1kjy1c9A',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [  
            'class' => 'yii\rbac\DbManager',
            'db' => 'db',
        ],
        'user' => [
            'identityClass' => 'app\models\UserSession',
            'loginUrl' => ['/'],
            'enableAutoLogin' => true
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info', 'error', 'warning'],
                    'logFile' => '/data/logswww/web/suv.log',
                    'categories' => ['suv'],
                    'maxLogFiles' => 20,
                    'maxFileSize' => 102400,  // kilo-bytes 100M
                ],
            ],
        ],
        'urlManager' => [

            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => require(__DIR__ . '/route.php'),
        ],
        'assetManager' => [
            'appendTimestamp' => true,
        ]
    ],
    'params' => require_once __DIR__ . '/params.php',
    'aliases' => [  
        '@mdm/admin' => '$PATH\yii2-admin'
    ],
];

require_once __DIR__ . '/db.php';
//require_once __DIR__ . '/redis.php';
//require_once __DIR__ . '/other.php';

if(file_exists(__DIR__ . '/' . YII_ENV . '/config.php')) 
    require_once __DIR__ . '/' . YII_ENV . '/config.php';

return $config;
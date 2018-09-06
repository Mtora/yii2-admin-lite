<?php
namespace app\assets;

use yii\web\AssetBundle;

class GtAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/gt.css',
    ];
    public $js = [
        'js/gt.js',
        'js/gt-init.js',
    ];
    public $depends = [
    ];
}

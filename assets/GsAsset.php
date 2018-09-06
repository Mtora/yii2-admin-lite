<?php
namespace app\assets;

use yii\web\AssetBundle;

class GsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

    ];
    public $js = [
        'js/gs.js',
    ];
    public $depends = [
    ];
}

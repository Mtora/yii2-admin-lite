<?php
namespace app\assets;

use yii\web\AssetBundle;

class AdminProAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'plugins/bootstrap/css/bootstrap.min.css',
        'plugins/perfect-scrollbar/css/perfect-scrollbar.css',
        'plugins/chartist-js/dist/chartist.min.css',
        'plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css',
        'plugins/c3-master/c3.min.css',
        'plugins/toast-master/css/jquery.toast.css',
        'plugins/footable/css/footable.core.css',
        'css/style.css',
        'css/pages/footable-page.css',
        'css/colors/default.css',
        'plugins/bootstrap-daterangepicker/daterangepicker.css',
        'plugins/bootstrap-datepicker/bootstrap-datepicker.min.css',
        'plugins/select2/dist/css/select2.min.css',
        'plugins/bootstrap-select/bootstrap-select.min.css',
        'plugins/multiselect/css/multi-select.css',
    ];
    public $js = [
        //'plugins/jquery/jquery.min.js',
        'plugins/moment/moment.js',
        'plugins/bootstrap/js/popper.min.js',
        'plugins/bootstrap/js/bootstrap.min.js',
        'js/perfect-scrollbar.jquery.min.js',
        'js/waves.js',
        'js/sidebarmenu.js',
        'js/custom.min.js',
        'plugins/sparkline/jquery.sparkline.min.js',
        'plugins/chartist-js/dist/chartist.min.js',
//        'plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js',
//        'plugins/d3/d3.min.js',
        'plugins/c3-master/c3.min.js',
        'plugins/toast-master/js/jquery.toast.js',
//        'js/dashboard1.js',
        'plugins/styleswitcher/jQuery.style.switcher.js',
        'plugins/bootstrap-daterangepicker/daterangepicker.js',
        'plugins/bootstrap-datepicker/bootstrap-datepicker.min.js',
        'js/clipboard.min.js', //剪切板
        'js/jquery.qrcode.min.js', //二维码
        'js/circleChart.js', //饼状图
        'plugins/select2/dist/js/select2.full.min.js',
        'plugins/bootstrap-select/bootstrap-select.min.js',
        'plugins/multiselect/js/jquery.multi-select.js',
    ];
    public $depends = [
    ];
}

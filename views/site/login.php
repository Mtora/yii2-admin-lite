<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\assets\GtAsset;
GtAsset::register($this);

$this->title = '系统登录 - GS后台';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<body class="card-no-border">
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
    <div class="loader">
        <div class="loader__figure"></div>
        <p class="loader__label"></p>
    </div>
</div>
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<section id="wrapper">
    <div class="login-register" style="background: #EEEEEE">
        <div class="login-box card">
            <div class="card-body">
                <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => true]); ?>
                <h3 class="box-title m-b-20">GS后台登录</h3>
                <?= $form
                    ->field($model, 'username', $fieldOptions1)
                    ->label(false)
                    ->input('username', ['placeholder' => '用户名']) ?>
                <?= $form
                    ->field($model, 'password', $fieldOptions2)
                    ->label(false)
                    ->passwordInput(['placeholder' => '密码']) ?>
                <div class="form-group row">
                    <div id="embed-captcha"></div>
                </div>
                <p id="wait" class="show" style="margin-top: -12px;">正在加载验证码......</p>
                <p id="notice" class="hide" style="margin-top: -12px;">请先完成验证</p>
                <div class="form-group row">
                    <div class="col-md-12">
                        <div class="checkbox checkbox-info pull-left p-t-0">
                            <?= Html::checkbox('is_auto_login',false, ['id'=>'checkbox-signup','class' => 'filled-in chk-col-light-blue'])?>
                            <label for="checkbox-signup"> 一周免登录</label>
                        </div>
                    </div>
                </div>
                <div class="form-group text-center">
                    <div class="col-xs-12 p-b-20">
                    <?= Html::submitButton('登录', ['id'=>'embed-submit','class' => 'btn btn-block btn-lg btn-info btn-rounded', 'name' => 'login-button']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="/plugins/bootstrap/js/popper.min.js"></script>
<script src="/plugins/bootstrap/js/bootstrap.min.js"></script>
<!--Custom JavaScript -->
<script type="text/javascript">
    $(function() {
        $(".preloader").fadeOut();
    });
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    });
    // ==============================================================
    // Login and Recover Password
    // ==============================================================
    $('#to-recover').on("click", function() {
        $("#login-form").slideUp();
        $("#recoverform").fadeIn();
    });
</script>

</body>

</html>
<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = '个人设置';

$fieldOptions1 = [
    'options' => ['class' => 'form-group row has-feedback'],
];
?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">个人设置</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">个人设置</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">个人设置</h4>
                <div class="col-sm-12">
                    <?php
                    $tpl = Yii::$app->params['activeFormTpl'];
                    $form = ActiveForm::begin(array_merge($tpl['form'], array('action' => '/my/edit-submit')));
                    ?>
                    <?= $form->field($model, 'email',$fieldOptions1)->input('email', ['readonly' => true,'disabled' => true]) ?>
                    <?= $form->field($model, 'nickname',$fieldOptions1)->textInput(['readonly' => true,'disabled' => true]) ?>

                    <div class="form-group row">
                        <label class="col-sm-2 control-label text-right">&nbsp;</label>
                        <div class="col-sm-10">
                            <?= Html::submitButton('保存', ['class' => 'btn btn-primary', 'disabled' => true]) ?>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">修改密码</h4>
                <?php if($no_reg == 1) :?>
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>警告：</strong> 你使用的密码过于简单，请尽快修改！<br>密码至少由8位以上不连续不重复的字符、数字及符号中的至少两种组成。
                    </div>
                <?php endif;?>
                <?php
                $tpl = Yii::$app->params['activeFormTpl'];
                $form = ActiveForm::begin(array_merge($tpl['form'], array('action' => '/my/password-submit')));
                ?>
                <?= $form->field($model, 'password_old',$fieldOptions1)->passwordInput() ?>
                <?= $form->field($model, 'password',$fieldOptions1)->passwordInput()->label('新密码') ?>
                <?= $form->field($model, 'password_repeat',$fieldOptions1)->passwordInput() ?>

                <div class="form-group row">
                    <label class="col-sm-2 control-label text-right">&nbsp;</label>
                    <div class="col-sm-10">
                        <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
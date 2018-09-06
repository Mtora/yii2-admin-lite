<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = '系统管理 - 帐号管理 - 添加帐号';

$fieldOptions1 = [
    'options' => ['class' => 'form-group row has-feedback'],
];
?>

<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">账号管理</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">系统管理</li>
            <li class="breadcrumb-item active"><a href="/user">账号管理</a></li>
            <li class="breadcrumb-item active">添加账号</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <?php
                    $tpl = Yii::$app->params['activeFormTpl'];
                    $form = ActiveForm::begin(array_merge($tpl['form'], array('action' => '/user/add-submit')));
                    ?>
                    <?= $form->field($model, 'username',$fieldOptions1)->textInput() ?>
                    <?= $form->field($model, 'nickname',$fieldOptions1)->textInput() ?>
                    <?= $form->field($model, 'email',$fieldOptions1)->input('email') ?>
                    <div class="form-group row field-roles">
                        <label class="col-sm-2 control-label text-right" for="roles">所属角色</label>
                        <div class="col-sm-6">
                            <?php foreach ($roles as $role):?>
                                <input type="checkbox" id="<?=$role->name?>" name="User[role][]" value="<?=$role->name?>" class="filled-in chk-col-blue-grey"><label for="<?=$role->name?>"> <?=$role->name?></label><br/>
                            <?php endforeach;?>
                            <br/>
                            <input type="hidden" name="User[is_admin]" value="0">
                            <input type="checkbox" id="is_admin" name="User[is_admin]" value="1" class="filled-in chk-col-blue-grey"><label for="is_admin"> 超级管理员</label><br/>
                        </div>
                        <div class="col-sm-4"><div class="help-block"></div></div>
                    </div>

                <div class="form-group row">
                        <label class="col-sm-2 control-label text-right">&nbsp;</label>
                        <div class="col-sm-10">
                            <?= Html::submitButton('添加', ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
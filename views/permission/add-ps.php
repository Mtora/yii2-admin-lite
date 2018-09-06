<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = '系统管理 - 权限配置 - 添加权限';
?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">添加权限</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">系统管理</li>
            <li class="breadcrumb-item active"><a href="/user">账号管理</a></li>
            <li class="breadcrumb-item active"><a href="/add">添加权限</a></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <?php
                $tpl = Yii::$app->params['activeFormTpl'];
                $form = ActiveForm::begin(array_merge($tpl['form'], array('action' => '/permission/add-ps-submit')));
                ?>
                <div class="form-group row field-ps-desc required">
                    <label class="col-sm-2 control-label text-right" for="ps-desc">权限名称</label>
                    <div class="col-sm-6"><input type="text" id="ps-desc" class="form-control" name="ps-desc"></div>
                    <div class="col-sm-4"><div class="help-block"></div></div>
                </div>

                <div class="form-group row field-ps-name required">
                    <label class="col-sm-2 control-label text-right" for="ps-name">可访问URI</label>
                    <div class="col-sm-6"><input type="text" id="ps-name" class="form-control" name="ps-name"></div>
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
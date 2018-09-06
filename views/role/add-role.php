<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\AppAsset;
use app\assets\GijgoAsset;

AppAsset::register($this);

$this->title = '系统管理 - 权限配置 - 添加角色';

$this->registerJs(<<<JS

JS
);
?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <form id="role-form" class="form-horizontal" action="/role/add-role-submit" method="post">
                    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->csrfToken?>">
                    <div class="form-group row field-role-name required">
                        <label class="col-sm-2 control-label text-right" for="role-name">角色名</label>
                        <div class="col-sm-6"><input type="text" id="role-name" class="form-control" name="role-name"></div>
                        <div class="col-sm-4"><div class="help-block"></div></div>
                    </div>

                    <div class="form-group row field-role-desc required">
                        <label class="col-sm-2 control-label text-right" for="role-desc">角色描述</label>
                        <div class="col-sm-6"><input type="text" id="role-desc" class="form-control" name="role-desc"></div>
                        <div class="col-sm-4"><div class="help-block"></div></div>
                    </div>

                    <div class="form-group row field-role-ps[]">
                        <label class="col-sm-2 control-label text-right" for="role-ps[]">权限列表</label>
                        <div class="col-sm-6">
                        <?php foreach ($pss as $ps):?>
                            <input type="checkbox" id="<?=$ps->name?>" name="role-ps[]" value="<?=$ps->name?>" class="filled-in chk-col-blue-grey"><label for="<?=$ps->name?>"> <?=$ps->name?>(<?=$ps->description?>)</label><br/>
                        <?php endforeach;?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 control-label text-right">&nbsp;</label>
                        <div class="col-sm-10">
                            <?= Html::submitButton('添加', ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
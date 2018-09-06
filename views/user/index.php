<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\helpers\ArrayHelper;

use app\models\User;

Url::remember();

$this->title = '系统管理 - 帐号管理';
?>

<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">账号管理</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">系统管理</li>
            <li class="breadcrumb-item active"><a href="/user">账号管理</a></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="dt-buttons pull-right">
                    <a href="<?= Url::to(['user/add']) ?>" class="btn btn-primary">添加帐号</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover toggle-circle tablet breakpoint footable-loaded footable" style="width: 99%">
                    <tbody>
                    <thead>
                        <tr>
                            <th style="min-width: 80px;">UID</th>
                            <th style="min-width: 180px;">登录名</th>
                            <th style="min-width: 180px;">真实姓名</th>
                            <th style="min-width: 180px;">所属角色</th>
                            <th style="min-width: 180px;">创建时间</th>
                            <th style="min-width: 350px;">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($models as $model) : ?>
                        <tr>
                            <td><?=$model['uid']?></td>

                            <?php if($model['status'] == User::STATAS_BLOCK_CODE):?>
                            <td><i class="fa fa-lock" title="帐号已被禁用" data-toggle="tooltip"></i> <strike><?=$model['email']?></strike>
                                <?php else:?>
                            <td><?=$model['email']?>
                                <?php endif?>
                                <?=$model['is_admin'] == 1 ? ' <i class="fa fa-user-secret" title="超级管理员" data-toggle="tooltip"></i>' : ''?></td>

                            <td><?=$model['nickname']?></td>
                            <td>
                                <?=implode(' | ', ArrayHelper::getColumn($auth->getRolesByUser($model['uid']), 'name'))?>&nbsp;
                            </td>
                            <td><?=$model['ctime']?></td>
                            <td>
                                <a href="<?=Url::to(['user/reset-password','uid' => $model['uid']])?>" class="label btn-primary"><i class="fa fa-refresh"></i> 重设密码</a> &nbsp;
                                <a href="<?=Url::to(['user/edit','uid' => $model['uid']])?>" class="label btn-primary"><i class="fa fa-edit"></i> 编辑</a> &nbsp;

                                <?php if($model['status'] == User::STATAS_BLOCK_CODE):?>
                                    <a href="<?=Url::to(['user/enable-user','uid' => $model['uid']])?>" class="label btn-info"><i class="fa fa-unlock-alt"></i> 启用</a> &nbsp;
                                <?php else:?>
                                    <a href="<?=Url::to(['user/disable-user','uid' => $model['uid']])?>" class="label btn-warning"><i class="fa fa-lock"></i> 禁用</a> &nbsp;
                                <?php endif?>

                                <a href="<?=Url::to(['user/del-submit','uid' => $model['uid']])?>" class="label btn-danger"><i class="fa fa-trash"></i> 删除</a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                    <tfoot>
                        <?php if(!empty($pagination)):?>
                        <td colspan="6" class="footable-visible">
                            <div style="">
                                <?php echo LinkPager::widget([
                                    'pagination' => $pagination,
                                    'prevPageLabel' => false ,
                                    'nextPageLabel' => false ,
                                    'options' => ['class' => 'pagination'],
                                    'pageCssClass' => 'footable-page',
                                ]); ?>
                            </div>
                        </td>
                        <?php endif?>
                    </tfoot>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>

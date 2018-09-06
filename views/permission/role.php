<?php
use yii\helpers\Url;
use app\assets\AppAsset;

AppAsset::register($this);

use app\models\User;

Url::remember();

$this->title = '系统管理 - 权限配置';
?>

<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">角色管理</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">系统管理</li>
            <li class="breadcrumb-item active"><a href="/permission/index">角色管理</a></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="dt-buttons pull-right">
                    <a href="<?= Url::to(['permission/add-role']) ?>" class="btn btn-primary">添加角色</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover toggle-circle tablet breakpoint footable-loaded footable" style="width: 99%">
                        <thead>
                        <tr>
                            <th>角色名</th>
                            <th>权限列表</th>
                            <th>描述</th>
                            <th width="200">创建时间</th>
                            <th width="200">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($roles as $role) : ?>
                            <tr>
                                <td><?=$role->name?></td>
                                <td>
                                    <?php foreach($auth->getPermissionsByRole($role->name) as $ps):?>
                                        <?=$ps->description?><br/>
                                    <?php endforeach;?>
                                </td>
                                <td><?=$role->description?></td>
                                <td><?=date('Y-m-d H:i:s', $role->createdAt)?></td>
                                <td>
                                    <a href="<?=Url::to(['permission/edit-role','rolename' => $role->name])?>" class="label label-primary"><i class="fa fa-edit"></i> 编辑</a>&nbsp;
                                    <a href="<?=Url::to(['permission/del-role-submit','rolename' => $role->name])?>" class="label label-danger"><i class="fa fa-trash"></i> 删除</a>
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
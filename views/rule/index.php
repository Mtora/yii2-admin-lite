<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\helpers\ArrayHelper;

use app\models\User;

Url::remember();

$this->title = '系统管理 - 规则管理';
?>

<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">规则管理</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">系统管理</li>
            <li class="breadcrumb-item active"><a href="/user">规则管理</a></li>
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
                            <th>名称</th>
                            <th>对应规则类</th>
                            <th>创建时间</th>
                            <th>修改时间</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($models as $model) : ?>
                        <tr>
                            <td><?=$model['name']?></td>
                            <td><?=$model['data']?></td>
                            <td><?=$model['created_at']?></td>
                            <td><?=$model['updated_at']?></td>
                            <td>
                                <a href="<?=Url::to(['rule/edit','uid' => $model['name']])?>" class="label btn-primary"><i class="fa fa-edit"></i> 编辑</a> &nbsp;
                                <a href="<?=Url::to(['rule/del-submit','uid' => $model['name']])?>" class="label btn-danger"><i class="fa fa-trash"></i> 删除</a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                    <tfoot>
                        <?php if(!empty($pagination)):?>
                        <td colspan="5" class="footable-visible">
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

<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\models\LoginForm */

app\assets\DatePickerAsset::register($this);
$this->registerJs("$('.datepicker').datepicker({'format':'yyyy-mm-dd'});");

$this->title = '游戏设置';
?>

<section>
    <div class="row">
        <div class="col-xs-12">
            
            <div class="callout callout-info">
                <h4>UI 模板 （此模板仅在开发环境下可查看）</h4>
                提示信息
            </div>
            
            <div class="box">
                <div class="box-header">
                    <ol class="breadcrumb">
                        <li class="active">数据集合示例 
                        <li ><a href="#" class="label label-primary">添加数据</a></li>
                    </ol>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered table-hover table-striped">
                                <tbody>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Task</th>
                                        <th style="width: 40px">Label</th>
                                        <th style="width:135px">operation</th>
                                    </tr>
                                    <tr>
                                        <td>1.</td>
                                        <td>Update software</td>
                                        <td><span class="badge bg-red">55%</span></td>
                                        <td><a href="#" class="label label-primary"><i class="fa fa-edit"></i> 编辑</a> &nbsp; <a href="#" class="label label-danger"><i class="fa fa-trash"> 删除</a></td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Clean database</td>
                                        <td><span class="badge bg-yellow">70%</span></td>
                                        <td><a href="#" class="label label-primary"><i class="fa fa-edit"></i> 编辑</a> &nbsp; <a href="#" class="label label-danger"><i class="fa fa-trash"> 删除</a></td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>Update software</td>
                                        <td><span class="badge bg-green">90%</span></td>
                                        <td><a href="#" class="label label-primary"><i class="fa fa-edit"></i> 编辑</a> &nbsp; <a href="#" class="label label-danger"><i class="fa fa-trash"> 删除</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                
                <div class="box-footer clearfix">
                    <ul class="pagination pagination-sm no-margin pull-right">
                      <li><a href="#">«</a></li>
                      <li><a href="#">1</a></li>
                      <li><a href="#">2</a></li>
                      <li><a href="#">3</a></li>
                      <li><a href="#">»</a></li>
                    </ul>
                  </div>
                
            </div>
            <!-- /.box -->
        </div>
    </div>


</section>

<section>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <ol class="breadcrumb">
                        <li class=""><a href="<?= \yii\helpers\Url::to(['template/index', '#' => 'list'])?>">数据集合示例</a></li>
                        <li class="active">表单示例</li>
                    </ol>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <?php
                            
                            $form = ActiveForm::begin($tpl['form']); ?>
                                
                                <?= $form->field($model, 'username')->textInput(['id' => 'username']) ?>
                                <?= $form->field($model, 'password')->passwordInput() ?>
                                <?= $form->field($model, 'email') ?>
                                <?= $form->field($model, 'sex', $tpl['radio'])->radioList(['1' => '男', '0' => '女']) ?>
                                <?= $form->field($model, 'age')->textInput() ?>
                                <?= $form->field($model, 'photo')->fileInput() ?>
                                <?= $form->field($model, 'hobby', $tpl['checkbox'])->checkboxList($hobby) ?>
                                <?= $form->field($model, 'hobby', $tpl['select'])->dropDownList($hobby) ?>
                                <?= $form->field($model, 'birthday')->textInput(['class' => 'datepicker', 'style' => 'border-radius:0;', 'value' => date('Y-m-d')]) ?>
                                <?= $form->field($model, 'info')->textarea(['style' => 'height:100px']) ?>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label text-right">&nbsp;</label>
                                    <div class="col-sm-10">
                                        <?= Html::submitButton('添加', ['class' => 'btn btn-primary']) ?>
                                    </div>
                                </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                
                
            </div>
            <!-- /.box -->
        </div>
    </div>


</section>

<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;


$this->title = 'GS后台 - v1.0';

$this->registerJs(<<<JS
    
    $('#cre_code').bind('click', function() {
        $(this).unbind('click');
        var url = $("#url").attr('href');
        $('#code').html = $('#code').qrcode(url);
    });

    var current = $("#current").text();
    var diff = $("#diff").text();
    var total = parseInt(current)+parseInt(diff);
    var cur = parseInt(current) * 100 / parseInt(total);
    var level = $("#hid").text();
    $("#circleChart").circleChart({
          value: cur,
          startAngle: 180,
          speed: 3000,
          text:level,
   });
    
    new Clipboard('.a_copy_url').on('success', function(e) {
            //e.clearSelection();
            $(e.trigger).tooltip({trigger: 'manual', title:"已复制"});
            $(e.trigger).tooltip('show');
            setTimeout(function(){
                $(e.trigger).tooltip('hide');
                $(e.trigger).tooltip('destroy');
            }, 1000);
        });
JS
);

?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"></font></font></h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-4">
        <div class="card bg-info">
            <div class="card-body">
                <div class="d-flex no-block" style="height: 120px">
                    <div class="m-r-20 align-self-center"><img src="/images/icon/income-w.png"></div>
                    <div class="align-self-center">
                        <h6 class="text-white m-t-10 m-b-0"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">今日付费</font></font></h6>
                        <h2 class="m-t-0 text-white"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"><?= $data['day_money']?></font></font></h2></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card bg-success">
            <div class="card-body">
                <div class="d-flex no-block" style="height: 120px">
                    <div class="m-r-20 align-self-center"><img src="/images/icon/assets-w.png"></div>
                    <div class="align-self-center">
                        <h6 class="text-white m-t-10 m-b-0"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">今日新增设备</font></font></h6>
                        <h2 class="m-t-0 text-white"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"><?= $data['day_device']?></font></font></h2></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card bg-primary">
            <div class="card-body">
                <div class="d-flex no-block" style="height: 120px">
                    <div class="m-r-20 align-self-center"><img src="/images/icon/staff-w.png"></div>
                    <div class="align-self-center">
                        <h6 class="text-white m-t-10 m-b-0"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">今日活跃账号</font></font></h6>
                        <h2 class="m-t-0 text-white"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"><?= $data['day_user']?></font></font></h2></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div>
                        <h4 class="card-title"><span class="lstick"></span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">我的等级</font></font></h4></div>
                    <div class="ml-auto">
                        <i class="ti-help-alt"></i>
                        <a href="<?php echo yii\helpers\Url::to(['/level']); ?>">规则介绍</a>
                    </div>
                </div>
                <div id = 'hid' style="display: none"><?= $level['level']?></div>
                <div id = 'circleChart'>
                </div>


                <table class="table vm font-14 m-b-0">
                    <tbody><tr>
                        <td class="b-0">当前积分</td>
                        <td class="text-right font-medium b-0" id = 'current'><?= $level['all_score']?></td>
                    </tr>
                    <tr>
                        <td>本月新增</td>
                        <td class="text-right font-medium"><?= $level['month_score']?></td>
                    </tr>
                    <tr>
                        <td>距下一级还差</td>
                        <td class="text-right font-medium" id = 'diff'><?= $level['diff']?></td>
                    </tr>
                    </tbody></table>
            </div>
        </div>
    </div>

    <div class="col-lg-8 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="">
                    <div class="d-flex">
                        <div>
                            <h4 class="card-title"><span class="lstick"></span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">我的游戏</font></font></h4></div>
                    </div>
                    <table class="table vm no-th-brd pro-of-month">
                        <thead>
                        <tr>
                            <th>游戏名称</th>
                            <th>推广链接</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($game['models'])):?>
                        <?php foreach ($game['models'] as $model) : ?>
                            <tr>
                                <td><?=$game['game'][$model['game_id']]['game_name']?></td>
                                <td>
                                    <a id = "url"  href="<?=$model->getPsreadUrl()?>" target="_blank"><?=$model->getPsreadUrl()?></a>
                                    <a href="javascript:;" class="a_copy_url label btn-warning pull-right" data-clipboard-text="<?=$model->getPsreadUrl()?>"><span class="fa fa-copy"></span> 复制URL</a></td>
                                <td>
                                    <span id = "cre_code" class="label btn-danger" onclick=""><i class="fa fa-gratipay"></i> 生成二维码
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach;?>
                        <?php else:?>
                            <tr><td class="text-center" colspan="3">抱歉,暂无数据!</td></tr>
                        <?php endif;?>
                        </tbody>
                        <tfoot>
                        <?php if(!empty($game['pagination'])):?>
                            <tr>
                                <td colspan="3" class="footable-visible">
                                    <div style="">
                                        <?php echo LinkPager::widget([
                                            'pagination' => $game['pagination'],
                                            'prevPageLabel' => false ,
                                            'nextPageLabel' => false ,
                                            'options' => ['class' => 'pagination'],
                                            'pageCssClass' => 'footable-page',
                                        ]); ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endif;?>
                        </tfoot>
                    </table>
                    <div id="code"></div>
                </div>
            </div>
        </div>
    </div>
</div>

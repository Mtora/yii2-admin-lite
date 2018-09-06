<?php
$c = \Yii::$app->controller;

$items = [];

if(in_array('/site/',$left))
$items[] = ['label' => '首页','url' => ['/site'],
    'template' =>
        '<a class="waves-effect waves-dark" href="{url}" aria-expanded="true">
            <i class="mdi mdi-home"></i>
            <span class="hide-menu">{label}</span>
        </a>'
];
//$items[] = ['label' => '排行榜','url' => ['/a1'],
//    'template' =>
//        '<a class="waves-effect waves-dark" href="{url}" aria-expanded="true">
//            <i class="mdi mdi-nutrition"></i>
//            <span class="hide-menu">{label}</span>
//        </a>'
//];
if(in_array('/spreadsta/',$left))
$items[] = ['label' => '推广数据','url' => ['/spreadsta'],
    'template' =>
        '<a class="waves-effect waves-dark" href="{url}" aria-expanded="true">
            <i class="mdi mdi-matrix"></i>
            <span class="hide-menu">{label}</span>
        </a>'
];
if(in_array('/chargelist/',$left))
$items[] = ['label' => '充值详单','url' => ['/chargelist'],
    'template' =>
        '<a class="waves-effect waves-dark" href="{url}" aria-expanded="true">
            <i class="mdi mdi-cash-multiple"></i>
            <span class="hide-menu">{label}</span>
        </a>'
];
//$items[] = ['label' => '角色查询','url' => ['/a4'],
//    'template' =>
//        '<a class="waves-effect waves-dark" href="{url}" aria-expanded="true">
//            <i class="mdi mdi-account-search"></i>
//            <span class="hide-menu">{label}</span>
//        </a>'
//];
if(in_array('/my-game/',$left))
$items[] = ['label' => '我的游戏','url' => ['/my-game'],
    'template' =>
        '<a class="waves-effect waves-dark" href="{url}" aria-expanded="true">
            <i class="mdi mdi-carrot"></i>
            <span class="hide-menu">{label}</span>
        </a>'
];
if(in_array('/level/',$left))
$items[] = ['label' => '推广等级','url' => ['/level'],
    'template' =>
        '<a class="waves-effect waves-dark" href="{url}" aria-expanded="true">
            <i class="mdi mdi-trending-up"></i>
            <span class="hide-menu">{label}</span>
        </a>'
];
//项目组管理
$groupItems = [];
if(in_array('/group/',$left)) {
    $groupItems[] = ['label' => '团部管理', 'url' => ['/group']];
}
if(in_array('/group-item/',$left)) {
    $groupItems[] = ['label' => '团员管理', 'url' => ['/group-item']];
}
if(in_array('/change-normal/',$left)) {
    $groupItems[] = ['label' => '转正管理', 'url' => ['/change-normal']];
}
if(in_array('/change-normal/',$left)) {
    $groupItems[] = ['label' => '培训人员管理', 'url' => '/change-normal/train-user'];
}

//if($c->can_v2('/groupsta/index')) {
//    $groupItems[] = ['label' => '小组统计', 'url' => ['/groupsta/index']];
//}

//绩效奖金
if(in_array('/bonus/',$left))
    $items[] = ['label' => '绩效奖金','url' => ['/bonus'],
        'template' =>
            '<a class="waves-effect waves-dark" href="{url}" aria-expanded="true">
            <i class="mdi mdi-matrix"></i>
            <span class="hide-menu">{label}</span>
        </a>'
    ];

if($groupItems) {
    $items[] = ['label' => '项目组管理','url' => '#','items' => $groupItems,
        'template' =>
            '<a class="has-arrow waves-effect waves-dark" href="{url}" aria-expanded="true">
                <i class="mdi mdi-account-multiple"></i>
                <span class="hide-menu">{label}</span>
            </a>'
    ];
}

$sysItems = [];
//if($c->can_v2('/rule/')) {
//    $sysItems[] = ['label' => '规则管理', 'url' => ['/rule']];
//}

if(in_array('/role/',$left)) {
    $sysItems[] = ['label' => '角色配置', 'url' => ['/role']];
}

if(in_array('/ps/',$left)) {
    $sysItems[] = ['label' => '权限配置', 'url' => ['/ps']];
}
if(in_array('/user/',$left)) {
    $sysItems[] = ['label' => '账号管理', 'url' => ['/user']];
}
//if($c->can_v2('/syslog/')) {
//    $sysItems[] = ['label' => '操作日志', 'url' => ['/syslog']];
//}
if($sysItems) {
    $items[] = ['label' => '系统管理','url' => '#','items' => $sysItems,
        'template' =>
            '<a class="has-arrow waves-effect waves-dark" href="{url}" aria-expanded="true">
                <i class="mdi mdi-wrench"></i>
                <span class="hide-menu">{label}</span>
            </a>'
    ];
}
?>
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <?= \yii\widgets\Menu::widget([
                'options' => ['id' => 'sidebarnav', 'class' => 'in'],
                'items' => $items,
            ])?>
            <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
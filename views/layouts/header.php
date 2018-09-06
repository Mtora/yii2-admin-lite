<?php
use yii\helpers\Html;

$c = \Yii::$app->controller;
?>
<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-light">
        <!-- ============================================================== -->
        <!-- Logo -->
        <!-- ============================================================== -->
        <div class="navbar-header">
            <a class="navbar-brand" href="/">
                <!-- Logo icon --><b>
                    <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                    <!-- Dark Logo icon -->
                    <img src="../images/logo-icon.png" alt="homepage" class="dark-logo" />
                    <!-- Light Logo icon -->
                    <img src="../images/logo-light-icon.png" alt="homepage" class="light-logo" />
                </b>
                <!--End Logo icon -->
                <!-- Logo text --><span>
                         <!-- dark Logo text -->
                         <img src="../images/logo-text.png" alt="homepage" class="dark-logo" />
                    <!-- Light Logo text -->
                         <img src="../images/logo-light-text.png" class="light-logo" alt="homepage" /></span> </a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav mr-auto">
                <!-- This is  -->
                <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                <li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>

            </ul>
            <!-- ============================================================== -->
            <!-- User profile and search -->
            <!-- ============================================================== -->
            <ul class="navbar-nav my-lg-0">
                <!-- ============================================================== -->
                <!-- Profile -->
                <!-- ============================================================== -->
                <li class="nav-item">
                    <div class="btn-group">
                        <label class="btn label-link"><i class="icon node-icon ti-user"></i> <?= $usr?></label>
                    </div>
                    <!--<div class="btn-group" role="group">-->
                        <a href="/my" class="btn btn-info btn-sm" style="width: 77px;">
                            <i class="fa fa-user-o"></i> 个人设置
                        </a>
                        <a href="/my/logout" class="btn btn-danger btn-sm" style="width: 77px;">
                            <i class="fa fa-power-off"></i> 退&nbsp;&nbsp;&nbsp;&nbsp;出
                        </a>
                    <!--</div>-->

                </li>
            </ul>
        </div>
    </nav>
</header>

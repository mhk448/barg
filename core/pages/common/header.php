<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<? // define(_HELP_PATH_, 'http://type.elmend.ir/') ?>
<? define(_HELP_PATH_, ''); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title><?php echo $_CONFIGS['Page']['Title'] ?></title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'></meta>
        <meta name="description" content="<?php echo $_CONFIGS['Page']['Description'] ?>" ></meta>
        <meta name="keywords" content="<?php echo $_CONFIGS['Page']['Keywords'] ?>" />
        <link rel="shortcut icon" href="<?= $_CONFIGS['Site']['Sub']['Path'] . $subSite ?>_favicon.ico" />
        <link rel="stylesheet" href="<?= _HELP_PATH_ ?>medias/styles/reset.css?v=5" type="text/css" />
        <link rel="stylesheet" href="<?= _HELP_PATH_ ?>medias/styles/sideMenu.css?v=5" type="text/css" />
        <link rel="stylesheet" href="<?= _HELP_PATH_ ?>medias/styles/style.css?v=9" type="text/css" />
        <link rel="stylesheet" href="<?= _HELP_PATH_ ?>medias/styles/header-footer.css?v=5" type="text/css" />
        <link rel="stylesheet" href="<?= _HELP_PATH_ ?>medias/styles/panel.css?v=5" type="text/css" />
        <link rel="stylesheet" href="<?= _HELP_PATH_ ?>medias/styles/<?= $subSite ?>/spcss.css" type="text/css" />
        <!--[if lte IE 8]> <link href="medias/styles/ie.css" rel="stylesheet" type="text/css"> <![endif]-->
        <!--<script type="text/javascript" src="medias/scripts/jquery-typeonline.js"></script>-->
        <script type="text/javascript" src="<?= _HELP_PATH_ ?>medias/scripts/jquery-2.0.0.min.js"></script>
        <!--<script type="text/javascript" src="http://code.jquery.com/jquery-2.0.0.min.js"></script>-->
        <script type="text/javascript" src="<?= _HELP_PATH_ ?>medias/scripts/jquery-migrate-1.2.1.min.js"></script>
        <!--<script type="text/javascript" src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>-->
        <script type="text/javascript" src="<?= _HELP_PATH_ ?>medias/scripts/jquery.upload-1.0.2.min.js"></script>
        <script type="text/javascript" src="<?= _HELP_PATH_ ?>medias/scripts/jquery-ui.min.js" ></script>
        <!--<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>-->
        <script type="text/javascript" src="<?= _HELP_PATH_ ?>medias/scripts/jquery.countdown.min.js"></script>


        <script type="text/javascript" src="<?= _HELP_PATH_ ?>medias/scripts/mhkform.js?v=6"></script>
        <script type="text/javascript" src="<?= _HELP_PATH_ ?>medias/scripts/mhkhelp.js?v=1"></script>
        <script type="text/javascript" src="<?= _HELP_PATH_ ?>medias/scripts/event.js?v=5"></script>
        <script type="text/javascript" src="<?= _HELP_PATH_ ?>medias/scripts/custom.js?v=8"></script>
        <script type="text/javascript" src="<?= _HELP_PATH_ ?>medias/bootstrap/js/bootstrap.min.js"></script> 
        <script type="text/javascript" src="<?= _HELP_PATH_ ?>medias/scripts/app.js"></script> 
        <script type="text/javascript" src="<?= _HELP_PATH_ ?>medias/scripts/jquery.slimscroll.min.js"></script> 
        <script type="text/javascript" src="<?= _HELP_PATH_ ?>medias/scripts/jquery.timeago.js" ></script>
        <!-- Bootstrap 3.3.2 -->
        <link href="<?= _HELP_PATH_ ?>medias/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />    
        <!-- FontAwesome 4.3.0 -->
        <!--<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />-->
        <link href="<?= _HELP_PATH_ ?>medias/styles/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons 2.0.0 -->

        <!--<link href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />-->    
        <!-- Theme style -->
        <link href="<?= _HELP_PATH_ ?>medias/styles/AdminLTE.css" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. Choose a skin from the css/skins 
             folder instead of downloading all of them to reduce the load. -->
        <link href="<?= _HELP_PATH_ ?>medias/styles/skin-green.css" rel="stylesheet" type="text/css" />




    </head>
    <body class="skin-green fixed" >
        <script type="text/javascript">
            serverTime = <?= time(); ?>000;
            serverTime_diff = serverTime - (new Date().getTime());
            subSite = '<?= $subSite; ?>';
            theme_bg_color = '<?= $_CONFIGS['Site'][$subSite]['bg_color'] ?>';
            curUser = {};
        </script>
        <? if ($user->isSignin()) { ?>
            <script type="text/javascript">
                curUser.id = <?= $user->id ?>;
                curUser.nickname = '<?= $user->getNickname(); ?>';
                curUser.feature = '<?= $user->feature ?>';
            </script>
        <? } ?>
        <center class="wrapper">
            <div id="help_cover" style="display: none" onmouseover="$('#help_cover').hide();">
                <div id="help_arrow"> </div>
                <div style="
                     background-image: url('medias/images/icons/trans.png');
                     padding: 5px;
                     ">
                    <div class="br-theme" style="
                         border-style: solid;
                         border-width: 3px;
                         background-color: #EEE;
                         ">
                        <img src="/medias/images/icons/helper.png" style="float: left;width: 50px;margin-top: 10px;"/>
                        <div id="help_box" style="padding: 10px;" >
                            help menu
                        </div>
                        <div style="clear: both"></div>
                    </div>
                </div>
            </div>
            <div id="user_cover" style="display: none" onmouseover="$('#user_cover').hide();">
                <div id="help_arrow"> </div>
                <div style="
                     background-image: url('medias/images/icons/trans.png');
                     padding: 0px;
                     ">
                    <div class="br-theme" style="
                         border-style: solid;
                         border-width: 3px;
                         background-color: #EEE;
                         ">
                        <div id="user_box" style="padding: 10px;" >
                            help menu
                        </div>
                        <div style="clear: both"></div>
                    </div>
                </div>
            </div>
            <a id="ddda" class="transition"></a>























            <header class="main-header">
                <!-- Logo -->
                <a href="/panel" class="logo">
                    <img src="medias/images/theme/logoWhite.png" alt="برگردون" height="45" />
                    <span style="margin-top: -5px">
                    برگردون
                    </span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?= $_CONFIGS['Site']['Path'] . 'user/avatar/UA_' . $user->id . '.png' ?>" class="user-image" alt="User Image"/>
                                    <span class="hidden-xs"><?= $user->getNickname(); ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="<?= $_CONFIGS['Site']['Path'] . 'user/avatar/UA_' . $user->id . '.png' ?>" class="img-circle" alt="User Image" />
                                        <p>
                                            <?= $user->fullname ?>
                                            <small><?= $_ENUM2FA['usergroup'][$user->usergroup] ?></small>


                                            <div class="">
                                                <span style="color: black;" >میزان اعتبار:</span>
                                                <span class="price" ><?= $user->getCredit() ?></span>
                                                ریال
                                            </div>



                                            <? if ($user->locked_credits) { ?>
                                                <div class="">
                                                    <span style="color: black;" >اعتبار گروگذاری شده:</span>
                                                    <span class="price" ><?= $user->locked_credits ?></span>
                                                    ریال
                                                </div>
                                            <? } ?>
                                            <div class="">
                                                <? if ($user->isWorker()) { ?>


                                                    <div class="">
                                                        <span style="color: black;" >مقام های کسب شده:</span>
                                                        <span style="margin-bottom: -5px;"><?= ($user->displayCups($user->rate) ? $user->displayCups($user->rate) : 'هیچ مقامی کسب نشده') ?></span>
                                                    </div>


                                                    <div class="">
                                                        <span style="color: black;" >رتبه ی شما در بین مجریان:</span>
                                                        <span style="margin-bottom: -5px;"><?= $user->rate ?></span>
                                                    </div>

                                                    <div class="help">
                                                        <span style="color: black;">پروژه های انجام شده:</span>
                                                        <? echo $user->finished_projects ?>
                                                    </div>
                                                    <div class="help_comment">
                                                        پروژه هایی که با رضایت کارفرما به پایان رسیده است
                                                    </div>
                                                    <div class="help">
                                                        <span style="color: black;">پروژه های نا موفق:</span>
                                                        <? echo $user->rejected_projects ?>
                                                    </div>
                                                    <div class="help_comment">
                                                        پروژه هایی که باعث نارضایتی کارفرما شده است
                                                    </div>
                                                <? } else { ?>
                                                    <span style="color: black;">پروژه های ارسالی:</span>
                                                    <? echo $user->finished_projects ?>
                                                <? } ?>
                                            </div>


                                            <div id="sidebar-moreinfo" style="display: none">
                                                <div class="" style="display: none">
                                                    <span style="color: black;">درجه:</span>
                                                    <!--            <div class="classification">
                                                                    <div class="cover"></div>
                                                                    <div class="progress" style="width: <? //echo ($user->rank * 10) . '%;'                                                                     ?>">
                                                                    </div>
                                                                </div>-->
                                                    <?= ($user->rate) . ' از 7' ?>
                                                </div>

                                                <div class="" style="display: none">
                                                    <span style="color: black;">مبلغ پروژه ها:</span>
                                                    <? echo $user->getSumPriceProject(); ?>
                                                    ریال
                                                </div>


                                                <? if ($user->isWorker()) { ?>
                                                    <div class="">
                                                        <span style="color: black;">میانگین امتیاز:</span>
                                                        <?= (($user->rankers == 0) ? $user->rank : number_format($user->rank / $user->rankers, 2)) ?> 
                                                    </div>
                                                <? } ?>

                                                <? if ($user->isWorker()) { ?>
                                                    <div class="">
                                                        <span style="padding-left: 5px;color: black;">تخصص :</span>
                                                        <? echo $user->getAbility(TRUE); ?>
                                                    </div>
                                                <? } ?>
                                            </div>

                                            <div style="clear: both"/>

                                        </p>
                                    </li>
                                    <!-- Menu Body -->
                                    <!--                                    <li class="user-body">
                                                                            <div class="col-xs-4 text-center">
                                                                                <a href="#">Followers</a>
                                                                            </div>
                                                                            <div class="col-xs-4 text-center">
                                                                                <a href="#">Sales</a>
                                                                            </div>
                                                                            <div class="col-xs-4 text-center">
                                                                                <a href="#">Friends</a>
                                                                            </div>
                                                                        </li>-->
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-right">
                                            <a href="user_<?= $user->id ?>" class="btn btn-default btn-flat"> مشخصات</a>
                                        </div>
                                        <div class="pull-left">
                                            <a href="users_logout" class="btn btn-default btn-flat">خروج</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <!-- Messages: style can be found in dropdown.less-->
                            <li class="dropdown messages-menu" style="display: none;">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-envelope-o"></i>
                                    <span class="label label-danger"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have 4 messages</li>
                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <ul class="menu">
                                            <li><!-- start message -->
                                                <a href="#">
                                                    <div class="pull-right">
                                                        <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
                                                    </div>
                                                    <h4>
                                                        Support Team
                                                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                    </h4>
                                                    <p>Why not buy a new awesome theme?</p>
                                                </a>
                                            </li><!-- end message -->
                                            <li>
                                                <a href="#">
                                                    <div class="pull-right">
                                                        <img src="dist/img/user3-128x128.jpg" class="img-circle" alt="user image"/>
                                                    </div>
                                                    <h4>
                                                        AdminLTE Design Team
                                                        <small><i class="fa fa-clock-o"></i> 2 hours</small>
                                                    </h4>
                                                    <p>Why not buy a new awesome theme?</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <div class="pull-right">
                                                        <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="user image"/>
                                                    </div>
                                                    <h4>
                                                        Developers
                                                        <small><i class="fa fa-clock-o"></i> Today</small>
                                                    </h4>
                                                    <p>Why not buy a new awesome theme?</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <div class="pull-right">
                                                        <img src="dist/img/user3-128x128.jpg" class="img-circle" alt="user image"/>
                                                    </div>
                                                    <h4>
                                                        Sales Department
                                                        <small><i class="fa fa-clock-o"></i> Yesterday</small>
                                                    </h4>
                                                    <p>Why not buy a new awesome theme?</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <div class="pull-right">
                                                        <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="user image"/>
                                                    </div>
                                                    <h4>
                                                        Reviewers
                                                        <small><i class="fa fa-clock-o"></i> 2 days</small>
                                                    </h4>
                                                    <p>Why not buy a new awesome theme?</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="footer"><a href="#">See All Messages</a></li>
                                </ul>
                            </li>
                            <!-- Notifications: style can be found in dropdown.less -->
                            <li class="dropdown notifications-menu mhkevent-win" id="topmenu-event">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bell-o"></i>
                                    <span class="label label-warning" id="mhkevent-counter">0</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">
                                        رخدادهای جدید
                                    </li>
                                    <li>
                                        <ul class="menu content">
                                            <div style="display: none"></div>
                                        </ul>
                                    </li>
                                    <li class="footer">
                                        <a href="events" class="ajax">
                                            +نمایش همه...
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!-- Tasks: style can be found in dropdown.less -->
                            <!--                            <li class="dropdown tasks-menu">
                                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                                <i class="fa fa-flag-o"></i>
                                                                <span class="label label-danger">9</span>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                <li class="header">You have 9 tasks</li>
                                                                <li>
                                                                     inner menu: contains the actual data 
                                                                    <ul class="menu">
                                                                        <li> Task item 
                                                                            <a href="#">
                                                                                <h3>
                                                                                    Design some buttons
                                                                                    <small class="pull-left">20%</small>
                                                                                </h3>
                                                                                <div class="progress xs">
                                                                                    <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                                                        <span class="sr-only">20% Complete</span>
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                        </li> end task item 
                                                                        <li> Task item 
                                                                            <a href="#">
                                                                                <h3>
                                                                                    Create a nice theme
                                                                                    <small class="pull-left">40%</small>
                                                                                </h3>
                                                                                <div class="progress xs">
                                                                                    <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                                                        <span class="sr-only">40% Complete</span>
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                        </li> end task item 
                                                                        <li> Task item 
                                                                            <a href="#">
                                                                                <h3>
                                                                                    Some task I need to do
                                                                                    <small class="pull-left">60%</small>
                                                                                </h3>
                                                                                <div class="progress xs">
                                                                                    <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                                                        <span class="sr-only">60% Complete</span>
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                        </li> end task item 
                                                                        <li> Task item 
                                                                            <a href="#">
                                                                                <h3>
                                                                                    Make beautiful transitions
                                                                                    <small class="pull-left">80%</small>
                                                                                </h3>
                                                                                <div class="progress xs">
                                                                                    <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                                                        <span class="sr-only">80% Complete</span>
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                        </li> end task item 
                                                                    </ul>
                                                                </li>
                                                                <li class="footer">
                                                                    <a href="#">View all tasks</a>
                                                                </li>
                                                            </ul>
                                                        </li>-->

                        </ul>
                    </div>
                </nav>
            </header>











            <?
            include_once 'side-menu.php';
            ?>
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
<!--                <section class="content-header">
                    <h1>
                        Dashboard
                        <small>Control panel</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section>-->

                <!-- Main content -->
                <section class="content">

                    <div>
                        <div class="" >
                            <div id="ajax_content" class="left_panel2">


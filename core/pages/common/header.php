<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<? // define(_HELP_PATH_, 'http://type.elmend.ir/') ?>
<? define(_HELP_PATH_, ''); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title><?php echo $_CONFIGS['Page']['Title'] ?></title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <meta name="description" content="<?php echo $_CONFIGS['Page']['Description'] ?>" />
        <meta name="keywords" content="<?php echo $_CONFIGS['Page']['Keywords'] ?>" />
        <link rel="shortcut icon" href="<?= $_CONFIGS['Site']['Sub']['Path'].$subSite ?>_favicon.ico" />
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
        <script type="text/javascript" src="<?= _HELP_PATH_ ?>medias/scripts/event.js?v=5"></script>
        <script type="text/javascript" src="<?= _HELP_PATH_ ?>medias/scripts/custom.js?v=8"></script>
    </head>
    <body >
        <script type="text/javascript">
            curUser={};
        </script>
        <? if ($user->isSignin()) { ?>
            <script type="text/javascript">
                curUser.id = <?= $user->id ?>;
                curUser.nickname = '<?= $user->getNickname(); ?>';
                curUser.feature = '<?= $user->feature ?>';
            </script>
        <? } ?>
        <center>
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
            <div id="header-wrapper">
                <div id="header">
                    <? include 'header-top-menu.php'; ?>
                    <div style=" background-color: white;
                         /*background-image: url('cmedias/images/theme/typeiran_logo_bg.png');*/
                         /*background-image: url('medias/images/theme/bg-home.png');*/
                         background: url('medias/images/theme/body-bg.png') repeat scroll 0 0 #FFFFFF;
                         /*display: none;*/
                         border-bottom-style: solid ;
                         border-bottom-width: 10px ;
                         padding: 20px;
                         "
                         onclick=""
                         class="br-theme"
                         >
                        <div style="float: right;
                             width: 23%;
                             text-align: right;
                             padding: 3px 9px;
                             display: none;
                             color: #FFF;">

                            <? if (FALSE && $user->isUser()) { ?>

                                <!--<div style="display: none">-->
                                <img src="<?= $_CONFIGS['Site']['Path'] ?>user/avatar/UA_<?= $user->id ?>.png" width="50" style="float: right;margin: 5px" />
                                <?= $user->getNickname() ?>
                                <br/>

                                <!--</div>-->
                                <div class="bg-theme" style2="
                                     text-align: right;
                                     border-radius: 3px;
                                     color: white;
                                     font-weight: bold;
                                     box-shadow: 1px 1px 2px 0 #333;
                                     margin-bottom: 30px;
                                     padding: 8px 5px" >
                                    <div style2="
                                         border-top:  1px dashed gray;
                                         border-bottom:  1px dashed gray;
                                         padding: 5px 0;
                                         ">

                                        <span style2="padding-left: 5px;color: black;width: 125px;float: right;text-align: left;">درجه:</span>
                                        <!--            <div class="classification">
                                                        <div class="cover"></div>
                                                        <div class="progress" style="width: <? //echo ($user->rank * 10) . '%;'                             ?>">
                                                        </div>
                                                    </div>-->
                                        <?= ($user->rate) . ' از 7' ?>

                                        <br/><span style2="padding-left: 5px;color: black;width: 125px;float: right;text-align: left;">گروه کاربری: </span>
                                        <?= $_ENUM2FA['usergroup'][$user->usergroup] ?>

                                        <? if ($user->isWorker()) { ?>
                                            <br/><span style2="padding-left: 5px;color: black;width: 125px;float: right;text-align: left;">میانگین امتیاز:</span>
                                            <?= (($user->rankers == 0) ? $user->rank : number_format($user->rank / $user->rankers, 2)) ?> 
                                        <? } ?>

                                        <? if ($user->isWorker()) { ?>
                                            <br/><span style2="padding-left: 5px;color: black;width: 125px;float: right;text-align: left;">پروژه های انجام شده:</span>
                                        <? } else { ?>
                                            <br/><span style2="padding-left: 5px;color: black;width: 125px;float: right;text-align: left;">پروژه های ارسالی:</span>
                                        <? } ?>
                                        <?= $user->finished_projects ?>

                                        <br/><span style2="padding-left: 5px;color: black;width: 125px;float: right;text-align: left;">مبلغ پروژه ها:</span>
                                        <?= $user->getSumPriceProject(); ?> ریال

                                        <br/><span style2="padding-left: 5px;color: black;width: 125px;float: right;text-align: left;">میزان اعتبار:</span>
                                        <span class="price" ><?= $user->getCredit() ?></span>
                                        ریال


                                    </div>
                                </div>
                            <? } ?>
                        </div>
                        <img style=""
                             alt=""
                             src="medias/images/theme/<?=$subSite;?>_panel_header.png"
                             height="100"
                             />
                        <div class="clear"></div>
                    </div>

                    <div style="height: 25px;
                         background-image: url('medias/images/theme/sub_menu_bg.jpg');
                         background-repeat: repeat-x;
                         text-align: left;
                         padding: 5px;
                         display: none;
                         ">


                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <div>

                <!--[if gte IE 9]>
                    <style type="text/css">
                      .gradient {
                         filter: none;
                      }
                    </style>
                 <![endif]-->

                <div class="" >
                    <div class="right_panel2" style="">
                        <?
                        include_once 'side-menu.php';
                        ?>
                    </div>
                    <div id="ajax_content" class="left_panel2">


<?
//$list = $pager->getList('events', '*', "WHERE (`type`='" . Event::$T_PROJECT . "' OR `type`='" . Event::$T_BID . "') And `action`<>'" . Event::$A_RECEIVE . "' And `action`<>'" . Event::$A_P_FINAL_FILE_SUBMIT . "' ", 'ORDER BY dateline DESC', NULL, 1);
$list = array();

$a = ENUM2FA_Event();
$prj_count = 0;
$typist_count = $database->selectCount('users_sub', "WHERE usergroup ='Worker'");
$sum_price_count = 0;
$sum_page_count = 0;
define(_HELP_PATH_, '');

//$system->getAll();
//$users_top = json_decode($system->homeRate_userTop['value'], TRUE);
//$users_active = json_decode($system->homeRate_userActive['value'], TRUE);

//
//
//
//
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title><?php echo $_CONFIGS['Page']['Title'] ?></title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <meta name="description" content="<?php echo $_CONFIGS['Page']['Description'] ?>" />
        <meta name="keywords" content="<?php echo $_CONFIGS['Page']['Keywords'] ?>" />
        <link rel="shortcut icon" href="<?= $_CONFIGS['Site']['Sub']['Path'].$subSite ?>_favicon.ico" />
        <script type="text/javascript" src="<?= _HELP_PATH_ ?>medias/scripts/jquery-2.0.0.min.js" ></script>
        <script type="text/javascript" src="<?= _HELP_PATH_ ?>medias/scripts/jquery-migrate-1.2.1.min.js"></script>
        <!--<script type="text/javascript" src="medias/scripts/jquery.upload-1.0.2.min.js"></script>-->
        <script type="text/javascript" src="<?= _HELP_PATH_ ?>medias/scripts/mhkform.js"></script>
        <script type="text/javascript" src="<?= _HELP_PATH_ ?>medias/scripts/event.js"></script>
        <script type="text/javascript" src="<?= _HELP_PATH_ ?>medias/scripts/custom.js?v=6"></script>
        <script type="text/javascript" src="<?= _HELP_PATH_ ?>medias/scripts/home.js?v=6"></script>
        <script type="text/javascript" src="<?= _HELP_PATH_ ?>medias/scripts/jquery-ui.min.js" ></script>

        <link rel="stylesheet" href="<?= _HELP_PATH_ ?>medias/styles/sideMenu.css" type="text/css" />
        <!--[if lte IE 8]> <link href="medias/styles/ie.css" rel="stylesheet" type="text/css"> <![endif]-->
        <link rel="stylesheet" href="<?= _HELP_PATH_ ?>medias/styles/reset.css" type="text/css" />
        <link rel="stylesheet" href="<?= _HELP_PATH_ ?>medias/styles/style.css?v=7" type="text/css" />
        <link rel="stylesheet" href="<?= _HELP_PATH_ ?>medias/styles/header-footer.css" type="text/css" />
        <link rel="stylesheet" href="<?= _HELP_PATH_ ?>medias/styles/home.css?v=7" type="text/css" />
        <link rel="stylesheet" href="<?= _HELP_PATH_ ?>medias/styles/panel.css" type="text/css" />
        <link rel="stylesheet" href="<?= _HELP_PATH_ ?>medias/styles/<?= $subSite ?>/spcss.css" type="text/css" />
    </head>
    <body >
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
            <a id="ddda" class="transition"></a>
            <div id="header-wrapper">
                <div id="header">
                    <? include 'core/pages/common/header-top-menu.php'; ?>

                    <div class="big-header-bg transition" style="
                         background-image:url('medias/images/theme/bg-home.png');
                         " >
                        <div style="
                             height: 70px;
                             ">
                            <div style="float: left;margin-left: 100px">

                                امروز
                                <?
                                $pd = new PersianDate();
                                echo $pd->date("l d F Y");
                                ?>
                                | <span id="curTime"></span>
                            </div>
                        </div>
                        <img 
                            style="margin-top: -30px;cursor: pointer"
                            alt=""
                            src="medias/images/theme/translateiran_logo.png"
                            onclick="$('#ddd').slideUp();$('#dde').slideUp();$('#fff').slideDown();"
                            />
                        <br/>
                         مرکز تخصصی ترجمه و  جامعه مجازی مترجمین ایران
                        <br/>

                        <div id="fff">
                            <div  style="
                                  margin: 60px 70px;
                                  display: inline-block;
                                  ">
                                <a href="#ddda">

                                    <img 
                                        class="transition"
                                        alt=""
                                        src="medias/images/theme/translate_user.png"
                                        style="

                                        " 
                                        onclick="$('#ddd').slideDown();$('#ddd2').fadeIn(2000);$('#fff').slideUp();"

                                        /> 
                                </a>
                                <br/><br/>
                                پروژه ترجمه خود را به طور رایگان ثبت کنید
                            </div>

                            <div  style="
                                  display: inline-block;
                                  ">
                                <img 

                                    style=""
                                    alt=""
                                    src="medias/images/theme/line2.png"
                                    /> 
                            </div>
                            <div  style="
                                  margin: 60px 70px;
                                  display: inline-block;
                                  ">
                                <a href="#ddda">

                                    <img 
                                        class="transition"
                                        alt=""
                                        src="medias/images/theme/translate_worker.png"
                                        style="
                                        cursor: pointer;

                                        "
                                        onclick="$('#dde').slideDown();$('#dde2').fadeIn(2000);$('#fff').slideUp();"
                                        /> 
                                </a>
                                <br/><br/>

                                به همراه 
                                <?= $typist_count ?>      
                                مترجم سایت کسب درآمد کنید
                            </div>

                        </div>

                    </div>

                    <div id="ddd"
                         style="height: 380px;
                         display: none;
                         background-color: #dddddd; 
                         "
                         >
                        <div id="ddd2"
                             style="display: none;
                             "
                             >

                            <div 
                                style="height: 50px;
                                "
                                >

                            </div>
                            <br/>
                            <img src="medias/images/theme/submiteperoject.png"/><br/>
                            &nbsp; &nbsp; تمکمیل اطلاعات و ثبت سفارش &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; انتخاب مجری و گروگذاری وجه &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;  &nbsp; &nbsp;دریافت فایل و آزاد سازی وجه
                            <br/><br/><br/>
                            <form action="submit-project" method="POST">
                                <input style="padding: 4px;
                                       width: 200px;"
                                       type="text"
                                       name="t"
                                       id="t"
                                       placeholder="عنوان"
                                       class="help"
                                       />
                                <div class="help_comment" >
                                    برای پروژه ی خود یک نام انتخاب نمایید
                                </div>
                                <br/>
                                <br/>
                                <select class="help" name="lan" id="lan"  style="padding: 2px;width: 208px">
                                    <?
                                    foreach ($_ENUM2FA['lang'] as $key => $value) {
                                        echo '<option value="' . $key . '" ' . $l[$key] . '>' . $value . '</option>';
                                    }
                                    ?>
                                </select>
                                <div class="help_comment" >
                                    زبان ترجمه خود را انتخاب نمایید
                                </div>
                                <br/>
                                <br/>
                                <? if ($user->isWorker()) { ?>
                                    <input type="button" onclick="mhkform.ajax('ajax-pages?page=fastreg&afterlink=submit-project%3Ft%3D'+$('#t').val()+'%26lan%3D'+$('#lan').val())" value="ثبت نام به عنوان کارفرما" class="active_btn"/>
                                <? } else if ($user->isSignin()) { ?>
                                    <input type="submit" value="ادامه و تکمیل اطلاعات" class="active_btn"/>
                                <? } else { ?>
                                    <input type="button" onclick="mhkform.ajax('ajax-pages?page=fastreg&afterlink=submit-project%3Ft%3D'+$('#t').val()+'%26lan%3D'+$('#lan').val())" value="ادامه و تکمیل اطلاعات" class="active_btn"/>
                                <? } ?>
                            </form>

                        </div>
                    </div>
                    <div id="dde"
                         style="height: 380px;
                         display: none;
                         background-color: #dddddd; 
                         "
                         >
                        <div id="dde2"
                             style="display: none;
                             "
                             >

                            <div 
                                style="height: 50px;
                                "
                                >

                            </div>
                            <br/>
                            <img src="medias/images/theme/signup-typist.png"/><br/>
                            ثبت نام و تکمیل مشخصات 
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                            شرکت در پروژه ها و دریافت کار 
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;  &nbsp; 
                            ارسال فایل و دریافت پول
                            <br/><br/><br/>
                            <? if (!$user->isSignin()) { ?>
                                <form action="users" method="post" name="SignupForm">
                                    <input type="hidden" value="LoginForm" name="formName"/>
                                    <input style="padding: 4px;
                                           width: 200px;
                                           "
                                           id="un"
                                           name="un"
                                           placeholder="نام کاربری"
                                           />
                                    <br/>
                                    <br/>
                                    <input  style="padding: 4px;
                                            width: 200px;
                                            "
                                            type="password"
                                            name="pw"
                                            placeholder="رمز عبور"
                                            />
                                    <br/>
                                    <br/>
                                    <input class="active_btn" type="submit" value="ورود"
                                           name="submit"
                                           /> 
                                    <input class="active_btn" type="button" value="ثبت نام"
                                           onclick="mhkform.redirect('register?type=worker&un='+$('#un').val())"
                                           /> 
                                </form>
                            <? } else { ?>
                                <a class="active_btn" href="projects_open?typeonline=1">
                                    نمایش لیست پروژه های آنلاین
                                </a>
                                <br/>
                                <br/>
                                <a class="active_btn" href="projects_open">
                                    نمایش لیست تمام پروژه ها
                                </a>
                            <? } ?>

                        </div>
                    </div>
                    <div class="body">
                        <div style="width:28%;background-image: url('medias/images/theme/description_2_r.png')" class="description1 transition hour-theme">

                            <h2>
                                ترجمه از فایل و اسکن
                            </h2><div>

                                شما به راحتی می توانید هر تعداد صفحه جهت ترجمه دارید، اسکن و یا عکس گرفته و آن را بر روی سایت ارسال کرده و همینطور با تقسیم آن به چند بخش می توان حجم زیادی را در مدت کوتاهی ترجمه شده دریافت کنید...
                                <div class="line"></div>
                            </div>
                        </div>
                        <div style="width:28%;background-image: url('medias/images/theme/description_3_r.png')" class="description2 transition hour-theme">

                            <h2>
                                ترجمه از فایل صوتی
                            </h2><div>

                                کافیست فایل ترجمه خود را خوانده و صدای خود را ضبط کنید و فایل ضبط شده را ارسال کنید و همینطور با تقسیم آن به چند بخش با توجه به تعداد زیاد مترجم ها می توان حجم زیادی را در مدت کوتاهی ترجمه شده دریافت کنید...
                                <div class="line"></div>
                            </div>
                        </div>
                        <div style="width:28%;background-image: url('medias/images/theme/description_1_r.png')" class="description3 transition hour-theme">

                            <h2>
                                جذب نمایندگی
                            </h2><div>

                                قابل توجه کلیه کافی نت ها و مراکز ترجمه، شما می توانید با دریافت پنل نمایندگی با قیمت بسیار مناسب یک پشتیبان قدرتمند برای سفارشات ترجمه خود با توجه به تعداد مترجم های سایت، داشته باشید ....
                                <br/><br/><div class="line"></div>
                            </div>
                        </div>
                    

                    </div>

                    <div class="bg-theme">
                        <div class="counter2 transition" >
                            <span>
                                پروژه ها
                            </span>
                            <div class="price" id="prj_count">
                                <?= $prj_count ?>
                            </div>
                        </div>
                        <div class="counter2 transition" >
                            <span>
                                مترجم ها
                            </span>
                            <div class="price" id="typist_count">
                                <?= $typist_count ?>
                            </div>
                        </div>
                        <div class="counter2 transition" >
                            <span>
                                صفحات ترجمه شده
                            </span>
                            <div class="price" id="sum_page_count">
                                <?= $sum_page_count ?>
                            </div>
                        </div>
                        <div class="counter2 transition" >
                            <span>
                                مبلغ پروژه ها
                            </span>
                            <div class="price" id="sum_price_count">
                                <?= $sum_price_count ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="clear"></div>
            <div>
                <div>
                    <div  class="right_panel" style="background-color: #bfbfbf;padding: 20px;">
                        <div style="background-color: #ea1c73;padding:2px;margin-bottom: 1px; font-size: 13pt; color:white; ">
                            خدمات ترجمه در فضایی امن
                        </div>
                        <!--<img src="medias/images/theme/fut-icon3.png" id="homeside-icon"/>-->
                        <div id="side-home-text-bt1" class="transition side-home-text">
                            <iframe src="/iframe.htm" frameborder="0" scrolling="no" allowtransparency="true" style="width: 150px; height:150px;"></iframe>
                        </div>
                        <!--                        <div style="background-color:#ffa800;padding:2px;margin-bottom: 1px; margin-top:10px; font-size: 13pt; color:white; ">
                                                    اولین انجمن تخصصی ترجمه کشور
                                                </div>
                                                <img src="medias/images/theme/fut-icon2.png" id="homeside-icon"/>
                                                <div id="side-home-text-bt2" class="transition side-home-text">
                                                    <p >
                                                        تالار گفتمان  ، اولین و تنها انجمن تخصصی ترجمه کشور هست که کلیه دوستداران این تخصص می توانند در آن به ارسال پست و ارتباط بین سایر فعالان و بحث و گفتگو بپردازند....</p>
                                                    <p style="text-align:left;"><a herf="#" id="side-home-link"> ادامه مطلب</a>
                                                    </p>
                                                </div>-->
                        <div style="background-color: #396cc4;padding:2px;margin-bottom: 1px; margin-top:10px; font-size: 13pt; color:white; ">
                            نظرات و پیشنهادات
                        </div>
                        <img src="medias/images/theme/icon-3.png" id="homeside-icon"/>
                        <div id="side-home-text-bt3" class="transition side-home-text">
                            <p >
                              این مرکز به دلیل اینکه سیستمی دوجانبه بین کاربر و مترجم می باشد جهت بالا بردن سطح کیفی سایت از تمامی شما عزیزان دعوت می نماید تا پیشنهادات و نظرات خود را برای هر چه بهتر شدن ارسال نمایید...
                            </p>
<!--                            <p style="text-align:left;"><a herf="#" id="side-home-link"> ادامه مطلب</a>
                            </p>-->
                        </div>
                        <div style="background-color: #ffa800;padding:2px;margin-bottom: 1px; margin-top:10px; font-size: 13pt; color:white; ">
                             توییت ترجمه
                        </div>
                        <img src="medias/images/theme/fut-icon3.png" id="homeside-icon"/>
                        <div id="side-home-text-bt2" class="transition side-home-text">
                            <p >
                                از اهداف مهم این مرکز ایجاد نخستین جامعه مجازی مترجم های ایران بوده که در این راستا اقدام به ایجاد بخشپ توئیت نموده، توییت مکانی برای به اشتراک گذاشتن ایده ها، نظرات و گفتگو بین فعالان این فن در فضای مجازی با هدف همبستگی، مشارکت و پیشرفت می باشد...
                            </p>
<!--                            <p style="text-align:left;"><a herf="#" id="side-home-link"> ادامه مطلب</a>
                            </p>-->
                        </div>
                        <div class="clear"></div>
                    </div>





                    <div  class="" style="">

                        <div id="last_events" class="transition">
                            <div style="
                                 padding-top: 30px;
                                 font-size: 22px;

                                 " >
                                آخرین رویدادها
                            </div>
                            <div class="block_body">
                                <div class=""
                                     style="height: 17px;background-color: #bfbfbf;color: white;" >
                                    در جریان کار باشید ...
                                </div>
                                <div class="" style="border-bottom: solid 3px #bfbfbf;text-align: right;">
                                    <table style="width: 70%;" class="home-project" >
                                        <thead>
                                            <tr>
                                                <th>
                                                    عنوان
                                                </th>
                                                <th>
                                                    وضعیت
                                                </th>
                                                <th style="font-size: 10px">
                                                    تعداد
                                                    <br/>
                                                    صفحات
                                                </th>
                                                <th style="display:none">
                                                    زبان
                                                </th>
<!--                                                <th>
                                                    نوع
                                                </th>-->
                                                <th>
                                                    تخمین قیمت
                                                </th>
                                                <th>
                                                    کارفرما
                                                </th>
                                                <th>
                                                    تاریخ                            
                                                </th>
                                                <th>
                                                    رخداد                            
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="livetbody" class="">
                                            <?
                                            foreach ($list as $e) {
                                                $p = new Project($e['ref_id']);
                                                ?>
                                                <tr>
                                                    <td>
                                                        <? if ($p->verified > 0 || $p->user_id == $user->id || $p->typist_id == $user->id) { ?>
                                                            <a href="project_<?= $p->id ?>" class="dark"><?= $p->title ?></a>
                                                        <? } else { ?>
                                                            <a href="#" class="dark"><?= $p->title ?></a>
                                                        <? } ?>
                                                    </td>
                                                    <td>
                                                        <?= $_ENUM2FA['state'][$p->state] ?>
                                                    </td>
                                                    <td>
                                                        <?= $p->guess_page_num ?>
                                                    </td>
                                                    <td style="display:none">
                                                        <?= $_ENUM2FA['lang'][$p->lang] ?>
                                                    </td>
                                                    <td>
                                                        <?= $_ENUM2FA['type'][$p->type] ?>
                                                    </td>
                                                    <td>
                                                        <?= $p->max_price ?>
                                                    </td>
                                                    <td>
                                                        <?= $user->getNickname($p->user_id) ?>
                                                    </td>
                                                    <td>
                                                        ----
                                                    </td>
                                                    <td>
                                                        <?= $a[$e['type']][$e['action']] ?>
                                                    </td>
                                                </tr>
                                            <? } ?>
                                            <tr>
                                                <td colspan="9">

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!--<div style="text-align: right;">-->
                                    <!--                                        <a class="dark" style="padding: 5px;" href="projects_all">
                                                                                + نمایش کامل
                                                                            </a>-->
                                    <!--</div>-->

                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>




<?if(false){?>
                    <div style="">
                        <div style="padding-top: 20px;">
                            <div class="bg-theme" style="">
                                <br/>
                            </div>
                            <div class="" style="margin-top:-20px;">
                                <div class="" style="width:5%;display:inline-block">
                                    <img src="medias/images/type/text_best_worker.png" style="width:34px;" />
                                </div>
                                <?
                                $users = $database->fetchAll($database->select('users_sub', '*', 'WHERE usergroup = \'Worker\' AND verified >0 ORDER BY (rank / (rankers+0.2) + finished_projects /50 - rejected_projects) DESC LIMIT 7'));
                                $i = 1;
                                foreach ($users as $us) {
                                    $u = new User($us['id']);
                                    echo $u->displayMiniInfo(true, true, true, $i++);
                                }
                                ?>
                                <div class="" style="width:5%;display:inline-block"></div>
                            </div>
                        </div>


                        <div style="padding-top: 20px;">
                            <div class="bg-theme" style="">

                                <div class="" style="width:36%;display:inline-block;">
                                   مترجم‌های برتر هفت روز گذشته
                                </div>
                                <div class="" style="width:17%;display:inline-block">
                                </div>
                                <div class="" style="width:36%;display:inline-block">
                                    مترجم‌های فعال هفت روز گذشته
                                </div>
                            </div>
                            <div class="" style="margin-top:-1px;">

                                <?
                                foreach ($users_top as $us) {
                                    $u = new User($us);
                                    echo $u->displayMiniInfo(true, true, true);
                                }
                                ?>
                                <div class="user-mini-info" style="padding:0px;background:none;">
                                    <!--<img src="medias/images/theme/typeiran_logo.png" alt="" style="width:90%"/>-->
                                    <br/>
                                    <br/>
                                    <br/>
                                </div>
                                <?
                                foreach ($users_active as $us) {
                                    $u = new User($us);
                                    echo $u->displayMiniInfo(true, true, true);
                                }
                                ?>
                            </div>
                        </div>
<?}?>

                        <div class="clear"></div>

                        <?

                        function createSliderTopUser2($u, $rate) {
                            global $_CONFIGS, $message;
                            ?>

                            <div class="bg-shadow top-user" style="">

                                <div class="" style="z-index: 1;">
                                    <div style="background-color: #c1b180;">
                                        <a <?= 'href="user_' . $u->id . '"' ?> class="dark" target="_blank">
                                            مترجم برتر
                                        </a>
                                    </div>
                                    <span class="username">
                                        <?= $u->getNickname() ?>
                                    </span>
                                    </a>
                                    <br/>
                                    <a <?= 'href="user_' . $u->id . '"' ?> class="" target="_blank">
                                        <img class="avator" align="absmiddle" <?= 'src="' . $_CONFIGS['Site']['Path'] . 'user/avatar/UA_' . $u->id . '.png"'; ?> />
                                    </a>
                                    رتبه:
                                    <?= $u->rate ?>
                                    <br/>
                                    <br/>
                                    <!--سرعت ترجمه:-->
                                    <!--345--> 
                                    <div style="background-color: #c1b180;padding: 5px">

                                        امتیاز:
                                        <br/>
                                        <? $message->displayRank($u->rank, $u->rankers); ?>

                                    </div>
                                </div>
                                <div class="bg-trans cover-layer transition" style="">
                                    <div class="" style="">
                                        <br/>
                                        <br/>
                                        <br/>
                                        <br/>
                                        <a href<?= '="user_' . $u->id . '"' ?> class="active_btn" target="_blank">
                                            نمایش سابقه
                                        </a>
                                        <br/>
                                        <br/>
                                        <a href<?= '="submit-project?private_typist_id=' . $u->id . '&pt=Private"' ?> class="active_btn">
                                            سفارش  کار
                                        </a>

                                    </div>
                                </div>

                            </div>

                            <?
                        }
                        ?>
                        <script type="text/javascript">initHelpBox();update();</script>

                        <?
                        if (false) {
//                            $content = '</br>';
                            $content = '<img src="/uploads/type/twitt/F1398198054788U50I0.jpg" width="600" />';
//                            $content = '<img src="/uploads/type/twitt/F1398195579975U50I0.jpg" width="600" />';
//                            $content .= '</br>';
                            ?>
                            <script type="text/javascript">mhkform.open('<?= $content ?>');</script>
                        <? } ?>

                        <? include 'core/pages/common/footer.php'; ?>

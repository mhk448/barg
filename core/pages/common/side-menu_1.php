<?php
/*
 * In The Name of GOD
 * @author MHK448
 * Email: MHK448@gmail.com
 * Created at: May 13, 2013 , 6:27:47 PM
 * mhkInfo:
 */
/* @var $user User */
//$user->usergroup="User";
//if($user->usergroup=="Guest" ) 
//    return;
?>
<div class="tools block" style="box-shadow: none;" id="side_menu">
    <div style="
         margin-bottom: 5px;
         background-image: url('medias/images/theme/bg-home.png');
         text-align: center;
         border-radius: 7px;
         display: none;
         ">
        <div class="bg-gradian" style="
             padding: 8px;
             ">
            <img src="medias/images/theme/bargardoon_logo.png" style="width: 70%"  />
        </div>
    </div>
    <? if ($user->isUser()) { ?>



        <div  style="
              /*text-align: center;*/
              background: url('medias/images/theme/body-bg.png') repeat scroll 0 0 #FFFFFF;

              /*border-radius: 3px;*/
              /*color: white;*/
              padding: 5px;
              font-weight: bold;
              /*box-shadow: 1px 1px 2px 0 #333;*/
              margin-bottom: 10px;
              border-top-width: 8px ;
              border-top-style: solid;
              border-bottom-width: 8px ;
              border-bottom-style: solid;
              " class="br-theme"  >

            <div class="bg-gradian" style="
                 /*border-top:  1px dashed gray;*/
                 /*border-bottom:  1px dashed gray;*/
                 padding: 5px;
                 ">

                <div style="">

                    <img class="user-avator" style="float: right;margin: 5px;" src<?= '="' . $_CONFIGS['Site']['Path'] . 'user/avatar/UA_' . $user->id . '.png"' ?> width="50" height="50" >

                    <div style="">
                        <div class="bg-gradian" style="">
                            <?// $user->fullname ?>
                        </div>
                        <div class="bg-gradian">
                            <?= $user->getNickname() ?>
                        </div>

                        <div class="bg-gradian">
                                                <!--<span style="padding-left: 5px;color: black;">گروه کاربری: </span>-->
                            <?= $_ENUM2FA['usergroup'][$user->usergroup] ?>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>



                <div class="bg-gradian">
                    <span style="color: black;" >میزان اعتبار:</span>
                    <span class="price" ><?= $user->getCredit() ?></span>
                    ریال
                </div>



                <? if ($user->locked_credits) { ?>
                    <div class="bg-gradian">
                        <span style="color: black;" >اعتبار گروگذاری شده:</span>
                        <span class="price" ><?= $user->locked_credits ?></span>
                        ریال
                    </div>
                <? } ?>
                <div class="bg-gradian">
                    <? if ($user->isWorker()) { ?>


                        <div class="bg-gradian">
                            <span style="color: black;" >مقام های کسب شده:</span>
                            <span style="margin-bottom: -5px;"><?= ($user->displayCups($user->rate) ? $user->displayCups($user->rate) : 'هیچ مقامی کسب نشده') ?></span>
                        </div>


                        <div class="bg-gradian">
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
                    <div class="bg-gradian" style="display: none">
                        <span style="color: black;">درجه:</span>
                        <!--            <div class="classification">
                                        <div class="cover"></div>
                                        <div class="progress" style="width: <? //echo ($user->rank * 10) . '%;'                                                                   ?>">
                                        </div>
                                    </div>-->
                        <?= ($user->rate) . ' از 7' ?>
                    </div>

                    <div class="bg-gradian" style="display: none">
                        <span style="color: black;">مبلغ پروژه ها:</span>
                        <? echo $user->getSumPriceProject(); ?>
                        ریال
                    </div>


                    <? if ($user->isWorker()) { ?>
                        <div class="bg-gradian">
                            <span style="color: black;">میانگین امتیاز:</span>
                            <?= (($user->rankers == 0) ? $user->rank : number_format($user->rank / $user->rankers, 2)) ?> 
                        </div>
                    <? } ?>

                    <? if ($user->isWorker()) { ?>
                        <div class="bg-gradian">
                            <span style="padding-left: 5px;color: black;">تخصص :</span>
                            <? echo $user->getAbility(TRUE); ?>
                        </div>
                    <? } ?>
                </div>
                <div class="bg-gradian" style="cursor: pointer;text-align: center" onclick="$('#sidebar-moreinfo').slideToggle();">
                    ..:: 
                    اطلاعات بیشتر
                    ::..
                </div>


            </div>
        </div>
    <? } ?>
    <!--    <div class="head" >
            منو اصلی
        </div>-->
    <!--    <div class="sub_head" >
            منوی کاربری
        </div>-->
    <div class="content">
        <ul id="menu" class="raw">
            <? if ($user->isSignin()) { ?>
                <?
                if ($user->isAdmin() || $user->isBookkeeper()) {
                    $ka = "";
                    $ca = $report->countNewAgency();
                    $crr = $project->countNewReviewRequests();
                    $cs = $personalmessage->countNewSupport();
                    $cpm = $report->countNewPayments();
                    $cpo = $report->countNewPayouts();
                    ?>
                    <li>
                        <a class=""><div class="menu-img item2"></div>

                            پروژه ها و کاربران</a>

                        <ul style="display: none;">
                            <!--<li><a class="side-ajax" href="manage-projects?new=1">پروژه های جدید</a></li>-->
                            <!--<li><a class="side-ajax" href="manage-users?new=1">کاربران جدید </a></li>-->
                            <li><a class="side-ajax" href="manage-users-online">کاربران آنلاین </a></li>
                            <li><a class="side-ajax" href="manage-users" >تمام کاربران</a></li>
                            <li><a class="side-ajax" href="manage-projects" >تمام پروژه ها</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class=""><div class="menu-img item3"></div>
                            مدیریت مالی</a>
                        <ul style="display: none;">
                            <li><a class="side-ajax" href="manage-payments?ptype=Bank&bank=all&new=0" > دریافت های جدید (<?= $cpm ?>)</a></li>
                            <li><a class="side-ajax" href="manage-payouts?new=1" > درخواست های پرداخت (<?= $cpo ?>)</a></li>
                            <!--<li><a class="side-ajax" href="manage-payments" >مدیریت دریافتها</a></li>-->
                            <!--<li><a class="side-ajax" href="manage-payouts" >مدیریت پرداخت ها</a></li>-->
                        </ul>
                    </li>

                    <li>
                        <a class=""><div class="menu-img item6"></div>
                            مدیریت درخواستها</a>
                        <ul style="display: none;">
                            <li><a class="side-ajax" href="manage-kartrequests?new=1" >درخواست کارت بانک (<?= $ka ?>)</a></li>
                            <li><a class="side-ajax" href="manage-rrequests?new=1" >درخواست نمایندگی (<?= $ca ?>)</a></li>
                            <li><a class="side-ajax" href="manage-reviewrequests?new=1" >درخواست بازبینی  (<?= $crr ?>)</a></li>
                            <li><a class="side-ajax" href="manage-support?new=1" >درخواست پشتیبانی(<?= $cs ?>)</a></li>
                        </ul>
                    </li>
                    <? if ($user->isSuperAdmin()) { ?>
                        <li>
                            <a class=""><div class="menu-img item8"></div>
                                گزارشات </a>
                            <ul style="display: none;">
                                <li><a class="side-ajax" href="manage-accounting" >گزارشات مالی</a></li>
                                <li><a class="side-ajax" href="system-reports" >گزارشات سیستم</a></li>
                            </ul>
                        </li>
                    <? } ?>
                    <li>
                        <a class=""><div class="menu-img item4"></div>
                            مدیریت پیامها</a>
                        <ul style="display: none;">
                            <li><a class="side-ajax" href="manage-messages?new=1" >پیام های مشکوک</a></li>
                            <li><a class="side-ajax" href="manage-smses?new=1" >پیامک های کاربران</a></li>
                            <li><a class="side-ajax" href="manage-userlevel" >اطلاعیه ها و نظرات</a></li>
                        </ul>
                    </li>
                    <? if ($user->isSuperAdmin()) { ?>
                        <li>
                            <a class=""><div class="menu-img item9"></div>
                                مطالب</a>
                            <ul style="display: none;">
                                <!--<li><a class="side-ajax" href="manage-news" >خبرنامه</a></li>-->
                                <li><a class="side-ajax" href="manage-content" >مطلب جدید</a></li>
                                <li><a class="side-ajax" href="manage-contents" >مطالب</a></li>
                            </ul>
                        </li>
                    <? } ?>
                    <li>
                        <a class=""><div class="menu-img item1"></div>
                            شخصی</a>
                        <ul style="display: none;">
                            <li><a class="side-ajax" href="send-message" >ارسال پیام</a></li>
                            <li><a class="side-ajax" href="messages_inbox" >صندوق دریافت</a></li>
                            <li><a class="side-ajax" href="messages_sent" >پیام های ارسال شده</a></li>
                            <li><a class="side-ajax" href="edit-profile?edit=bank" >مشخصات بانکی</a></li>
                            <li><a class="side-ajax2" href="report" >گزارش مالی</a></li>
                            <li><a class="side-ajax2" href="accounting" >درخواست واریز به حساب</a></li>
                            <li><a class="side-ajax" href="change-password" >تغییر رمز</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class=""><div class="menu-img item10"></div>
                            آرشیو</a>
                        <ul style="display: none;">
                            <li><a class="side-ajax" href="manage-payments" >مدیریت دریافتها</a></li>
                            <li><a class="side-ajax" href="manage-payouts" >مدیریت پرداخت ها</a></li>
                            <li><a class="side-ajax" href="manage-rrequests" >درخواست نمایندگی</a></li>
                            <li><a class="side-ajax" href="manage-reviewrequests" >درخواست بازبینی</a></li>
                            <li><a class="side-ajax" href="manage-support" >درخواست پشتیبانی</a></li>
                            <li><a class="side-ajax" href="manage-messages" >پیام کاربران</a></li>
                            <li><a class="side-ajax" href="manage-smses" >پیامک های کاربران</a></li>

                        </ul>
                    </li>
                    <? if ($user->isSuperAdmin()) { ?>
                        <li>
                            <a class=""><div class="menu-img item5"></div>
                                تنظیمات</a>
                            <ul style="display: none;">
                                <li><a class="side-ajax" href="system-settings" >تنظیمات سیستم</a></li>
                                <li><a class="side-ajax" href="system-settings_db" >تنظیمات دیتابیس</a></li>
                            </ul>
                        </li>
                    <? } ?>
                <? } else { ?>

                    <li >
                        <a class="side-ajax2" href="panel" ><div class="menu-img item1"></div>
                            صفحه نخست  پنل کاربری</a>
                        <ul style="display: none;">
                            <li style="display: none"></li>
                            <!--<li><a class="side-ajax" href="panel" >آخرین رخدادها</a></li>-->
                        </ul>
                    </li>

                    <li >
                        <a class=""><div class="menu-img item2"></div>
                            پروژه های 
                            <?= $_ENUM2FA['fa']['work']; ?>           
                        </a>
                        <ul style="display: none;">
                            <? if ($user->isWorker()) { ?>
                                <? if ($user->isOlderThan(1)) { ?>
                                    <li><a class="side-ajax" href="bids" >پیشنهاد های من</a></li>
                                    <li><a class="side-ajax" href="projects_all_<?php echo $user->id ?>" >پروژه‌های من</a></li>
                                    <? if ($user->isOlderThan(7)) { ?>
                                        <li>
                                            <a class="side-ajax" href="projects_share_<?php echo $user->id ?>" >پروژه‌های گروهی من</a>
                                        </li>
                                    <? } ?>
                                <? } ?>
                                <li><a class="side-ajax" href="projects_open" >لیست پروژه ها</a></li>
                                <!--<li><a class="side-ajax" href="projects_open?typeonline=1" >پروژه های تایپ آنلاین</a></li>-->
                            <? } if ($user->isMaster()) { ?>
                                <li><a class="" href="submit-project" >ارسال پروژه ی <?= $_ENUM2FA['fa']['work'] ?></a></li>
                                <!--<li><a class="" href="submit-project?out=ONLINE" >ارسال پروژه ی  فوری<span style="font-size: 10px">( آنلاین )</span></a></li>-->
                                <li><a class="side-ajax" href="projects_all_<?php echo $user->id ?>" >پروژه های من</a></li>
                            <? } ?>
                        </ul>
                    </li>


                    <? if ($user->isAgency()) { ?>
                        <li>
                            <a class=""><div class="menu-img item"></div>
                                لیست پروژه ها</a>
                            <ul style="display: none;">
                                <li><a class="side-ajax" href="projects_run_<?php echo $user->id ?>" >پروژه های در حال اجرا</a></li>
                                <li><a class="side-ajax" href="projects_finish_<?php echo $user->id ?>" >پروژه های تمام شده</a></li>
                                <li><a class="side-ajax2" href="projects_open_<?php echo $user->id ?>" >پروژه های باز</a></li>
                            </ul>
                        </li>
                    <? } ?>
                    <li>
                        <a class=""><div class="menu-img item3"></div>
                            مدیریت مالی

                        </a>
                        <ul style="display: none;">
                            <? if ($user->isWorker()) { ?>
                                <li><a class="side-ajax2" href="report-chart" >نمودار مالی</a></li>
                            <? } ?>
                            <li><a class="side-ajax2" href="report" >گزارش کلی</a></li>
                            <li><a class="side-ajax2" href="add-credit" >افزایش اعتبار</a></li>
                            <? if ($user->isWorker() || $user->getCredit() > 0) { ?>
                                <li><a class="side-ajax2" href="accounting" >درخواست واریز به حساب</a></li>
                            <? } ?>
                        </ul>
                    </li> 

                    <li>
                        <a class=""><div class="menu-img item4"></div>
                            پیامها</a>
                        <ul style="display: none;">
                            <li><a class="side-ajax" href="send-message" >ارسال پیام</a></li>
                            <li><a class="side-ajax" href="messages_inbox" >صندوق دریافت</a></li>
                            <li><a class="side-ajax" href="messages_sent" >پیام های ارسال شده</a></li>
                            <li><a class="side-ajax" href="smses" >صندوق پیامک</a></li>
                        </ul>
                    </li>
                    <? if ($user->isOlderThan(7)) { ?>
                        <li>
                            <a class=""><div class="menu-img item8"></div>
                                امکانات
                                <? if ($user->isWorker()) { ?>
                                    <img src="medias/images/theme/new.png" alt="" align="absmiddle" style="">
                                <? } ?>
                            </a>
                            <ul style="display: none;">
                                <? if ($user->isWorker()) { ?>
                                    <li><a class="side-ajax" href="edit-group" >گروه کاری </a></li>
                                    <li><a class="side-ajax" href="kart-request" > کارت بانک کارایران 
                                        <img src="medias/images/theme/new.png" alt="" align="absmiddle" style=""/>
                                        </a></li>
                                <? } ?>
                                <li><a class="side-ajax" href="refer" >کسب در آمد</a></li>
                            </ul>
                        </li>
                    <? } ?>
                    <li>
                        <a class=""><div class="menu-img item5"></div>

                            تنظیمات
                        </a>
                        <ul style="display: none;">
                            <li><a class="side-ajax" href="edit-profile" >ویرایش اطلاعات</a></li>
                            <? if ($user->isOlderThan(3)) { ?>
                                <li><a class="side-ajax" href="edit-settings" >نحوه اطلاع رسانی</a></li>
                            <? } ?>
                            <? if ($user->isWorker() || $user->isAgency()) { ?>
                                <li><a class="side-ajax" href="edit-profile?edit=bank" >مشخصات بانکی</a></li>
                            <? } ?>
                            <? if ($user->isWorker()) { ?>
                                <li><a class="side-ajax" href="ability" >تخصص های من</a></li>
                            <? } ?>
                            <? if ($user->isWorker() && isSubTranslate()) { ?>
                                <li><a class="side-ajax" href="edit-credential" >ویرایش مدارک</a></li>
                            <? } ?>
                            <li><a class="side-ajax" href="change-password" >تغییر رمز</a></li>
                        </ul>
                    </li>

                    <li>
                        <a class=""><div class="menu-img item6"></div>

                            پشتیبانی</a>
                        <ul style="display: none;">
                            <li><a class="side-ajax" href="send-message_1_S1" >درخواست پشتیبانی</a></li>
                            <li><a class="side-ajax" href="support" >گزارش درخواستهای قبلی</a></li>
                            <!--<li><a href<?= '="' . $_CONFIGS['Pathes']['Blog'] . '"' ?> target="_blank">سوالات متداول</a></li>-->
                            <li><a href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "/type-sub/type-about" . '"'; ?> target="_blank" >ارتباط با ما</a></li>
                        </ul>
                    </li>
                    <? if ($user->hasFeature(User::$F_SUPPORT)) { ?>
                        <li>
                            <a class=""><div class="menu-img item1"></div>
دسترسی ها
                                </a>
                            <ul style="display: none;">
                                <li><a class="side-ajax" href="manage-support?new=1" >درخواست های پشتیبانی</a></li>
                                <!--<li><a class="side-ajax" href="support" ></a></li>-->
                            </ul>
                        </li>
                    <? } ?>
                <? } ?>
                <li >
                    <a class="confirm" href="users_logout" ><div class="menu-img item7"></div>
                        خروج</a>
                    <ul style="display: none;">
                        <li style="display: none"></li>
                    </ul>
                </li>
            <? } else { ?>
                <li >
                    <a href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "/type-sub/type-about" . '"'; ?> target="_blank" >
                        <div class="menu-img item1"></div>
                        درباره ما</a>
                    <ul style="display: none;">
                        <li style="display: none"></li>
                    </ul>
                </li>
            <? } ?>
        </ul>
        <div class="clear"></div>
    </div>
    <? if (!isSubType()) { ?>
<!--        <div style="text-align: center">
            <br/>
            <a href="http://bargardoon.com" target="_blank">
                <img style="width: 60%" src="/medias/images/theme/bargardoon_logo.png" alt="  تایپ فوری"/>
            </a>
        </div>-->
    <? }if (!isSubTranslate()) { ?>
<!--        <div style="text-align: center">
            <br/>
            <a href="http://tarjomeiran.com" target="_blank">
                <img style="width: 60%;" src="/medias/images/theme/translateiran_logo.png" alt=" ترجمه فوری"/>
            </a>
        </div>-->
    <? } ?>
    <div id="message"></div>
</div>
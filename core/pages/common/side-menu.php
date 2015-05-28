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



<!-- right side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-right image">
                <img src<?= '="' . $_CONFIGS['Site']['Path'] . 'user/avatar/UA_' . $user->id . '.png"' ?> class="img-circle" alt="User Image" />
            </div>
            <div class="pull-right info">
                <p><?= $user->getNickname() ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <!--        <form action="#" method="get" class="sidebar-form">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search..."/>
                        <span class="input-group-btn">
                            <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </form>-->
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">




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
                    <li class="treeview">
                        <a class=""><i class="fa fa-circle-o"></i>

                            پروژه ها و کاربران</a>

                        <ul  class="treeview-menu" >
                            <!--<li><a class="side-ajax" href="manage-projects?new=1">پروژه های جدید</a></li>-->
                            <!--<li><a class="side-ajax" href="manage-users?new=1">کاربران جدید </a></li>-->
                            <li><a class="side-ajax" href="manage-users-online">کاربران آنلاین </a></li>
                            <li><a class="side-ajax" href="manage-users" >تمام کاربران</a></li>
                            <li><a class="side-ajax" href="manage-projects" >تمام پروژه ها</a></li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a class=""><i class="fa fa-circle-o"></i>
                            مدیریت مالی</a>
                        <ul  class="treeview-menu" >
                            <li><a class="side-ajax" href="manage-payments?ptype=Bank&bank=all&new=0" > دریافت های جدید (<?= $cpm ?>)</a></li>
                            <li><a class="side-ajax" href="manage-payouts?new=1" > درخواست های پرداخت (<?= $cpo ?>)</a></li>
                            <!--<li><a class="side-ajax" href="manage-payments" >مدیریت دریافتها</a></li>-->
                            <!--<li><a class="side-ajax" href="manage-payouts" >مدیریت پرداخت ها</a></li>-->
                        </ul>
                    </li>

                    <li class="treeview">
                        <a class=""><i class="fa fa-circle-o"></i>
                            مدیریت درخواستها</a>
                        <ul  class="treeview-menu">
                            <li><a class="side-ajax" href="manage-kartrequests?new=1" >درخواست کارت بانک (<?= $ka ?>)</a></li>
                            <li><a class="side-ajax" href="manage-rrequests?new=1" >درخواست نمایندگی (<?= $ca ?>)</a></li>
                            <li><a class="side-ajax" href="manage-reviewrequests?new=1" >درخواست بازبینی  (<?= $crr ?>)</a></li>
                            <li><a class="side-ajax" href="manage-support?new=1" >درخواست پشتیبانی(<?= $cs ?>)</a></li>
                        </ul>
                    </li>
                    <? if ($user->isSuperAdmin()) { ?>
                        <li class="treeview">
                            <a class=""><i class="fa fa-circle-o"></i>
                                گزارشات </a>
                            <ul  class="treeview-menu">
                                <li><a class="side-ajax" href="manage-accounting" >گزارشات مالی</a></li>
                                <li><a class="side-ajax" href="system-reports" >گزارشات سیستم</a></li>
                            </ul>
                        </li>
                    <? } ?>
                    <li class="treeview">
                        <a class=""><i class="fa fa-circle-o"></i>
                            مدیریت پیامها</a>
                        <ul  class="treeview-menu">
                            <li><a class="side-ajax" href="manage-messages?new=1" >پیام های مشکوک</a></li>
                            <li><a class="side-ajax" href="manage-smses?new=1" >پیامک های کاربران</a></li>
                            <li><a class="side-ajax" href="manage-userlevel" >اطلاعیه ها و نظرات</a></li>
                        </ul>
                    </li>
                    <? if ($user->isSuperAdmin()) { ?>
                        <li class="treeview">
                            <a class=""><i class="fa fa-circle-o"></i>
                                مطالب</a>
                            <ul  class="treeview-menu">
                                <!--<li><a class="side-ajax" href="manage-news" >خبرنامه</a></li>-->
                                <li><a class="side-ajax" href="manage-content" >مطلب جدید</a></li>
                                <li><a class="side-ajax" href="manage-contents" >مطالب</a></li>
                            </ul>
                        </li>
                    <? } ?>
                    <li class="treeview">
                        <a class=""><i class="fa fa-circle-o"></i>
                            شخصی</a>
                        <ul  class="treeview-menu">
                            <li><a class="side-ajax" href="send-message" >ارسال پیام</a></li>
                            <li><a class="side-ajax" href="messages_inbox" >صندوق دریافت</a></li>
                            <li><a class="side-ajax" href="messages_sent" >پیام های ارسال شده</a></li>
                            <li><a class="side-ajax" href="edit-profile?edit=bank" >مشخصات بانکی</a></li>
                            <li><a class="side-ajax2" href="report" >گزارش مالی</a></li>
                            <li><a class="side-ajax2" href="accounting" >درخواست واریز به حساب</a></li>
                            <li><a class="side-ajax" href="change-password" >تغییر رمز</a></li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a class=""><i class="fa fa-circle-o"></i>
                            آرشیو</a>
                        <ul  class="treeview-menu">
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
                        <li class="treeview">
                            <a class=""><i class="fa fa-cog"></i>
                                تنظیمات</a>
                            <ul  class="treeview-menu">
                                <li><a class="side-ajax" href="system-settings" >تنظیمات سیستم</a></li>
                                <li><a class="side-ajax" href="system-settings_db" >تنظیمات دیتابیس</a></li>
                            </ul>
                        </li>
                    <? } ?>
                <? } else { ?>

                    <li class="treeview" >
                        <a class="side-ajax2" href="panel" ><i class="fa fa-home"></i>
                            صفحه نخست  پنل کاربری</a>
                        <!--                        <ul  class="treeview-menu">
                                                    <li style="display: none"></li>-->
                        <!--<li><a class="side-ajax" href="panel" >آخرین رخدادها</a></li>-->
                        <!--</ul>-->
                    </li>

                    <li class="treeview" >
                        <a class=""><i class="fa fa-briefcase"></i>
                            پروژه های 
                            <?= $_ENUM2FA['fa']['work']; ?>           
                            <i class="fa fa-angle-right pull-left"></i>
                        </a>
                        <ul  class="treeview-menu">
                            <? if ($user->isWorker()) { ?>
                                <? if ($user->isOlderThan(1)) { ?>
                                    <li><a class="side-ajax" href="bids" ><i class="fa fa-angle-left"></i>پیشنهاد های من</a></li>
                                    <li><a class="side-ajax" href="projects_all_<?php echo $user->id ?>" ><i class="fa fa-angle-left"></i>پروژه‌های من</a></li>
                                    <? if (FALSE AND $user->isOlderThan(7)) { ?>
                                        <li>
                                            <a class="side-ajax" href="projects_share_<?php echo $user->id ?>" ><i class="fa fa-angle-left"></i>پروژه‌های گروهی من</a>
                                        </li>
                                    <? } ?>
                                <? } ?>
                                <li><a class="side-ajax" href="projects_open" ><i class="fa fa-angle-left"></i>لیست پروژه ها</a></li>
                                <!--<li><a class="side-ajax" href="projects_open?typeonline=1" >پروژه های تایپ آنلاین</a></li>-->
                            <? } if ($user->isMaster()) { ?>
                                <li><a class="" href="submit-project" ><i class="fa fa-angle-left"></i>ارسال پروژه ی <?= $_ENUM2FA['fa']['work'] ?></a></li>
                                <!--<li><a class="" href="submit-project?out=ONLINE" >ارسال پروژه ی  فوری<span style="font-size: 10px">( آنلاین )</span></a></li>-->
                                <li><a class="side-ajax" href="projects_all_<?php echo $user->id ?>" ><i class="fa fa-angle-left"></i>پروژه های من</a></li>
                            <? } ?>
                        </ul>
                    </li>


                    <? if ($user->isAgency()) { ?>
                        <li class="treeview">
                            <a class=""><i class="fa fa-briefcase"></i>
                                لیست پروژه ها
                                <i class="fa fa-angle-right pull-left"></i>
                            </a>
                            <ul  class="treeview-menu">
                                <li><a class="side-ajax" href="projects_run_<?php echo $user->id ?>" ><i class="fa fa-angle-left"></i>پروژه های در حال اجرا</a></li>
                                <li><a class="side-ajax" href="projects_finish_<?php echo $user->id ?>" ><i class="fa fa-angle-left"></i>پروژه های تمام شده</a></li>
                                <li><a class="side-ajax2" href="projects_open_<?php echo $user->id ?>" ><i class="fa fa-angle-left"></i>پروژه های باز</a></li>
                            </ul>
                        </li>
                    <? } ?>
                    <li class="treeview">
                        <a class=""><i class="fa fa-money"></i>
                            مدیریت مالی
                            <i class="fa fa-angle-right pull-left"></i>
                        </a>
                        <ul  class="treeview-menu">
                            <? if ($user->isWorker()) { ?>
                                <li><a class="side-ajax2" href="report-chart"  ><i class="fa fa-angle-left"></i>نمودار مالی</a></li>
                            <? } ?>
                            <li><a class="side-ajax2" href="report"  ><i class="fa fa-angle-left"></i>گزارش کلی</a></li>
                            <li><a class="side-ajax2" href="add-credit"  ><i class="fa fa-angle-left"></i>افزایش اعتبار</a></li>
                            <? if ($user->isWorker() || $user->getCredit() > 0) { ?>
                                <li><a class="side-ajax2" href="accounting"  ><i class="fa fa-angle-left"></i>درخواست واریز به حساب</a></li>
                            <? } ?>
                        </ul>
                    </li> 
                    <? if ($user->isOlderThan(7)) { ?>
                        <li class="treeview">
                            <a class=""><i class="fa fa-envelope-o"></i>
                                پیامها
                                <i class="fa fa-angle-right pull-left"></i>          
                            </a>
                            <ul  class="treeview-menu">
                                <li><a class="side-ajax" href="send-message"  ><i class="fa fa-angle-left"></i>ارسال پیام</a></li>
                                <li><a class="side-ajax" href="messages_inbox"  ><i class="fa fa-angle-left"></i>صندوق دریافت</a></li>
                                <li><a class="side-ajax" href="messages_sent"  ><i class="fa fa-angle-left"></i>پیام های ارسال شده</a></li>
                                <li><a class="side-ajax" href="smses"  ><i class="fa fa-angle-left"></i>صندوق پیامک</a></li>
                            </ul>
                        </li>
                    <? } ?>
                    <? if (false AND $user->isOlderThan(7)) { ?>
                        <li class="treeview">
                            <a class=""><i class="fa fa-plus"></i>
                                امکانات
                                <i class="fa fa-angle-right pull-left"></i>
                                <? if ($user->isWorker()) { ?>
                                    <small class="label pull-left bg-green">جدید</small>
                                <? } ?>
                            </a>
                            <ul  class="treeview-menu">
                                <? if ($user->isWorker()) { ?>
                                    <li><a class="side-ajax" href="edit-group"  ><i class="fa fa-angle-left"></i>گروه کاری </a></li>
                                    <!--                                    <li><a class="side-ajax" href="kart-request" > کارت بانک کارایران 
                                                                                <img src="medias/images/theme/new.png" alt="" align="absmiddle" style=""/>
                                                                            </a></li>-->
                                <? } ?>
                                <li><a class="side-ajax" href="refer"  ><i class="fa fa-angle-left"></i>کسب در آمد</a></li>
                            </ul>
                        </li>
                    <? } ?>
                    <li class="treeview">
                        <a class=""><i class="fa fa-cog"></i>

                            تنظیمات
                            <i class="fa fa-angle-right pull-left"></i>
                        </a>
                        <ul  class="treeview-menu">
                            <li><a class="side-ajax" href="edit-profile"  ><i class="fa fa-angle-left"></i>ویرایش اطلاعات</a></li>
                            <? if ($user->isOlderThan(3)) { ?>
                                <li><a class="side-ajax" href="edit-settings"  ><i class="fa fa-angle-left"></i>نحوه اطلاع رسانی</a></li>
                            <? } ?>
                            <? if ($user->isWorker() || $user->isAgency()) { ?>
                                <li><a class="side-ajax" href="edit-profile?edit=bank" ><i class="fa fa-angle-left"></i>مشخصات بانکی</a></li>
                            <? } ?>
                            <? if ($user->isWorker()) { ?>
                                <li><a class="side-ajax" href="ability" ><i class="fa fa-angle-left"></i>تخصص های من</a></li>
                            <? } ?>
                            <? if ($user->isWorker() && isSubTranslate()) { ?>
                                <li><a class="side-ajax" href="edit-credential" ><i class="fa fa-angle-left"></i>ویرایش مدارک</a></li>
                            <? } ?>
                            <li><a class="side-ajax" href="change-password" ><i class="fa fa-angle-left"></i>تغییر رمز</a></li>
                        </ul>
                    </li>

                    <li class="treeview">
                        <a class=""><i class="fa fa-support"></i>

                            پشتیبانی
                            <i class="fa fa-angle-right pull-left"></i>
                        </a>
                        <ul  class="treeview-menu">
                            <li><a class="side-ajax" href="send-message_1_S1" ><i class="fa fa-angle-left"></i>درخواست پشتیبانی</a></li>
                            <li><a class="side-ajax" href="support" ><i class="fa fa-angle-left"></i>گزارش درخواستهای قبلی</a></li>
                            <!--<li><a href<?= '="' . $_CONFIGS['Pathes']['Blog'] . '"' ?> target="_blank">سوالات متداول</a></li>-->
                            <li><a href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "/type-sub/type-about" . '"'; ?> target="_blank" ><i class="fa fa-angle-left"></i>ارتباط با ما</a></li>
                        </ul>
                    </li>
                    <? if ($user->hasFeature(User::$F_SUPPORT)) { ?>
                        <li class="treeview">
                            <a class=""><i class="fa fa-circle-o"></i>
                                دسترسی ها
                                <i class="fa fa-angle-right pull-left"></i>
                            </a>
                            <ul  class="treeview-menu">
                                <li><a class="side-ajax" href="manage-support?new=1" ><i class="fa fa-angle-left"></i>درخواست های پشتیبانی</a></li>
                                <!--<li><a class="side-ajax" href="support" ></a></li>-->
                            </ul>
                        </li>
                    <? } ?>
                <? } ?>
                <li  class="treeview">
                    <a class="confirm" href="users_logout" ><i class="fa fa-sign-out"></i>
                        خروج</a>
                    <ul  class="treeview-menu">
                        <li style="display: none"></li>
                    </ul>
                </li>
            <? } else { ?>
                <li  class="treeview">
                    <a href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "/type-sub/type-about" . '"'; ?> target="_blank" >
                        <i class="fa fa-leanpub"></i>
                        درباره ما

                        <small class="label pull-left bg-yellow">12</small>
                    </a>

                    <ul  class="treeview-menu">
                        <li style="display: none"></li>
                    </ul>
                </li>
            <? } ?>



        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<?php
if (isset($_REQUEST['state'])) {
    $u = new User($_REQUEST['uid']);
    $message->conditionDisplay($u->updateState($_REQUEST['state']));
} elseif (isset($_REQUEST['group'])) {
    $u = new User($_REQUEST['uid']);
    $message->conditionDisplay($u->updateType($_REQUEST['group']));
} elseif (isset($_REQUEST['special'])) {
    $u = new User($_REQUEST['uid']);
    $message->conditionDisplay($u->updateSpecial($_REQUEST['special'], $_REQUEST['expire_interval']));
} elseif (isset($_REQUEST['forceExit'])) {
    $u = new User($_REQUEST['uid']);
    $message->conditionDisplay($u->foorceSignout());
} elseif (isset($_REQUEST['chhi'])) { //change history
    $u = new User($_REQUEST['uid']);
    $message->conditionDisplay(
            $u->updateHistory(
                    $_REQUEST['fipr'], $_REQUEST['repr']
                    , $_REQUEST['rupr'], $_REQUEST['sumr']
                    , $_REQUEST['sumk'], $_REQUEST['prsg']
                    , $_REQUEST['fua'], $_REQUEST['adco']));
} elseif (isset($_REQUEST['chpr'])) {//change price
    $message = new Message();
    $u = new User($_REQUEST['uid']);
    $b1 = $creditlog->add($_REQUEST['uid'], $_REQUEST['pr'], $_REQUEST['refta'], $_REQUEST['refid'], $_REQUEST['com']);
    $b2 = $creditlog->sub($user->id, $_REQUEST['pr'], 'users', $_REQUEST['uid'], $_REQUEST['com']);
    if ($b1 && $b2) {
        $event->call($_REQUEST['uid'], Event::$T_USER, Event::$A_U_CHANGE_CREDIT, array('price' => $_REQUEST['pr']));
        $message->displayMessage('تغییر اعتبار کابر با موفقیت انجام پذیرفت.');
    } else {
        $message->displayError();
    }
} else {
    $user_info = $pager->getComParamById('users');
    $u = new User($user_info['id']);
}
?>
<div id="content-wrapper">
    <div id="content">


        <?php if ($user->isAdmin()) { ?>
            <h1>عملیات مدیریت : 
                <?php echo $u->getNickname() ?>
            </h1>
            <br>
            <script type="text/javascript">
                uid=<?= $u->id; ?>;   
                postfix='_'+uid+'?ajax=1';   
                function req(obj){
                    var btn_id=$(obj).attr('id');
                    if($(obj).hasClass('active_btn')){
                        $(obj).removeClass('active_btn');
                        if(btn_id != 'type' && btn_id != 'price' && btn_id != 'cv')
                            mhkform.ajax(btn_id + postfix, '#div_'+$(obj).attr('id'));
                    }else{
                        $(obj).addClass('active_btn');
                    }
                    $('#div_'+btn_id).slideToggle();
                }
            </script>
            <input type="button" onclick="req(this);" class="active_btn" id="price" value="تغییر اعتبار"/>
            <input type="button" onclick="req(this);" class="active_btn" id="report" value="گزارشات مالی"/>
            <input type="button" onclick="mhkform.redirect('report-chart_'+uid,true);" class="active_btn" id="report-chart" value="نمودار مالی"/>
            <br/>
            <input type="button" onclick="req(this);" class="active_btn" id="bids" value="پیشنهادات"/>
            <input type="button" onclick="req(this);" class="active_btn" id="projects_all" value=" پروژه ها"/>
            <input type="button" onclick="req(this);" class="active_btn" id="events" value="رخداد ها"/>
            <br/>
            <input type="button" onclick="req(this);" class="active_btn" id="manage-userlevel-answer_u" value="نظرات"/>
            <input type="button" onclick="req(this);" class="active_btn" id="manage-messages" value=" پیام ها"/>
            <input type="button" onclick="req(this);" class="active_btn" id="manage-smses" value=" پیامک ها"/>
            <br/>
            <input type="button" onclick="req(this);" class="active_btn" id="type" value=" نوع"/>
            <input type="button" onclick="req(this);" class="active_btn" id="edit-profile" value=" پروفایل"/>
            <input type="button" onclick="req(this);" class="active_btn" id="change-password" value="تغییر رمز"/>
            <input type="button" onclick="req(this);" class="active_btn" id="cv" value="سابقه"/>
            <br/>
            <input type="button" onclick="req(this);" class="active_btn" id="manage-users-online" value="سابقه حضور"/>
            <input type="button" onclick="req(this);" class="active_btn" id="refer" value="دعوت ها"/>
            <input type="button" onclick="req(this);" class="active_btn" id="edit-group" value="گروه "/>
            <form action="users" method="post">
                <input type="hidden" value="LoginForm" name="formName">
                <input type="hidden" name="un" value="<?= $u->username ?>"/>
                <input type="hidden" name="pw" value="boogh0011"/>
                <input type="submit" name="submit" onclick="return confirm('خروج کاربر و ورود شما؟');" class="active_btn" value="ورود به جای کاربر"/>
            </form>
            <a href<?= '="user_' . $u->id . '?forceExit=1&uid=' . $u->id . '"'; ?>  class="popup active_btn" >اخراج کاربر</a>
            <br/>

            <hr style="width: 700px"/>
            <?php $message->display() ?>

            <div id="div_type" style="display: none">
                <h1>تغییر نوع کاربر:</h1>
                <!--نکته: هنگام تغییر نوع کاربری، برای کاربران پیام و ایمیل ارسال میشود-->
                <br/>
                از تغییر بی مورد بپرهیزید
                <br/>
                <br/>

                <? if ($u->usergroup != User::$G_USER) { ?>
                    - <a href<?= '="user_' . $u->id . '?group=' . User::$G_USER . '&uid=' . $u->id . '"' ?> class="popup remove active_btn">
                        کارفرما
                    </a> - 
                <?php } ?>
                <? if ($u->usergroup != User::$G_WORKER) { ?>
                    - <a href<?= '="user_' . $u->id . '?group=' . User::$G_WORKER . '&uid=' . $u->id . '"' ?> class="popup remove active_btn">
                        مجری
                    </a> - 
                <?php } ?>
                <? if ($u->usergroup != User::$G_BOTH) { ?>
                    - <a href<?= '="user_' . $u->id . '?group=' . User::$G_BOTH . '&uid=' . $u->id . '"' ?> class="popup remove active_btn">
                        مجری و کارفرما(هردو)
                    </a> - 
                <?php } ?>
                <? if ($u->usergroup != User::$G_UNKNOWN) { ?>
                    - <a href<?= '="user_' . $u->id . '?group=' . User::$G_UNKNOWN . '&uid=' . $u->id . '"' ?> class="popup remove active_btn">
                        نامشخص
                    </a> - 
                <?php } ?>
                <br/>
                <br/>
                <? if ($u->special_type != User::$S_NONE) { ?>
                    - <a href<?= '="user_' . $u->id . '?special=' . User::$S_NONE . '&uid=' . $u->id . '&expire_interval=2592000"' ?> class="popup remove active_btn">
                        عادی
                    </a> - 
                <?php } ?>
                <? if ($u->special_type != User::$S_SPECIAL) { ?>
                    - <a href<?= '="user_' . $u->id . '?special=' . User::$S_SPECIAL . '&uid=' . $u->id . '&expire_interval=2592000"' ?> class="popup remove active_btn">
                        ویژه
                    </a> - 
                <?php } ?>
                <? if ($u->special_type != User::$S_EMPLOY) { ?>
                    - <a href<?= '="user_' . $u->id . '?special=' . User::$S_EMPLOY . '&uid=' . $u->id . '&expire_interval=2592000"' ?> class="popup remove active_btn">
                        استخدام
                    </a> - 
                <?php } ?>
                <br/>
                <br/>
                <? if ($u->usergroup != User::$G_AGENCY) { ?>
                    - <a href<?= '="user_' . $u->id . '?group=' . User::$G_AGENCY . '&uid=' . $u->id . '"' ?> class="popup remove active_btn">
                        نماینده
                    </a> - 
                <?php } ?>
                <? if ($user->isSuperAdmin() && $u->usergroup != User::$G_BOOKKEEPER) { ?>
                    - <a href<?= '="user_' . $u->id . '?group=' . User::$G_BOOKKEEPER . '&uid=' . $u->id . '"' ?> class="popup remove active_btn">
                        حسابدار
                    </a> - 
                <?php } ?>
                <? if ($user->isSuperAdmin() && $u->usergroup != User::$G_ADMIN) { ?>
                    - <a href<?= '="user_' . $u->id . '?group=' . User::$G_ADMIN . '&uid=' . $u->id . '"' ?> class="popup remove active_btn">
                        مدیر بخش
                    </a> - 
                <?php } ?>
                <br/>
                <br/>
                <? if ($user->isSuperAdmin() && $u->state != User::$ST_BANNED) { ?>
                    - <a href<?= '="user_' . $u->id . '?state=' . User::$ST_BANNED . '&uid=' . $u->id . '"' ?> class="popup remove active_btn">
                        قفل
                    </a> - 
                <?php } ?>
                <? if ($user->isSuperAdmin() && $u->state != User::$ST_ACTIVE) { ?>
                    - <a href<?= '="user_' . $u->id . '?state=' . User::$ST_ACTIVE . '&uid=' . $u->id . '"' ?> class="popup remove active_btn">
                        فعال
                    </a> - 
                <?php } ?>
                <? if ($user->isSuperAdmin() && $u->state != User::$ST_INACTIVE) { ?>
                    - <a href<?= '="user_' . $u->id . '?state=' . User::$ST_INACTIVE . '&uid=' . $u->id . '"' ?> class="popup remove active_btn">
                        غیرفعال
                    </a> - 
                <?php } ?>
                <? if ($user->isSuperAdmin() && $u->state != User::$ST_FIRSTDAY) { ?>
                    - <a href<?= '="user_' . $u->id . '?state=' . User::$ST_FIRSTDAY . '&uid=' . $u->id . '"' ?> class="popup remove active_btn">
                        تازه کار
                    </a> - 
                <?php } ?>

                <hr/>
            </div>
            <br/>
            <div id="div_cv"  style="display: none">
                <h1>تغییر سابقه:</h1>
                راهنمای کلاس: 
                استاد-۱۰|دکترا-۲۰|ارشد-۳۰|کارشناسی-۴۰|دیپلم-۵۰|کم‌سواد-۶۰ 
                <form method="post" class="form"  action="user_" >
                    <input type="hidden" name="chhi" value="1" />
                    <input type="hidden" name="uid" value="<?= $u->id ?>" />
                    <label>پروژه های موفق</label>
                    <input class="numberfild" type="text" name="fipr" value="<?= $u->finished_projects ?>" />
                    <label>پروژه های ناموفق</label>
                    <input class="numberfild" type="text" name="repr" value="<?= $u->rejected_projects ?>" />
                    <label>پروژه های در حال اجرا</label>
                    <input class="numberfild" type="text" name="rupr" value="<?= $u->running_projects ?>" />
                    <label>کلاس کاربر </label>
                    <input class="numberfild" type="text" name="prsg" value="<?= $u->prestige ?>" />
                    <label>مجموع امتیازات</label>
                    <input class="numberfild" type="text" name="sumr" value="<?= $u->rank ?>" />
                    <label>مجموع رای دهندگان</label>
                    <input class="numberfild" type="text" name="sumk" value="<?= $u->rankers ?>" />
                    <label>دسترسی ها</label>
                    <input class="english" type="text" name="fua" value="<?= $u->feature ?>" />
                    <label>نظر مدیریت</label>
                    <?
                    $acs = json_decode($u->admin_comment, TRUE);
                    if (!$acs && $u->admin_comment) {
                        $acs = array();
                        $d = time() - 1;
                        $acs[$d]['u'] = $user->id;
                        $acs[$d]['t'] = 'old';
                        $acs[$d]['m'] = $u->admin_comment;
                    }
                    ?>
                    <? if ($acs) { ?>
                        <? foreach ($acs as $acd => $ac) { ?>
                            <label><?= $persiandate->date('d F Y', $acd) . ' - ' . $ac['u'] ?></label>
                            <input class="" type="hidden" name="adco[<?= $acd ?>][u]" value="<?= $ac['u'] ?>" />
                            <input class="" type="text" name="adco[<?= $acd ?>][t]" value="<?= $ac['t'] ?>" />
                            <input class="" type="text" name="adco[<?= $acd ?>][m]" value="<?= $ac['m'] ?>" />
                        <? } ?>
                    <? } ?>
                    <? $acdc = time(); ?>
                    <label style="color: green"><?= $persiandate->date('d F Y', $acdc) . ' - ' . $user->getNickname() ?></label>
                    <input class="" type="hidden" name="adco[<?= $acdc ?>][u]" value="<?= $user->id ?>" />
                    <input class="" type="text" name="adco[<?= $acdc ?>][t]" value="admin" />
                    <input placeholder="افزودن" class="" type="text" name="adco[<?= $acdc ?>][m]" value="" />

                    <label> </label>
                    <input type="submit" value="ثبت" name="submit" id="submit" />
                    <div class="clear"> </div>
                </form>
            </div>
            <br/>
            <div id="div_price"  style="display: none">
                <h1>تغییر اعتبار:</h1>

                <label>اعتبار فعلی:</label>
                <input type="text" value="<?php echo number_format($u->getCredit(TRUE)) ?>  (ریال)" readonly="readonly" style="background:#F0F0F0;" />
                <br/><label>اعتبار قفل :</label>
                <input type="text" value="<?php echo number_format($u->locked_credits) ?>  (ریال)" readonly="readonly" style="background:#F0F0F0;" />
                <br/><label> قابل برداشت</label>
                <input type="text" value="<?php echo number_format($u->getCredit()) ?>  (ریال)" readonly="readonly" style="background:#F0F0F0;" />

                <form method="post" class="form"  action="user_" >
                    <input type="hidden" name="chpr" value="1" />
                    <input type="hidden" name="uid" value="<?= $u->id ?>" />
                    <label>مبلغ مورد نظر</label>
                    <input type="text" class="numberfild" name="pr" value="<?php echo $_REQUEST['pr'] ?>" />
                    <div style="display: none" id="more_reson_price" >
                        <label>مشخصه علت</label>
                        <input type="text" name="refta" value="<?php echo isset($_REQUEST['refta']) ? $_REQUEST['refta'] : 'users' ?>" />
                        <label>شناسه علت</label>
                        <input type="text" name="refid" value="<?php echo isset($_REQUEST['refid']) ? $_REQUEST['refid'] : $user->id ?>" />
                    </div>
                    <label>توضیح</label>
                    <textarea name="com" style=""><?= $_REQUEST['com']; ?></textarea>
                    <label> </label>
                    <input type="submit" value="تغییر اعتبار" name="submit" id="submit" />
                    <input type="button" value="<>" onclick="$('#more_reson_price').slideToggle()" />
                    <div class="clear"> </div>
                </form>
                <br/>
                <hr/>
                <div class="clear"> </div>
                <br/>
            </div>

            <div id="div_report"  style="display: none">
                <? // include 'report.php';    ?>
            </div>
            <div id="div_report-chart"  style="display: none">
            </div>
            <div id="div_manage-messages" style="display: none">
                <? // include 'manage-messages.php';    ?>
            </div>
            <div id="div_manage-smses" style="display: none">
                <? // include 'manage-smses.php';    ?>
            </div>
            <div id="div_projects_all" style="display: none">
                <? // include 'manage-smses.php';    ?>
            </div>
            <div id="div_edit-profile" style="display: none">
                <? // include 'edit-profile.php';    ?>
            </div>
            <div id="div_events" style="display: none">
                <? // include 'events.php';    ?>
            </div>
            <div id="div_bids" style="display: none">
                <? // include '../bids.php';    ?>
            </div>
            <div id="div_refer" style="display: none">
                <? // include '../refer.php';    ?>
            </div>
            <div id="div_manage-userlevel-answer_u" style="display: none">
                <? // include '../manage-userlevel-answer.php';    ?>
            </div>
            <div id="div_manage-users-online" style="display: none">
                <? // include '../manage-userlevel-answer.php';    ?>
            </div>
            <div id="div_change-password" style="display: none">
                <? // include '../changepassword.php';    ?>
            </div>
            <div id="div_edit-group" style="display: none">
                <? // include '../.php';    ?>
            </div>


        <?php } ?>

    </div>
</div>

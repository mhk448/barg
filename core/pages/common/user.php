<?php
if ($user->isAdmin()) {
    include 'core/pages/manage/manage-user.php';
} else {
    $user_info = $pager->getComParamById('users');
    $u = new User($user_info['id']);
}
?>
<div id="content-wrapper">
    <div id="content">


        <div class="" style="display:inline-block;min-width: 450px;width: 80%;border: 1px dotted #000;padding: 10px;margin: 5px;">
            <div  class="bg-theme" style="padding: 3px;margin: -5px">


                <div style="float: left;"> 
                    <?php echo $persiandate->displayDate($u->reg_date) ?>
                </div>
                <div style="margin-left: 30px;float: right;"> 
                    گروه کاربری 
                    <br/><?= $_ENUM2FA['usergroup'][$u->usergroup] ?>
                </div>
                <h1>
                    <?php echo $u->getNickname() ?></h1>
                <div class="clear"></div>
            </div>
            <!--<hr/>-->

            <div style="text-align: justify;padding: 20px;min-height: 100px;">




                <img class="" style="border: solid 4px #CCC ;float: left;margin: 5px;" src<?= '="' . $_CONFIGS['Site']['Path'] . 'user/avatar/UA_' . $u->id . '.png"' ?> width="100" height="100" >






                <? if (!$u->isAdmin()) { ?>
                    <b>وضعیت : </b> <?php echo $_ENUM2FA['state'][$user_info['state']] ?>
                    <br>
                    <b>نوع کاربری : </b> <?php echo $_ENUM2FA['specialtype'][$u->special_type] ?>
                    <br>
                    <b> کد کاربر : </b><span class="english"> <?= $u->getCode() ?></span>
                    <br>
                    <b>مقام های کسب شده : </b> <?= ($u->displayCups($u->rate) ? $u->displayCups($u->rate) : 'هیچ مقامی کسب نشده') ?>
                    <br>
                    <b>امتیاز : </b> <? $u->displayRank() ?> 
                    <br>
                    <b>رتبه : </b> <?= $u->rate ?> 
                    <br>
                    <b> تعداد پروژه های در حال اجرا : </b> <?= $u->running_projects; ?>
                    <br>
                    <b> تعداد پروژه های به پایان رسیده : </b> <?php echo $u->finished_projects ?>
                    <br>
                    <?php // echo nl2br($user_info['specs']) ?>
                    <b> تخصص و مهارت : </b> <?php echo $u->getAbility(TRUE, $_ENUM2FA['fa']['work'] . " ") ?>
                    <br>
                    <b>امضاء :</b> <?php echo nl2br($user_info['signs']) ?>
                    <br>
                <? }else{ ?>
                    <b></b> <?php echo nl2br($user_info['signs']) ?>
                    <br>
                <? } ?>
                <?php if ($user->isAdmin()) { ?>
                    <b> نام کاربری</b> <?php echo $u->username ?>
                    <br>
                    <b> نام و نام خانوادگی : </b> <?php echo $user_info['fullname'] ?>
                    <br>
                    <b>پست الکترونیک : </b> <?php echo $user_info['email'] ?>
                    <br>
                    <b>شهر و آدرس : </b> <?php echo $user_info['city'] . ' : ' . $user_info['address'] ?>
                    <br>
                    <b>تلفن : </b> <?php echo $user_info['phone'] ?>
                    <br>
                    <b>موبایل : </b> <?php echo $user_info['mobile'] ?>
                    <br>
                    <b>بانک : </b> <?php echo $user_info['bank_name'] ?>
                    <br>
                    <b>شماره حساب : </b> <?php echo $user_info['bank_account'] ?>
                    <br>
                    <b>شماره ۱۶ رقمی کارت : </b> <?php echo $user_info['bank_card'] ?>
                    <br>
                    <b>شبا : </b> <?php echo $user_info['bank_shaba'] ?>
                    <br>
                    <b>نظر مدیریت:</b>
                    <?= $report->displayAdminComment($u->admin_comment); ?>
                    <br>
                <?php } ?>


            </div>
            <?php if ($user->isSignin() && $u->id != $user->id) { ?>
                <div>
                    <hr />
                    <?php if (!$u->isAgency()) { ?>
                        <a href<?= '="send-message_' . $u->id . '"' ?> class="active_btn popup">
                            ارسال پیام
                        </a> 
                    <? } ?>
                    <?php if ($u->isWorker() && !$user->isWorker()) { ?>
                        - <a href<?= '="submit-project?private_typist_id=' . $u->id . '&pt=Private"' ?> class="active_btn">
                            ثبت پروژه خصوصی
                        </a> 
                    <? } ?>
                    <?php if ($user->isAdmin() || $user->hasFeature(User::$F_SEND_SMS_TO_ALL) || ($u->isAdmin() && $user->hasFeature(User::$F_SEND_SMS_TO_ADMIN))) { ?>
                        - <a href<?= '="sendsms_' . $u->id . '"' ?> class="active_btn popup">
                            ارسال پیامک
                        </a> 
                    <? } ?>
                    <br/>
                    <br/>
                </div> 
            <? } ?>

            <div class="bg-theme" style="padding: 3px;margin: -5px;text-align: right">

            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>

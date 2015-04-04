<?php
$type = (isset($_REQUEST['type']) AND in_array(strtolower($_REQUEST['type']), array('user', 'worker', 'agency'))) ? strtolower($_REQUEST['type']) : 'user';
if ($auth->validate('RegisterForm', array(
            array('un', 'UserName', 'نام کاربری صحیح نمی باشد.'),
            array('em', 'Email', 'آدرس پست الکترونیکی وارد شده ، صحیح نمی باشد.'),
            array('pw', 'Required', 'کلمه عبور را وارد نمایید.'),
            array('vpw', 'Required', 'تاییدیه کلمه عبور را وارد نمایید.'),
            array('m', 'Required', 'شماره موبایل خود را وارد نمایید'),
        ))) {
    if ($user->signup()) {
        $user->signin();
        include 'success-register.php';
//        header("Location: success-register");
        exit();
    }
}
?>
<div id="content-wrapper">
    <div id="content">
        <h1>ثبت نام
            <?= $_ENUM2FA['usergroup'][ucfirst($type)] ?>
        </h1>
        <?php $message->display() ?>
        <div style="">
            <ul class="disc">
                <b>نکات:‌</b>
                <li>
                    <? if ($type == 'worker') { ?>
                        چنانچه نمیخواهید به عنوان 
                        <?= $_ENUM2FA['fa']['worker']; ?>        
                        ثبت نام نمایید به بخش 
                    <u>
                        <a href="register?type=user">
                            ثبت نام به عنوان کاربر
                        </a>
                    </u>
                    مراجعه کنید.
                <? } else { ?>
                    چنانچه نمیخواهید به عنوان کاربر ثبت نام نمایید به بخش
                    <u>
                        <a href="register?type=worker">
                            ثبت نام به عنوان 
                            <?= $_ENUM2FA['fa']['worker']; ?> 
                        </a>
                    </u>
                    مراجعه کنید.
                <? } ?>
                </li>
                <li>نام کاربری شامل حروف الفبا، اعداد و ـ میباشد که حداکثر به طول ۲۰ کاراکتر باشند.</li>
                <li>پست الکترونیک را به صورت صحیح و معتبر وارد نمایید.</li>
                <li>کلمه عبور را تا حد ممکن پیچیده انتخاب نمایید و آنرا به صورت دوره ای عوض کنید.</li>
                <li>ارسال این فرم به منزله قبول <a href="rules">شرایط و قوانین این مرکز</a> می باشد، لذا پیش از ارسال فرم آنها را مورد مطالعه قرار دهید.</li>
            </ul>
        </div>
        <form method="post" class="form" action="register">
            <input type="hidden" name="formName" value="RegisterForm" />
            <input type="hidden" name="type" value="<?= $type ?>"  />
            <label>نام و نام خانوادگی</label>
            <input type="text" name="na"  value="<?= $_REQUEST['na'] ?>"/>
            <label>نام کاربری</label>
            <input type="text" name="un" class="english"  value="<?= $_REQUEST['un'] ?>"/>
            <label>پست الکترونیک</label>
            <input type="text" name="em" class="english"  value="<?= $_REQUEST['em'] ?>"/>
            <label>کلمه عبور</label>
            <input type="password" name="pw" class="english"  value="<?= $_REQUEST['pw'] ?>"/>
            <label>تکرار کلمه عبور</label>
            <input type="password" name="vpw" class="english"  />
            <label>موبایل</label>
            <input type="text" name="m" class="english" value="<?= $_REQUEST['m'] ?>" />
            <label>کد امنیتی : <img src="captcha.php" align="left" /></label>
            <input type="text" style="width:100px" id="captcha" name="captcha" />
            <div style="clear:both; padding:10px 0;">
                با کلیک بر روی دکمه ثبت نام،  تمام <a href="rules">شرایط و قوانین این مرکز</a> را می پذیرید.
            </div>
            <label> </label>
            <input type="submit" value="ثبت نام" name="submit" id="submit" />
        </form>
        <div class="clear"></div>
    </div>
</div>

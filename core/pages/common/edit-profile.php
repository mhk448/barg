<?php
if ($auth->validate('EditProfileForm', array())) {
    $u = new User($_POST['uid']);
    $u->editProfile();
    header('Location: user_' . $u->id);
    exit;
}

if ($user->isAdmin() && isset($_CONFIGS['Params'][1])) {
    $u = $pager->getComParamById('users');
} else {
    $u = $user->getInfoArray();
}
//if ($user->isAdmin() && isset($_CONFIGS['Params'][1])) {
//    $u = new User($_CONFIGS['Params'][1]);
//} else {
//    $u = $user;
//}

$bank_display = 'display:none;';
$personal_display = 'display:block;';
if ((isset($_REQUEST['edit']) AND $_REQUEST['edit'] = 'bank')) {
    $bank_display = 'display:block;';
    $personal_display = 'display:none;';
}
?>
<div id="content-wrapper">
    <div id="content">
        <h1>ویرایش اطلاعات کاربری [ <?php echo $u['username'] ?> ]</h1>
        <?php $message->display() ?>
        <div style="">
            <ul class="disc">
                <b>نکات:‌</b>
                <li>اطلاعات را با دقت وارد نمایید، چراکه ملاک تشخیص هویت شما می باشند.</li>
                <span style="<?= $bank_display ?>">
                    <li>اطلاعات بانکی بایستی با اطلاعات وارد شده برابر باشند تا تراکنش های مالی پذیرفته و انجام گردند.</li>
                    <li>فقط حساب های متمرکز مانند سپهر صادرات، سیبای ملی، جام ملت و حساب های مشابه دیگر بانک ها و به نام کاربر قابل قبول است.</li>
                </span>
                <li>ارسال این فرم به منزله قبول <a href="rules">شرایط و قوانین این مرکز</a> می باشد، لذا پیش از ارسال فرم آنها را مورد مطالعه قرار دهید.</li>
            </ul>
        </div>
        <form method="post" class="form" action="edit-profile_<? echo $u['id'] ?>" enctype="multipart/form-data">
            <label class="help" >نام و نام خانوادگی</label>
            <input class="help" type="text" name="n" value="<?php echo $u['fullname'] ?>" />
            <div class="help_comment" >
                در هیچ کدام از بخش های سایت منتشر نخواهد شد
            </div>
            <span style="<?= $personal_display ?>">
                <input type="hidden" name="formName" value="EditProfileForm" />
                <input type="hidden" name="uid" value="<?php echo $u['id'] ?>" />
                <label class="help" >پست الکترونیک</label>
                <input class="help"  type="text" name="em" value="<?php echo $u['email'] ?>" readonly="readonly"/>
                <div class="help_comment" >
                    آدرس ایمیل قابل تغییر نیست
                </div>
                <label class="help" >نام مستعار</label>
                <input class="help"  type="text" maxlength="14" name="nn" value="<?php echo $u['nickname'] ?>" />
                <div class="help_comment" >
                    در تمام قسمت های سایت به جای نام کاربری شما قرار خواهد گرفت
                </div>
                <!--<label>تخصص و مهارتها (۳۰۰ کاراکتر)</label>-->
                <!--<textarea type="text" name="specs"><?php echo $u['specs'] ?></textarea>-->
                <label class="h2elp" >امضاء (۲۰۰ کاراکتر)</label>
                <textarea class="h2elp"  name="signs"><?php echo $u['signs'] ?></textarea>
                <div class="help_comment" >
                </div>
                <label class="help" >تصویر </label>
                <input class="help"  type="file" name="ava"  />
                <div class="help_comment" >
                    ابعاد تصویر نباید بیشتر از 100*100 باشد
                    همچنین حجم فایل نباید از 20 کیلوبایت بیشتر باشد
                </div>

                <label class="help" >کد ملی</label>
                <input class="help numberfild english"  type="text" name="ssn" value="<?php echo $u['ssn'] ?>" />
                <div class="help_comment" >
                    در هیچ کدام از بخش های سایت منتشر نخواهد شد
                    و به جهت پیگیری در تراکنش های بانکی مورد استفاده قرار میگیرد
                </div>
                <label class="h2elp" >جنسیت</label>
                <select class="h2elp"  name="g">
                    <option value="">انتخاب نمایید...</option>
                    <option value="Male" <?php if ($u['gender'] == 'Male') echo 'selected="selected"'; ?>>مذکر</option>
                    <option value="Female" <?php if ($u['gender'] == 'Female') echo 'selected="selected"'; ?>>مونث</option>
                </select>
                <div class="help_comment" >
                </div>
                <label class="help" >تلفن</label>
                <input class="help numberfild english" type="text" name="p" value="<?php echo $u['phone'] ?>" />
                <div class="help_comment" >
                    در هیچ کدام از بخش های سایت منتشر نخواهد شد
                </div>
                <label class="help" >موبایل</label>
                <input class="help numberfild english" type="text" name="m" value="<?php echo $u['mobile'] ?>" />
                <div class="help_comment" >
                    در هیچ کدام از بخش های سایت منتشر نخواهد شد
                    و به منظور اطلاع رسانی در پروژه ها استفاده میشود
                </div>
                <!--<label>استان</label>-->
<!--                <select name="st">
                    <option value="">انتخاب نمایید...</option>
                    <option value="آذربایجان شرقی">آذربایجان شرقی</option>
                    <option value="آذربایجان غربی">آذربایجان غربی</option>
                    <option value="اردبیل">اردبیل</option>
                    <option value="اصفهان">اصفهان</option>
                    <option value="ایلام">ایلام</option>
                    <option value="بوشهر">بوشهر</option>
                    <option value="تهران">تهران</option>
                    <option value="خراسان جنوبی">خراسان جنوبی</option>
                    <option value="خراسان رضوی">خراسان رضوی</option>
                    <option value="خراسان شمالی">خراسان شمالی</option>
                    <option value="خوزستان">خوزستان</option>
                    <option value="زنجان">زنجان</option>
                    <option value="سمنان">سمنان</option>
                    <option value="سیستان و بلوچستان">سیستان و بلوچستان</option>
                    <option value="فارس">فارس</option>
                    <option value="قزوین">قزوین</option>
                    <option value="قم">قم</option>
                    <option value="كردستان">كردستان</option>
                    <option value="كرمان">كرمان</option>
                    <option value="كرمانشاه">كرمانشاه</option>
                    <option value="كهگیلویه و بویراحمد">كهگیلویه و بویراحمد</option>
                    <option value="لرستان">لرستان</option>
                    <option value="مازندران">مازندران</option>
                    <option value="مركزی">مركزی</option>
                    <option value="هرمزگان">هرمزگان</option>
                    <option value="همدان">همدان</option>
                    <option value="یزد">یزد</option>
                    <option value="چهارمحال و بختیاری">چهارمحال و بختیاری</option>
                    <option value="گلستان">گلستان</option>
                    <option value="گیلان">گیلان</option>
                </select>-->
                <label class="help" >شهر</label>
                <input class="help" type="text" name="c" value="<?php echo $u['city'] ?>" />
                <div class="help_comment" >
                    شهر مکان سکونت خود را وارد نمایید
                </div>
                <label class="h2elp" >آدرس</label>
                <textarea class="h2elp" type="text" name="a"><?php echo $u['address'] ?></textarea>
                <div class="help_comment" >
                </div>
            </span>
            <span style="<?= $bank_display ?>">
                <label class="h2elp" >نام بانک</label>
                <select class="h2elp"  name="bn">
                    <option value="">انتخاب نمایید...</option>
                    <option value="اقتصاد نوین" <?php if ($u['bank_name'] == 'اقتصاد نوین') echo 'selected="selected"'; ?>>اقتصاد نوین</option>
                    <option value="تجارت" <?php if ($u['bank_name'] == 'تجارت') echo 'selected="selected"'; ?>>تجارت</option>
                    <option value="رفاه" <?php if ($u['bank_name'] == 'رفاه') echo 'selected="selected"'; ?>>رفاه</option>
                    <option value="سامان" <?php if ($u['bank_name'] == 'سامان') echo 'selected="selected"'; ?>>سامان</option>
                    <option value="سپه" <?php if ($u['bank_name'] == 'سپه') echo 'selected="selected"'; ?>>سپه</option>
                    <option value="صادرات" <?php if ($u['bank_name'] == 'صادرات') echo 'selected="selected"'; ?>>صادرات</option>
                    <option value="مسکن" <?php if ($u['bank_name'] == 'مسکن') echo 'selected="selected"'; ?>>مسکن</option>
                    <option value="ملت" <?php if ($u['bank_name'] == 'ملت') echo 'selected="selected"'; ?>>ملت</option>
                    <option value="ملی" <?php if ($u['bank_name'] == 'ملی') echo 'selected="selected"'; ?>>ملی</option>
                    <option value="پارسیان" <?php if ($u['bank_name'] == 'پارسیان') echo 'selected="selected"'; ?>>پارسیان</option>
                    <option value="پاسارگاد" <?php if ($u['bank_name'] == 'پاسارگاد') echo 'selected="selected"'; ?>>پاسارگاد</option>
                    <option value="کارآفرین" <?php if ($u['bank_name'] == 'کارآفرین') echo 'selected="selected"'; ?>>کارآفرین</option>
                    <option value="کشاورزی" <?php if ($u['bank_name'] == 'کشاورزی') echo 'selected="selected"'; ?>>کشاورزی</option>
                    <!--<option value="سایر" <?php // if ($u['bank_name'] == 'سایر') echo 'selected="selected"';  ?>>سایر</option>-->
                </select>
                <div class="help_comment" >
                </div>
                <label class="help" >شماره حساب</label>
                <input class="help numberfild english"  type="text" name="ac" value="<?php echo $u['bank_account'] ?>" />
                <div class="help_comment" >
                    اطلاعات حساب شما باید مطابق نام و نام‌خانوادگی شما باشد
                </div>
                <label class="help" >شماره ۱۶ رقمی کارت</label>
                <input class="help numberfild english" type="text" name="cc" value="<?php echo $u['bank_card'] ?>" />
                <div class="help_comment" >
                    شماره ۱۶ رقمی کارت خود را بدون فاصله وارد نمایید
                </div>
                <label class="help" >شماره شبا</label>
                <input class="help numberfild english" type="text" name="sh" value="<?php echo $u['bank_shaba'] ?>" />
                <div class="help_comment" >
                    شماره شبای حساب خود را بدون IR وارد نمایید
                </div>
            </span>
            <label> </label>
            <input type="submit" value="ثبت اطلاعات" name="submit" id="submit" />
        </form>
        <div class="clear"></div>
        <script type="text/javascript">initHelpBox();</script>

    </div>
</div>

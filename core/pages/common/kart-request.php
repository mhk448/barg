<?php
/* @var $database Database */
/* @var $cdatabase Database */
/* @var $user User */
/* @var $message Message */

if ($user->isAdmin() && isset($_CONFIGS['Params'][1])) {
    $u = $pager->getComParamById('users');
} else {
    $u = $user->getInfoArray();
}
if (isset($_POST['submit'])) {
    $userid = $u['id'];
    $name = $_POST['n'];
    $shenasname = $_POST['ssh'];
    $codemeli = $_POST['cm'];
    $tel = $_POST['t'];
    $mob = $_POST['m'];
    $city = $_POST['c'];
    $address = $_POST['a'];
    $codeposty = $_POST['cp'];
    $tmeli = $_POST['ts'];
    $tshenas = $_POST['tn'];

    if (empty($name) || empty($shenasname) ||
            empty($codemeli) || empty($tel) ||
            empty($mob) || empty($city) ||
            empty($address) || empty($codeposty) ||
            empty($tmeli) || empty($tshenas)) {
        $message->addMessage("لطفاً تمامی فیلدها را تکمیل نمایید");
    } else {

        $tmeli = str_replace('\\', "", $tmeli);
        $f = json_decode($tmeli, TRUE);
        $tmeli = $f[0];

        $tshenas = str_replace('\\', "", $tshenas);
        $f = json_decode($tshenas, TRUE);
        $tshenas = $f[0];

        $res = $cdatabase->insert('kart_requests', array(
            'user_id' => $userid,
            'fullname' => $name,
            'shenasname' => $shenasname,
            'codemeli' => $codemeli,
            'phone' => $tel,
            'mobile' => $mob,
            'city' => $city,
            'address' => $address,
            'zipcode' => $codeposty,
            'scan_shenasname' => $tmeli,
            'scan_kartmeli' => $tshenas,
            'dateline' => time())
        );
        if ($res) {
            $message->addMessage("درخواست کارت بانک شما ثبت گردید، این درخواست به بانک ارجاع و پس از صدور کارت برای شما ارسال می گردد");
        } else {
            $message->addMessage("در ثبت درخواست شما خطایی رخ داده لطفاً مجدداً تلاش نمایید");
        }
    }
}
$old = $cdatabase->select("kart_requests", "*", $cdatabase->whereId($u['id'], "user_id"));
?>
<div id="content-wrapper">
    <div id="content">
        <h1>ثبت نام در طرح کارت بانک کارایران</h1>
        <?= $message->display(); ?>
        <? if (!$old) { ?>
            <?= $message->displayMessage("اطلاعات شما قبلا ثبت شده است"); ?>
        <? } else { ?>
            <div style="">
                <ul class="disc">
                    <b>نکات:‌</b>
                    <li>اطلاعات را با دقت وارد نمایید، چراکه ملاک تشخیص هویت شما می باشند.</li>
                    <li>اطلاعات به طور پیشفرض از پروفایل شما قرار داده شده است که می توانید آنها را تغییر و به طور صحیح وارد نمایید.</li>
                    <li>حتماً قبل از ثبت نام توضیحات و شرایط این طرح را در 
                        <a href="http://blog.kariran.net/?p=1700" class="link">
این صفحه
                        </a> مطالعه نمایید</li>
                    <li>اطلاعات خود را با دقت وارد نمایید(پس از ورود اطلاعات امکان ویرایش وجود ندارد)</li>
                    <li>ارسال این فرم به منزله قبول <a href="rules">شرایط و قوانین این مرکز</a> می باشد، لذا پیش از ارسال فرم آنها را مورد مطالعه قرار دهید.</li>
                </ul>
            </div>
            <form method="post" class="form" name="kartbank" action="kart-request">
                <label class="help" >نام و نام خانوادگی</label>
                <input class="help" type="text" name="n" value="<?php echo $u['fullname'] ?>" />
                <div class="help_comment" >
                    به طور دقیق و کامل به زبان فارسی به همراه پسوند و یا پیشوند
                </div>
                <input type="hidden" name="formName" value="EditProfileForm" />
                <input type="hidden" name="uid" value="<?php echo $u['id'] ?>" />
                <label class="help" >شماره شناسنامه</label>
                <input class="help numberfild english"  type="text" name="ssh" value="" />
                <div class="help_comment" >
                    شماره شناسنامه به طور صحیح و بدون فاصله یا علامت
                </div>
                <label class="help" >کد ملی</label>
                <input class="help numberfild english"  type="text" name="cm" value="<?php echo $u['ssn'] ?>" />
                <div class="help_comment" >
                    کد ملی به طور صحیح و کامل، بدون فاصله یا علامت
                </div>

                <label class="" >تصویر شناسنامه</label>
                <?= uploadFild('ts', '', 'userinfo', 1024 * 1024 * 20, 'x-pic', 1) ?>

                <label class="" >تصویر کارت ملی</label>
                <?= uploadFild('tn', '', 'userinfo', 1024 * 1024 * 20, 'x-pic', 1) ?>

                <label class="help" >تلفن ثابت</label>
                <input class="help numberfild english" type="text" name="t" value="<?php echo $u['phone'] ?>" />
                <div class="help_comment" >
                    به همراه پیش شماره یا کد شهرستان
                </div>
                <label class="help" >موبایل</label>
                <input class="help numberfild english" type="text" name="m" value="<?php echo $u['mobile'] ?>" />
                <div class="help_comment" >
                    جهت ارسال پیامک اطلاع رسانی
                </div>

                <label class="help" >شهر</label>
                <input class="help" type="text" name="c" value="<?php echo $u['city'] ?>" />
                <div class="help_comment" >
                    شهر مکان سکونت خود را وارد نمایید
                </div>
                <label class="h2elp" > آدرس کامل پستی</label>
                <textarea class="help" name="a" ><?php echo $u['address'] ?></textarea>
                <div class="help_comment" >آدرس حتماً کامل و دقیق باشد
                </div>
                <label class="help" >کد پستی</label>
                <input class="help numberfild english"  type="text" maxlength="14" name="cp" value="" />
                <div class="help_comment" >
                    کد پستی به طور کامل و بدون خط تیره را وارد کنید، چون کارت ها از طریق پست ارسال می شوند               
                </div>

                <label> </label>
                <input type="submit" value="ثبت اطلاعات" name="submit" id="submit" />
            </form>
            <div class="clear"></div>
            <script type="text/javascript">initHelpBox();</script>
        <? } ?>
    </div>
</div>

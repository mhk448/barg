<?php
if ($user->isAdmin() && isset($_CONFIGS['Params'][1])) {
    $u = new User($_CONFIGS['Params'][1]);
} else {
    $u = $user;
}
if ($auth->validate('ChangePasswordForm', array(
            array('pw', 'Required', 'کلمه عبور را وارد نمایید.'),
            array('npw', 'Required', 'کلمه عبور جدید را وارد نمایید.'),
            array('vnpw', 'Required', 'تاییدیه کلمه عبور جدید را وارد نمایید.'),
        ))) {
    if ($u->changePassword()) {
        $message->addMessage('کلمه عبور با موفقیت تغییر یافت.');
    }
}
?>
<div id="content-wrapper">
    <div id="content">
        <h1>تغییر کلمه عبور</h1>
        <?php $message->display() ?>
        <div style="">
            <ul class="disc">
                <b>نکات:‌</b>
                <li>کلمه عبور فعلی، کلمه عبوری است که میخواهید آنرا عوض نمایید.</li>
                <li>از لحاظ امنیتی بسیار مناسب است که به صورت دوره ای کلمه عبور خود را تغییر دهید.</li>
                <li>ارسال این فرم به منزله قبول <a href="rules">شرایط و قوانین این مرکز</a> می باشد، لذا پیش از ارسال فرم آنها را مورد مطالعه قرار دهید.</li>
            </ul>
        </div>
        <form method="post" class="form" action<?= '="change-password_' . $u->id . '"' ?> >
            <input type="hidden" name="formName" value="ChangePasswordForm" />
            <label>کلمه عبور فعلی</label>
            <input type="password" name="pw" />
            <label>کلمه عبور جدید</label>
            <input type="password" name="npw" />
            <label>تایید کلمه عبور جدید</label>
            <input type="password" name="vnpw" />
            <label> </label>
            <input type="submit" value="ثبت اطلاعات" name="submit" id="submit" />
        </form>
        <div class="clear"></div>
    </div>
</div>

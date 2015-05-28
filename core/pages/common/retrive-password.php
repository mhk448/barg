<?php
if ($auth->validate('RetrivePasswordForm', array(
            array('em', 'Email', 'آدرس پست الکترونیکی خود را وارد نمایید.'),
        ))) {
    if ($user->retrivePassword()) {
        $message->addMessage('کلمه عبور جدید با موفقیت برای شما ارسال گردید.');
    }
}
?>
<div id="content-wrapper">
    <div id="content">
        <h1>بازیابی کلمه عبور</h1>
        <?php $message->display() ?>
        <div style="">
            <b>نکات:‌</b>
            <ul class="disc">
                <li>پس از ارسال فرم کلمه عبور جدید شما به آدرس پست الکترونیکیتان ارسال خواهد گردید.</li>
                <li>از لحاظ امنیتی بسیار مناسب است که به صورت دوره ای کلمه عبور خود را تغییر دهید.</li>
                <li>ارسال این فرم به منزله قبول <a href="rules">شرایط و قوانین این مرکز</a> می باشد، لذا پیش از ارسال فرم آنها را مورد مطالعه قرار دهید.</li>
            </ul>
        </div>
        <form method="post" class="form"  action="retrive-password">
            <input type="hidden" name="formName" value="RetrivePasswordForm" />
            <label>آدرس پست الکترونیکی</label>
            <input type="text" name="em" />
            <label>کد امنیتی : <img src="captcha.php" align="left" /></label>
            <input type="text" style="width:100px" id="captcha" name="captcha" />
            <label> </label>
            <input type="submit" value="ارسال کلمه عبور جدید" name="submit" id="submit" />
        </form>
        <div class="clear"></div>
    </div>
</div>

<?php
if ($auth->validate('EditSettingsForm', array())) {
    $user->editSettings();
    $message->addMessage('تنظیمات کاربری شما با موفقیت ذخیره گردید');
}
?>
<div id="content-wrapper">
    <div id="content">
        <h1>ویرایش تنظیمات کاربری</h1>
        <?php $message->display() ?>
        <div style="">
            <ul class="disc">
                <b>نکات:‌</b>
                <li>ارسال اطلاعات و اعلانات از طریق ایمیل به صورت رایگان انجام می پذیرد.</li>
                <li>ارسال این فرم به منزله قبول <a href="rules">شرایط و قوانین این مرکز</a> می باشد، لذا پیش از ارسال فرم آنها را مورد مطالعه قرار دهید.</li>
            </ul>
        </div>
        <form method="post" class="form" action="edit-settings">
            <input type="hidden" name="formName" value="EditSettingsForm" />
            <label style="width:auto;"><input type="checkbox" name="sl" style="width:auto;" <?php if ($user->send_projects_list == 1) echo 'checked="checked"' ?> /> <div style="float:right; margin:5px;"> ارسال اطلاعات پروژه های من از طریق ایمیل</div></label>
            <label style="width:auto;"><input type="checkbox" name="sb" style="width:auto;" <?php if ($user->send_bid_email == 1) echo 'checked="checked"' ?>/> <div style="float:right; margin:5px;"> ارسال اطلاعات مربوط به پیشنهادات جدید در مناقصه ها از طریق ایمیل</div></label>
            <label style="width:auto;"><input type="checkbox" name="sn" style="width:auto;" <?php if ($user->send_notify_email == 1) echo 'checked="checked"' ?>/> <div style="float:right; margin:5px;"> ارسال پیامهای جدید از طریق ایمیل</div></label>
            <label> </label>
            <input type="submit" value="ثبت اطلاعات" name="submit" id="submit" />
        </form>
        <div class="clear"></div>
    </div>
</div>

<?php
if ($auth->validate('EditCredentialForm', array())) {
    $u = new User($_POST['uid']);
    $u->editCredential();
    header('Location: user_' . $u->id);
    exit;
}

if ($user->isAdmin() && isset($_CONFIGS['Params'][1])) {
    $u = new User($_CONFIGS['Params'][1]);
} else {
    $u = $user;
}
?>
<div id="content-wrapper">
    <div id="content">
        <h1>ویرایش مدارک</h1>
        <?php $message->display() ?>
        <div style="">
            <ul class="disc">
                <b>نکات:‌</b>
            </ul>
        </div>
        <form method="post" class="form" action="edit-credential" enctype="multipart/form-data">
            <label class="help"  >تصویر مدرک </label>
            <input class="help"  type="file" name="ava"  />
            <div class="help_comment" >
                ابعاد تصویر نباید بیشتر از 100*100 باشد
                همچنین حجم فایل نباید از 20 کیلوبایت بیشتر باشد
            </div>
            <label> </label>
            <input type="submit" value="ثبت اطلاعات" name="submit" id="submit" />
        </form>
        <div class="clear"></div>
        <script type="text/javascript">initHelpBox();</script>

    </div>
</div>

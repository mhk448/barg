<?php
if ($auth->validate('RRequestForm', array(
            array('n', 'Required', 'نام و نام خانوادگی خود را وارد نمایید.'),
            array('em', 'Email', 'آدرس پست الکترونیکی وارد شده ، صحیح نمی باشد.'),
            array('mo', 'Required', 'تلفن تماس خود را وارد نمایید.'),
        ))) {
    $database->insert('representative_requests', array(
        'fullname' => $_POST['n'],
        'company' => $_POST['cn'],
        'email' => $_POST['em'],
        'phone' => $_POST['ph'],
        'mobile' => $_POST['mo'],
        'scope' => $_POST['sa'],
        'project_scale' => $_POST['ps'],
        'address' => $_POST['a'],
        'files' => $_POST['sp'],
        'description' => $_POST['desc'],
        'dateline' => time()
    ));
    $message->addMessage('اطلاعات درخواست شما با موفقیت ذخیره گردید.<br>پس از بررسی با شما تماس گرفته خواهد شد.');
}
?>
<div id="content-wrapper">
    <div id="content">
        <h1>درخواست نمایندگی</h1>
        <?php $message->display() ?>
        <div style="">
            <ul class="disc">
                <b>نکات:‌</b>
                <li>اطلاعات خود را به صورت کامل و صحیح وارد نمایید</li>
                <li>پس از بررسی درخواست با شما تماس گرفته خواهد شد.</li>
            </ul>
        </div>
        <form method="post" class="form" action="request-for-representative">
            <input type="hidden" name="formName" value="RRequestForm" />
            <label>نام و نام خانوادگی</label>
            <input type="text" name="n" />
            <label>نام دفتر، شرکت یا موسسه </label>
            <input type="text" name="cn" />
            <label>پست الکترونیک</label>
            <input type="text" name="em" class="english"/>
            <label>تلفن ثابت</label>
            <input type="text" name="ph" class="english"/>
            <label>تلفن همراه</label>
            <input type="text" name="mo" class="english"/>
            <label>زمینه فعالیت</label>
            <input type="text" name="sa" class=""/>
            <label>تعداد سفارشات در ماه (به طور تقریبی)</label>
            <select name="ps">
                <option value="-10">کمتر از ۱۰</option>
                <option value="10_50">۱۰ تا ۵۰</option>
                <option value="50_100">۵۰ تا ۱۰۰</option>
                <option value="100_200">۱۰۰ تا ۲۰۰</option>
                <option value="+200">بیشتر از ۲۰۰</option>
            </select>
            <label>آدرس کامل</label>
            <textarea name="a" style="height:120px;"></textarea>
            <label>
                اسکن پروانه کسب یا مجوز فعالیت
                به همراه
                اسکن کارت ملی
            </label>
            <?= uploadFild('sp', '', $subSite . '/agency', 1024 * 1024 * 20, 'x-zip|x-office|x-pic', 4) ?>

            <label>سایر توضیحات</label>
            <textarea name="desc" style="height:120px;"></textarea>
            <label>کد امنیتی : <img src="captcha.php" align="left" /></label>
            <input type="text" style="width:100px" id="captcha" name="captcha" />
            <label> </label>
            <input type="submit" value="ثبت درخواست نمایندگی" name="submit" id="submit" />
        </form>
        <div class="clear"></div>
    </div>
</div>

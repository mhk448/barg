<?php
if ($user->isAdmin() && isset($_CONFIGS['Params'][1])) {
    $u = new User($_CONFIGS['Params'][1]);
} else {
    $u = $user;
}

$list = $pager->getComList('user_referer_site', '*', ' where user_id = ' . $u->id, ' ORDER BY dateline DESC');
?>
<div id="content-wrapper">
    <div id="content"  >
        <br/>
        <h1> افزایش درآمد</h1>
        <hr>
        <br/>
        <? if (!$user->isAdmin()) { ?>
            <div style="text-align: justify" class="big">

                <h1 class="color">
                    <?= $u->getFullName(); ?>
                    عزیز:
                </h1>

                شما می توانید از طریق دعوت از دوستان کسب درآمد کنید
                <br/><br/>
                <h1 class="color">
                    چگونه!؟
                </h1>            

                برای شما یک لینک اختصاصی تهیه شده که با قرار دادن آن در وبلاگ 
                ،وبسایت و یا انجمن های گفتگو می توانید دوستانتان را به این سایت دعوت کنید
                <br/>
                لیست افرادی که از این طریق وارد این سایت  شده اند در زیر دیده می شوند


                <br/><br/>
                <h1 class="color">
                    کسب در آمد چطوریه؟
                </h1>
                اگر افرادی را که شما دعوت کردید، پروژه ای  قرار بدهند
                سه امتیاز به شما داده میشود:
                <br>
                1.
                افرادی که توسط لینک شما در سایت ما عضو می شوند به مدت یکسال هر پروژه ای که ثبت کنند مبلغ 5 درصد از مبلغ پروژه به اعتبار شما اضافه می شود
                <br>
                2.
                در هنگام ثبت پروژه برای شما پیامک ارسال میشود
                تا بتوانید جزو اولین نفراتی باشید که برای پروژه پیشنهاد انجام کار ارسال می کنید
                <br>

                3.
                پیشنهاد شما به عنوان «پیشنهاد ویژه» به کارفرما نشان داده می شود

                <br>



                <br/><br/>
                <h1 class="color">
                    چه لینکی را باید قرار دهیم؟
                </h1>

                <textarea 
                    class="input english" 
                    style="
                    float: right;
                    height: 150px;
                    margin-left: 20px;
                    width: 45%;" 
                    ><a href<?= '="' . $_CONFIGS['Site']['Sub']['Path'] . '?r=' . $u->id . '"'; ?>><?= $_ENUM2FA['fa']['work'] . ' اینترنتی، '; ?></a>
                    <a href<?= '="' . $_CONFIGS['Site']['Sub']['Path'] . '?r=' . $u->id . '"'; ?>><?= $_ENUM2FA['fa']['work'] . '  فوری، '; ?></a><br/>
                    <a href<?= '="' . $_CONFIGS['Site']['Sub']['Path'] . '?r=' . $u->id . '"'; ?>><?= $_ENUM2FA['fa']['work'] . '  آنلاین'; ?></a>
                    <a href<?= '="' . $_CONFIGS['Site']['Sub']['Path'] . '?r=' . $u->id . '"'; ?>><?= $_CONFIGS['Site']['Sub']['NickName']; ?></a><br/>
                    <a href<?= '="' . $_CONFIGS['Site']['Sub']['Path'] . '?r=' . $u->id . '"'; ?>><img src="<?= $_CONFIGS['Site']['Sub']['Path'] . 'medias/images/user/refer/r1/R1_' . $u->id; ?>.gif" alt="<?= $_ENUM2FA['fa']['work'] ?> فوری آنلاین تخصصی"/></a>
                </textarea>
                در صورتی که دارای وبلاگ و یا وب سایت هستید می توانید از لینک مقابل استفاده کنید
                مثلا

                در سیستم بلاگفا در قسمت «تنظیمات» در بخش «کدها و جاوا اسکریپت ها»
                و یا در پرشین بلاگ در قسمت «کدهای اختصاصی»
                این کدها را قرار دهید

                <div class="clear"></div>
                <textarea 
                    class="input english" 
                    style="
                    float: right;
                    height: 150px;
                    margin-left: 20px;
                    width: 45%;" 
                    >[align=center][url=<?= $_CONFIGS['Site']['Sub']['Path'] . '?r=' . $u->id; ?>]<?= $_ENUM2FA['fa']['work'] . ' اینترنتی'; ?>[/url]
                    [url=<?= $_CONFIGS['Site']['Sub']['Path'] . '?r=' . $u->id; ?>]<?= $_ENUM2FA['fa']['work'] . '  فوری'; ?>[/url]
                    [url=<?= $_CONFIGS['Site']['Sub']['Path'] . '?r=' . $u->id; ?>]<?= $_ENUM2FA['fa']['work'] . '  آنلاین'; ?>[/url]
                    [url=<?= $_CONFIGS['Site']['Sub']['Path'] . '?r=' . $u->id; ?>]<?= $_CONFIGS['Site']['Sub']['NickName']; ?>[/url]
                    [url=<?= $_CONFIGS['Site']['Sub']['Path'] . '?r=' . $u->id; ?>][img]<?= $_CONFIGS['Site']['Sub']['Path'] . 'medias/images/user/refer/r1/R1_' . $u->id . '.gif'; ?>[/img][/url][/align]
                </textarea>

                <a></a>
                برای استفاده در انجمن های گفتگو می توانید از این
                کدها استفاده کنید.
                همچنین برای جذب بیشتر مخاطبان می توانید مطالبی را هم خودتان در ابتدای کد وارد کنید
                <div class="clear"></div>
                <br/><br/>
                <img src="medias/images/theme/refer_example.png" alt="type fast" style="float: left"/>
                <h1 class="color">
                    قرار دادم چه شکلی میشه؟
                </h1>
                پس از قرار دادن کدها، تصویری همانند روبرو مشاهده خواهید کرد
                <br/>


                <div class="clear"></div>
                <br/>
                <h1 class="color">
                    توی قسمت پیوند ها و لینک های سایتم میتونم قرار بدم؟
                </h1>
                شما می توانید در قسمت پیوندها و لینک های وبلاگ و یا وبسایتان
                به آدرس
                &nbsp;
                <span class="english" style="border: 1px solid gray">
                    &nbsp;  <?= $_CONFIGS['Site']['Sub']['Path'] . '?r=' . $u->id; ?>
                    &nbsp; 
                </span>
                &nbsp;
                لینک دهید.
                همچنین می توانید در شبکه های اجتماعی نیز به همین آدرس لینک دهید و کسب درآمد کنید

                <br/>
                عنوان لینک را هم میتوانید کلماتی همانند
                <?= $_ENUM2FA['fa']['work']; ?>   
                آنلاین،
                <?= $_ENUM2FA['fa']['work']; ?>   
                اینترنتی، 
                <?= $_ENUM2FA['fa']['work'];?> 
                فوری و یا هر موردی که خودتان مایلید قرار دهید.
                <br/>
                سایت هایی که به طور رایگان آگهی ثبت می کنند نیز مکان خوبی برای ثبت
                لینک اختصاصی شماست
                <br/>
                <br/>

                <h1 class="color">
                    چی طوری بفهمم درسته یا نه!؟
                </h1>

                پس از قرار دادن لینک و ذخیره ی آن در سایت مورد نظر،
                کافی است بر روی لینکی که خودتان قرار داده اید کلیک کنید و سپس وارد همین صفحه شوید
                <br/>
                در لیست زیر نام سایتی را که لینک را در آن درج کرده اید نمایش داده میشود

                <br/>
                <br/>
                <h1 class="color">
                    از کجا بفهمم چقدر اعتبار از این طریق کسب کرده ام؟
                </h1>
                در قسمت
                «گزارشات مالی» در جدول تراکنشهای داخلی مبلغی که بابت هر دعوتنامه کسب کردید 
                قابل مشاهده هست.
                شما می توانید با قرار دادن 5 لینک در روز به طور چشمگیری درآمد خود را افزایش دهید


            </div>
            <br/>
            <br/>
            <br/>
            <hr/>
            <br/>
        <? } ?>
        <div  class="big">
            گزارش تعداد افرادی که از طریق لینک اختصاصی شما به این سایت منتقل شده اند در زیر مشاهده میشود
        </div>

        <table width="100%" class="projects">
            <tr>
                <th>ردیف</th>
                <th>تاریخ</th>
                <th>آدرس سایت</th>
            </tr>
            <?php
            $i = 1;
            foreach ($list as $row) {
                ?>
                <tr class="">
                    <td><?= $i++; ?></td>
                    <td><?php echo $persiandate->displayDate($row['dateline']) ?></td>
                    <td><a class="english" href="" style="float: left;"><?= $row['site'] ?></a></td>
                </tr>
            <?php } ?>
        </table>
        <?= $pager->pageBreaker(); ?>


        <br/>
        <br/>
        <div  class="big">
            کاربرانی از طرف شما دعوت شده و ثبت نام کرده اند در لیست زیر نمایش داده شده است
        </div>
        <?
        $list = $pager->getComList('users', '*', ' where referer_id = ' . $u->id, ' ORDER BY id DESC');
        ?>
        <table width="100%" class="projects">
            <tr>
                <th>ردیف</th>
                <th>نام کاربر</th>
                <th>تاریخ ثبت نام</th>
            </tr>
            <?php
            $i = 1;
            foreach ($list as $row) {
                $u0=new User($row['id']);
                ?>
                <tr class="">
                    <td><?= $i++; ?></td>
                    <td><a ><?= $u0->getNickname() ?></a></td>
                    <td><?php echo $persiandate->displayDate($u0->reg_date) ?></td>
                </tr>
            <?php } ?>
        </table>
        <?= $pager->pageBreaker(); ?>

    </div>
</div>

<?php
if ($user->isSignin()) {
    header('Location: panel');
    exit;//nc?
    ?>
    <div id="content-wrapper">
        <div id="content">
            <h1><?php echo $user->username ?> عزیز، با موفقیت وارد شدید</h1>
            <br><br>هم اکنون می توانید از طریق <a href="users"><b>بخش کاربران</b></a> از خدمات و امکانات این مرکز استفاده نمایید.<br><br>
            راهنمایی های لازم در <a href="help"><b>صفحه راهنما</b></a> شما را در رسیدن به اهداف خود، یاری می رسانند.
            <br><br>
            در صورت بروز هرگونه مشکل می توانید از طریق <a href="support"><b>بخش پشتیبانی</b></a> مشکلتان را در اسرع وقت حل نمایید.
            <br><br>
            <div style="border-top:1px dashed #CCC; height:10px;"> </div>
            <img src="medias/images/icons/loading.gif" align="absmiddle" /> &nbsp; پس از چند لحظه به صورت خودکار به <a href="users"><b>بخش کاربران</b></a> خواهید رفت.
            <script type="text/javascript">setTimeout("mhkform.redirect('panel')", 5000);</script>
            <br><br>
            <div style="text-align:left"><b>با تشکر، مدیریت مرکز</b></div>
        </div>
    </div>
<?php } ?>
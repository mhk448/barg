<div id="content-wrapper">
    <div id="content">
        <?php $message->display() ?>
        <?php if (!$user->isSignin()) { ?>
            <h1>ورود به سیستم</h1>
            <div style="padding: 10px 20px;">
                <b>نکات:‌</b>
                <ul class="disc">
                    <li><a href="retrive-password"><b>کلمه عبور را فراموش کرده اید؟</b></a></li>
                    <li>می خواهید از <?= $_ENUM2FA['fa']['work'] ?> کردن خود کسب درآمد کنید؟ <a href="register?type=worker">ثبت نام کنید</a>
                    <li>پروژه <?= $_ENUM2FA['fa']['work'] ?> دارید؟ <a href="register?type=user">ثبت نام کنید و آنرا به مناقصه بگذارید</a>
                </ul>
            </div>
            <form name="" method="post" class="form" action="panel">
                <input type="hidden" name="formName" value="LoginForm" />
                <label>نام کاربری</label>
                <input type="text" name="un" />
                <label>کلمه عبور</label>
                <input type="password" name="pw" />
                <label><input type="checkbox" name="al" style="width:auto;" /> <div style="float:right; margin-top:5px;"> به خاطر سپردن </div></label>
                <input type="submit" name="submit" id="submit" value="ورود به سیستم" />
            </form>
            <div class="clear"></div>
        <?php } elseif (!$user->hasGroup()) { ?>
            <h1>گروه کاربری</h1>
            <div style="padding: 10px 20px;">
                <b>
                    به بخش 
        <?= $_ENUM2FA['fa']['work'] ?>            
                    خوش آمدید
                    <br/>
                    لطفا نوع کاربری خود را مشخص نمایید:
                </b>

            </div>
            <br/>
            <br/>
            <br/>
            <br/>
            <form name="SignupForm" method="post" class="" action="users">
                <input type="hidden" name="formName" value="SelectGroup" />
                <input type="image" style="margin: 7px;padding: 4px" src="medias/images/theme/<?=$subSite?>_user.png" name="User" alt="سفارش <?= $_ENUM2FA['fa']['work'] ?> دارید؟" />
                <input type="image" style="margin: 7px;padding: 4px" src="medias/images/theme/<?=$subSite?>_worker.png" name="Worker" alt="<?= $_ENUM2FA['fa']['worker'] ?> هستید؟" />
            </form>
            <div class="clear"></div>
        <?php } ?>
    </div>
</div>

<?php
$type = (isset($_REQUEST['type']) AND in_array(strtolower($_REQUEST['type']), array('user', 'worker', 'agency'))) ? strtolower($_REQUEST['type']) : 'user';
if ($auth->validate('RegisterForm', array(
            array('un', 'UserName', 'نام کاربری صحیح نمی باشد.'),
            array('em', 'Email', 'آدرس پست الکترونیکی وارد شده ، صحیح نمی باشد.'),
            array('pw', 'Required', 'کلمه عبور را وارد نمایید.'),
            array('vpw', 'Required', 'تاییدیه کلمه عبور را وارد نمایید.'),
//            array('m', 'Required', 'شماره موبایل خود را وارد نمایید'),
        ))) {
    if ($user->signup()) {
        $user->signin();
//        include 'success-register.php';
        header("Location: success-register");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Login</title>

        <script src="/medias/scripts/jquery-2.0.0.min.js"></script>
        <script src="/medias/bootstrap/js/bootstrap.min.js"></script>

        <link href="/medias/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />    
        <link href='http://www.fontonline.ir/css/BNazanin.css' rel='stylesheet' type='text/css'>
        <style>
            body {
                background-color: #f4f4f4 !important;
                font-family: BNazanin,tahoma;
            }

            .container {
                background-color: #ffffff;
                border: 1px solid #dddddd;
                width: 396px;
                margin: 36px auto 28px;
                padding: 23px 35px 44px;
                text-align: center;
                -webkit-border-radius: 3px;
                -moz-border-radius: 3px;
                border-radius: 3px;
                -webkit-box-shadow: 0 0 6px rgba(0, 0, 0, 0.075);
                -moz-box-shadow: 0 0 6px rgba(0, 0, 0, 0.075);
                box-shadow: 0 0 6px rgba(0, 0, 0, 0.075);
            }

            .signin-logo img {
                margin-bottom: 40px;
            }

            .form-signin {
                padding: 15px;
                margin: 0 auto;
            }
            .form-signin .form-signin-heading,
            .form-signin .checkbox {
                margin-bottom: 10px;
            }
            .form-signin .checkbox {
                font-weight: normal;
            }
            .form-signin .form-control {
                position: relative;
                height: auto;
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
                padding: 10px;
                font-size: 16px;
                text-align: center;
            }
            .form-signin .form-control:focus {
                z-index: 2;
                border-color: #c3ea94;
                outline: 0;
                box-shadow: 0 0 0 0;
            }
            /*            .form-signin input[type="email"] {
                            margin-bottom: -1px;
                            border-bottom-right-radius: 0;
                            border-bottom-left-radius: 0;
                        }
                        .form-signin input[type="password"] {
                            margin-bottom: 10px;
                            border-top-left-radius: 0;
                            border-top-right-radius: 0;
                        }*/

            .divider-horizontal {
                height: 1px;
                width: 100%;
                background-color: #dddddd;
                border-bottom: 1px solid #DDD;
                text-align: center;
                margin-top: 24px;
                margin-bottom: 34px;
            }

            .divider-label {
                position: relative;
                display: inline-block;
                background-color: #f4f4f4;
                padding: 0 12px;
                top: -12px;
                font-size: 14px;
                background-color: #ffffff;
            }

            .btn-facebook {
                color: #ffffff;
                text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
                background-color: #3f5b97;
                background-image: -moz-linear-gradient(top, #44619d, #38538e);
                background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#44619d), to(#38538e));
                background-image: -webkit-linear-gradient(top, #44619d, #38538e);
                background-image: -o-linear-gradient(top, #44619d, #38538e);
                background-image: linear-gradient(to bottom, #44619d, #38538e);
                background-repeat: repeat-x;
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff44619d', endColorstr='#ff38538e', GradientType=0);
                border-color: #4668b3 #31487c #2a3e69;
                filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);
                border-color: #7791c9 #31487c #223357;
            }

            .btn-facebook:hover {
                color: #ffffff;
                text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
                background-color: #395389;
                background-image: -moz-linear-gradient(top, #3e588f, #324a7f);
                background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#3e588f), to(#324a7f));
                background-image: -webkit-linear-gradient(top, #3e588f, #324a7f);
                background-image: -o-linear-gradient(top, #3e588f, #324a7f);
                background-image: linear-gradient(to bottom, #3e588f, #324a7f);
                background-repeat: repeat-x;
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff3e588f', endColorstr='#ff324a7f', GradientType=0);
                border-color: #4160a4 #2b406d #24355b;
                filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);
                border-color: #6885c4 #2b406d #1d2a49;
            }
            .btn-facebook:hover, .btn-facebook:active, .btn-facebook.active, .btn-facebook.disabled, .btn-facebook[disabled] {
                color: #ffffff;
                background-color: #38538e;
            }

            .btn-google,
            .btn-google:hover {
                color: #ffffff;
                text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
                background-color: #e3533b;
                background-image: -moz-linear-gradient(top, #e95841, #db4b33);
                background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#e95841), to(#db4b33));
                background-image: -webkit-linear-gradient(top, #e95841, #db4b33);
                background-image: -o-linear-gradient(top, #e95841, #db4b33);
                background-image: linear-gradient(to bottom, #e95841, #db4b33);
                background-repeat: repeat-x;
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffe95841', endColorstr='#ffdb4b33', GradientType=0);
                border-color: #e3715e #cf3d25 #ba3721;
                filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);
                border-color: #eda79b #cf3d25 #a4301d;
            }

            .termAndCond {
                padding-top: 30px;
            }

            .already-have {
                margin-bottom: 50px;
            }

            .btn-signup {
                margin-top: 20px;
            }
            .btn-green {
                background-color: #27AC7F;
                box-shadow: inset 0 -1px 2px rgba(0,0,0,.3), 0 4px 10px rgba(0,0,0,0.2);
                border-color: #6AD1B1;
                color: #FFF;
                border-style: solid none none;
                background-image: linear-gradient(top, #33B58B, #1ba478);
                background-image: -o-linear-gradient(top, #33B58B, #1ba478);
                background-image: -moz-linear-gradient(top, #33B58B, #1ba478);
                background-image: -webkit-linear-gradient(top, #33B58B, #1ba478);
                background-image: -ms-linear-gradient(top, #33B58B, #1ba478);

                -webkit-transition: all .5s ease;
                -moz-transition: all .5s ease;
                -ms-transition: all .5s ease;
                -o-transition: all .5s ease;
                transition: all .5s ease;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <?php $message->display() ?>
            <form class="form-signin" method="post" action="register">
                <input type="hidden" name="formName" value="RegisterForm" />
                <a class="signin-logo" href="#"><img src="/medias/images/theme/logoBlack.png" height="80"></a>
                <br/>
                <label class="radio-inline">
                    <input type="radio" name="type" value="worker"> 
                    مترجم
                </label>
                 <label class="radio-inline">
                    <input type="radio" name="type" value="user" checked="checked"> 
                    کاربر
                </label>
                <br/>
                <label for="inputUsername" class="sr-only">نام کاربری</label>
                <input name="un" type="text" id="inputUsername"  class="form-control" placeholder="نام کاربری" required autofocus value="<?= $_REQUEST['em'] ?>">
                <label for="inputEmail" class="sr-only">ایمیل</label>
                <input name="em" type="email" id="inputEmail"  class="form-control" placeholder="ایمیل" required autofocus value="<?= $_REQUEST['em'] ?>">
                <label for="inputPassword" class="sr-only">گذرواژه</label>
                <input name="pw" type="password" id="inputPassword"  class="form-control" placeholder="گذرواژه" required value="<?= $_REQUEST['pw'] ?>">
                <label for="inputVPassword" class="sr-only">تکرار گذرواژه </label>
                <input name="vpw" type="password" id="inputVPassword" class="form-control" placeholder="گذرواژه" required>
                <br/>
                <input name="captcha" class="col-md-6 form-control" style="width: 50%" type="text" placeholder="کد امنیتی" required>
                <img src="captcha.php"  class="col-md-6 form-control" style="width: 50%;padding: 2px" />
                <br/><br/>
                <button class="btn btn-lg btn-green btn-block btn-signup" name="submit" type="submit">ساخت حساب جدید</button>
            </form>

            <!--            <div class="divider-horizontal login-divider-horizontal">
                            <span class="divider-label">یا</span>
                        </div>
            
                        <div class="login-with">
                            <h3>ورود با استفاده از</h3>
                            <div class="row">
                                <div class="col-md-6 col-xs-12">
                                    <a href="#">
                                        <button class="btn btn-block btn-facebook">فیسبوک</button>
                                    </a>
                                </div>
            
                                <div class="col-md-6 col-xs-12">
                                    <a href="#">
                                        <button class="btn btn-block btn-google">گوگل</button>
                                    </a>
                                </div>
                            </div>
                        </div>-->

            <p class="termAndCond">
                <a href="/rules">
                    با ثبت نام شما قوانین و مقررات ما می پذیرید
                </a>
            </p>

        </div> <!-- /container -->

        <div class="text-center already-have">
            <p>هم اکنون حساب کاربری دارید؟</p>
            <a href="/panel">ورود</a>
        </div>

    </body>
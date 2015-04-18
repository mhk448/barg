<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Login</title>
        <!-- Bootstrap 3.3.2 -->
        <link href="medias/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />    


        <link href='http://www.fontonline.ir/css/BNazanin.css' rel='stylesheet' type='text/css'>
        <style >
            body {
                background-color: #f4f4f4 !important;
                font-family: BNazanin,tahoma;
            }

            .container {
                background-color: #ffffff;
                border: 1px solid #dddddd;
                width: 396px;
                margin: 96px auto 28px;
                padding: 57px 35px 44px;
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
            .form-signin input[type="email"] {
                margin-bottom: -1px;
                border-bottom-right-radius: 0;
                border-bottom-left-radius: 0;
            }
            .form-signin input[type="password"] {
                margin-bottom: 10px;
                border-top-left-radius: 0;
                border-top-right-radius: 0;
            }

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

            <form class="form-signin" method="post" action="/panel">
                <input type="hidden" name="formName" value="LoginForm" />
                <a class="signin-logo" href="#"><img src="images/logo.png" height="40"></a>
                <label for="inputEmail" class="sr-only">رایانامه</label>
                <input type="text" name="un" id="inputEmail" class="form-control" placeholder="رایانامه" required autofocus>
                <label for="inputPassword" class="sr-only">گذرواژه</label>
                <input type="password" name="pw" id="inputPassword" class="form-control" placeholder="گذرواژه" required>
                <button class="btn btn-lg btn-green btn-block" name="submit" type="submit">ورود</button>
            </form>

            <!--<a class="text-right" href="#">گذر واژیتان را فراموش کردید؟  </a>-->
            <a class="text-right" href="/register">ساخت حساب کاربری جدید</a>
            <!--
                        <div class="divider-horizontal login-divider-horizontal">
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

        </div> <!-- /container -->

    </body>
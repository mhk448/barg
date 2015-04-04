<?
if (!$user->isSignin()) {
//if (!$user->isSignin() && getCurPageName() != "register") {
    showFastReg();
}
?>
<script type="text/javascript">
    subSite = '<?= $subSite; ?>';
    theme_bg_color = '<?= $_CONFIGS['Site'][$subSite]['bg_color'] ?>';
</script>
<div class="bg-theme"
     style="
     height: 20px;
     width: 100%;
     position: fixed;
     z-index: 5;
     ">

    <div class="body2">  
        <div class="right_panel header_logo">
            <a class="" <?= 'href="' . $_CONFIGS['Site']['Sub']['Path'] . '"' ?>>
                <div style="width: 210px;"></div>
<!--                <img style="width: 210px;"
                     alt=""
                     src="medias/images/theme/logo_null.png"/>-->
            </a>
            <br/>
            <!--                                <a href="/" > صفحه نخست</a> | 
                                            <a href="/forum" > تالار گفتگو</a> | 
                                            <a href="/blog" > وبلاگ</a>-->
        </div>
        <div class="left_panel">
            <div class="reglink">
                <div >
                    <? if (!$user->isSignin()) { ?>
                        <div style="padding-bottom: 7px;min-width: 100px" class="info bg-theme">
                            <a href="#top" onclick="$('.fastreg').slideToggle();" > ثبت نام + ورود</a>
                        </div>
                        <?
                    } else {
                        ?>
                        <div style="" class="info bg-theme">
                            <a href="/panel" >
                                <img class="user-img" src<?= '="' . $_CONFIGS['Site']['Path'] . 'user/avatar/UA_' . $user->id . '.png"' ?>
                                     align="absmiddle"  style="float: right;background-color: white;" width="32" height="32" />
                                <span class="english"> ..:: </span> 
                                <span class="english">
                                    <?= $user->getNickname() ?>
                                </span> 
                                <span class="english"> ::.. </span> 
                            </a>
                            <br/>
                            <a onclick="$('#topmenu-miniinfo').slideToggle()" title="اطلاعات کاربری">
                                <div class="btn img-split18-1-4"></div>
                            </a>
                            <a onclick="$('#topmenu-chat').slideToggle()" title="گفتگوی آنلاین">
                                <div class="btn img-split18-1-3"></div>
                            </a>
                            <a onclick="$('#topmenu-event').slideToggle()" title="رخدادهای جدید">
                                <div class="btn img-split18-1-2" id="mhkevent-counter-img">
                                </div>
                            </a>
                            <a onclick="return mhkform.confirm('می خواهید از پنل کاربری خارج شوید؟',this)" href="/users_logout" title="خروج">
                                <div class="btn img-split18-1-1"></div>
                            </a>
                        </div>
                        <div class="clear"></div>
                        <div style="height: 0">
                            <div id="topmenu-chat"  class="mini-info-box" >
                                <div  class="head">
                                    <img style="" class="close" onclick="$('#topmenu-chat').fadeOut()" alt="x" src="medias/images/icons/delete.png"/>
                                    ارتباط با ما
                                </div>
                                <div  class="content">
                                    <a href="send-message_1_S1" class="popup">
                                        تماس با پشتیبان
                                    </a><br/>
                                    <a href="send-message_1_S2" class="popup">
                                        ارسال نظرات                               
                                    </a>
                                </div>
                            </div>
                            <div id="topmenu-miniinfo" class="mini-info-box">
                                <div  class="head">
                                    <img style="" class="close" onclick="$('#topmenu-miniinfo').fadeOut()" alt="x" src="medias/images/icons/delete.png"/>
                                    اطلاعات کاربری
                                </div>
                                <div  class="content">
                                    <p>

                                        <?= $user->fullname ?>                                    
                                        <br/>
                                        <?= $user->username ?>                                    
                                        <br/>
                                        گروه کاربری:
                                        <?= $_ENUM2FA['usergroup'][$user->usergroup] ?>
                                        <br/>
                                        اعتبار:
                                        <?= $user->getCredit() ?>
                                        ریال
                                        <br/>
                                        درجه
                                        <?= ($user->rate) . ' از 7' ?>
                                    </p>

                                    <hr class="" style="margin: 3px 0 0 0;"/>
                                    <a href="edit-profile" class="ajax">
                                        + ویرایش 
                                    </a><br/>
                                    <a href="panel" class="ajax">
                                        + پنل کاربری
                                    </a>
                                </div>                            </div>
                            <div id="topmenu-event"  class="mini-info-box mhkevent-win">
                                <div  class="head">
                                    <img style="" class="close" onclick="$('#topmenu-event').fadeOut()" alt="x" src="medias/images/icons/delete.png"/>
                                    رخدادهای جدید
                                    (<span id="mhkevent-counter" style="">0</span>)
                                </div>
                                <div  class="content">
                                    <div style="display: none"></div>

                                    <!--رخداد جدیدی وجود ندارد-->
                                    <hr class="" style="margin: 3px 0 0 0;"/>
                                    <a href="events" class="ajax">
                                        +نمایش همه...
                                    </a>
                                </div>
                            </div>
                        </div>
                    <? } ?>
                </div>

            </div>
            <div id="main-menu" style="
                 /*left: -41px;*/
                 /*top: -18px;*/
                 /*width: 975px;*/
                 ">
                <ul>
                    <li class="sub-menu">
                        <a class="" <?= 'href="' . $_CONFIGS['Site']['Sub']['Path'] . '"' ?>>
                            <img style="
                                 margin: -7px 0;"
                                 alt=""
                                 src="medias/images/theme/home.png"/>
                        </a>
                    </li>
                    <li><a href="#">پروژه ها </a>
                        <ul class="sub-menu">
                            <li><a href="projects_open"><b>&#x2713; </b>پروژه‌های باز</a></li>
                            <li><a href="projects_run"><b>&#x2713; </b>پروژه‌های درحال اجرا</a></li>
                            <li><a href="projects_finish"><b>&#x2713; </b>پروژه‌های پایان یافته</a></li>
                        </ul>
                    </li>
                    <li><a href="#">کاربران</a>
                        <ul class="sub-menu">
                            <li><a href="#" onclick="$('.fastreg').slideToggle();"><b>&#x2713; </b> عضویت و ورود</a></li>
                            <li><a href="panel"><b>&#x2713; </b>پنل کاربری</a></li>
                            <li><a href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "/type-help/type-work" . '"'; ?> target="_blank"><b>&#x2713; </b>کسب درآمد</a></li>
                            <li><a href="user-list_worker"><b>&#x2713; </b>لیست  <?= $_ENUM2FA['fa']['workers'];?> </a></li>
                            <li><a href="group-list"><b>&#x2713; </b>لیست گروه ها</a></li>
                        </ul>
                    </li>
                    <li><a href="#">نمایندگی</a>
                        <ul class="sub-menu">
                            <li><a href="user-list_agency"><b>&#x2713; </b>لیست نمایندگان</a></li>
                            <li><a href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "/type-rols/agency" . '"'; ?> target="_blank" ><b>&#x2713; </b>شرایط نمایندگی</a></li>
                            <li><a href="request-for-representative"><b>&#x2713; </b>درخواست نمایندگی</a></li>
                        </ul>
                    </li>
                    <?if(isSubType()){?>
<!--                    <li><a href="#">تایپایران</a>
                        <ul class="sub-menu">
                            <li><a href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "/type-sub/type-about" . '"'; ?> target="_blank"><b>&#x2713; </b> درباره تایپایران</a></li>
                            <li><a href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "/type-sub/type-why" . '"'; ?> target="_blank"><b>&#x2713; </b>چرا تایپایران</a></li>
                            <li><a href<?= '="' . $_CONFIGS['Pathes']['Blog'] . '"'; ?> target="_blank"><b>&#x2713; </b>وبلاگ</a></li>
                            <li><a href<?= '="' . $_CONFIGS['Site']['Sub']['Forum'] . '"'; ?> target="_blank"><b>&#x2713; </b>تالار گفتمان</a></li>
                            <li><a href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "/type-sub/type-about" . '"'; ?> target="_blank" ><b>&#x2713; </b>درباره ما</a></li>
                            <li><a href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "/type-sub/type-contact" . '"'; ?> target="_blank" ><b>&#x2713; </b>ارتباط با ما</a></li>
                        </ul>
                    </li>-->
                    <?}?>
                    <?if(isSubTranslate()){?>
<!--                    <li><a href="#">ترجمه‌ایران</a>
                        <ul class="sub-menu">
                            <li><a href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "/type-sub/type-about" . '"'; ?> target="_blank"><b>&#x2713; </b> درباره ترجمه‌ایران</a></li>
                            <li><a href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "/type-sub/type-why" . '"'; ?> target="_blank"><b>&#x2713; </b>چرا ترجمه‌ایران</a></li>
                            <li><a href<?= '="' . $_CONFIGS['Pathes']['Blog'] . '"'; ?> target="_blank"><b>&#x2713; </b>وبلاگ</a></li>
                            <li><a href<?= '="' . $_CONFIGS['Site']['Sub']['Forum'] . '"'; ?> target="_blank"><b>&#x2713; </b>تالار گفتمان</a></li>
                            <li><a href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "/type-sub/type-about" . '"'; ?> target="_blank" ><b>&#x2713; </b>درباره ما</a></li>
                            <li><a href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "/type-sub/type-contact" . '"'; ?> target="_blank" ><b>&#x2713; </b>ارتباط با ما</a></li>
                        </ul>
                    </li>-->
                    <?}?>
                    <li><a href="/twitts">توئیت</a>
                        <ul class="sub-menu">
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="clear"></div>


        </div>
    </div>

</div>
<div style="height: 20px;"></div>
<div style="
     height: 58px;
     background-color: #5d5d5d;
     background-image: url('../medias/images/theme/menu.gif');
     background-repeat: repeat-x;
     z-index: 4;
     width: 100%;
     position: fixed;
     ">
</div>
<div style="height: 58px;"></div>


<script type="text/javascript">
    $('#navi_bg>.navi>a').click(function(){
        
        if($(this).parent('.navi').children('.sub').css('display')=='none'){
            $('.navi .sub').hide();
            $(this).parent('.navi').children('.sub').show();
        }else{
            $('.navi .sub').hide();
        }
    });
    

</script>
<?

function showFastReg() {
    global $_ENUM2FA;
?>
    <div class="fastreg bg-theme"
         style="
         height: 320px;
         display: none;
         width: 100%;
         position: fixed;
         padding: 20px;
         ">


        <div class="body">
            <div style="display: inline-block;width: 30%;">
                <h1 style="color: white;padding-bottom: 15px;">
                    ورود اعضا
                </h1>
                <div style="background-color: rgba(255,255,255,0.33);
                     border-radius: 5px;
                     padding: 15px;">
                    <form action="users" method="post" name="SignupForm">
                        <input type="hidden" value="LoginForm" name="formName"/>
                        <input style="background-color: white;
                               border-radius: 4px;
                               margin: 10px;
                               padding: 2px 10px 2px 2px;
                               width: 70%;
                               "
                               name="un"
                               placeholder="نام کاربری"
                               title="نام کاربری"
                               class="br-theme"
                               /><br/>
                        <input  style="background-color: white;
                                border-radius: 4px;
                                margin: 10px;
                                padding: 2px 10px 2px 2px;
                                width: 70%;
                                "
                                type="password"
                                name="pw"
                                placeholder="رمز عبور"
                                title="رمز عبور"
                                class="br-theme"
                                />
                        <br/>
                        <div style="width: 70%; text-align: right">
                            <input type="checkbox" style="width:auto;" name="al"/>
                            <span style=""> به خاطر سپردن </span>
                        </div>
                        <br/>
                        <input class="active_btn" type="submit" value="ورود"
                               style="
                               border: 1px solid white;
                               border-radius: 3px;
                               padding: 2px 20px;
                               "
                               name="submit"
                               /> 
                        <p style="margin-top: 30px;text-align: right;">
                            <a href="retrive-password" style="color: black;">
                                رمز عبور خود را فراموش کرده اید؟
                            </a>
                        </p>
                    </form>
                </div>
                <div style="float: left;width: 60%;background-color: white;">

                </div>
            </div>

            <div style="display: inline-block; height: 200px;border-right: 1px solid white;width: 1px;margin: 0 20px;">
            </div>
            <div style="width: 60%;display: inline-block;">
                <h1 style="color: white;padding-bottom: 15px;">
                    ثبت نام در سایت
                </h1>
                <div style="background-color: rgba(255,255,255,0.33);
                     border-radius: 5px;
                     padding: 15px;">
                    <form action="register" method="post" name="RegisterForm">
                        <input type="hidden" value="RegisterForm" name="formName"/>
                        <input style="background-color: white;
                               border-radius: 4px;
                               margin: 10px;
                               padding: 2px 10px 2px 2px;
                               width: 40%;
                               "
                               name="un"
                               placeholder="نام کاربری"
                               title="نام کاربری"
                               class="br-theme"
                               />
                        <input  style="background-color: white;
                                border-radius: 4px;
                                margin: 10px;
                                padding: 2px 10px 2px 2px;
                                width: 40%;
                                "
                                name="na"
                                class="br-theme"
                                placeholder="نام و نام خانوادگی"
                                title="نام و نام خانوادگی"
                                />
                        <br/>
                        <input style="background-color: white;
                               border-radius: 4px;
                               margin: 10px;
                               padding: 2px 10px 2px 2px;
                               width: 40%;
                               "
                               type="password"
                               name="pw"
                               placeholder="رمز عبور"
                               title="رمز عبور"
                               class="br-theme"
                               />
                        <input  style="background-color: white;
                                border-radius: 4px;
                                margin: 10px;
                                padding: 2px 10px 2px 2px;
                                width: 40%;
                                "
                                type="password"
                                name="vpw"
                                placeholder="تکرار رمز عبور"
                                title="تکرار رمز عبور"
                                class="br-theme"
                                />
                        <br/>
                        <input style="background-color: white;
                               border-radius: 4px;
                               margin: 10px;
                               padding: 2px 10px 2px 2px;
                               width: 40%;
                               "
                               name="em"
                               placeholder="ایمیل"
                               title="ایمیل"
                               class="br-theme"
                               />
                        <input  style="background-color: white;
                                border-radius: 4px;
                                margin: 10px;
                                padding: 2px 10px 2px 2px;
                                width: 40%;
                                "
                                type="text"
                                name="m"
                                placeholder="شماره موبایل"
                                title="شماره موبایل"
                                class="br-theme"
                                />
                        <br/>


                        <div style="width: 85%;text-align: right;margin-top: 30px;" >
                            نوع کاربری:
                            <br/>
                            <input type="radio" style="width:auto;margin-top: 5px; " name="type" value="worker"/>
                            <span style="margin-left: 15px;">
                                <?= $_ENUM2FA['fa']['worker'];?>  
                            </span>
                            <input type="radio" checked="checked" style="width:auto;" name="type" value="user"/>
                            <span style=";">
                                کارفرما
                            </span>
                            <input class="active_btn" type="submit" value="ثبت نام"
                                   style="
                                   border: 1px solid white;
                                   border-radius: 3px;
                                   padding: 2px 20px;
                                   float: left;
                                   "
                                   name="submit"
                                   /> 
                        </div>
                    </form>
                </div>
                <div style="float: left;width: 60%;background-color: white;">

                </div>
            </div>

        </div>
    </div>
    <div class="fastreg" style="height: 320px;display: none;"></div>

<? } ?>



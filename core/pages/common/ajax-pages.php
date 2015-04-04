<?php
/*
 * In The Name of GOD
 * @author MHK448
 * Email: MHK448@gmail.com
 * Created at: Aug 17, 2013 , 11:36:32 PM
 * mhkInfo:
 */

if ($_REQUEST['page'] == 'fastreg') {
    $afterlink = $_REQUEST['afterlink'];
    ?>
    <div class="fastreg bg-theme"
         style="
         height: 320px;
         /*width: 100%;*/
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
                        <input type="hidden" value="<?= $afterlink ?>" name="afterlink"/>
                        <input class="br-theme" style="background-color: white;
                               border-radius: 4px;
                               margin: 10px;
                               padding: 2px 10px 2px 2px;
                               width: 70%;
                               "
                               name="un"
                               placeholder="نام کاربری"
                               /><br/>
                        <input class="br-theme"  style="background-color: white;
                               border-radius: 4px;
                               margin: 10px;
                               padding: 2px 10px 2px 2px;
                               width: 70%;
                               "
                               type="password"
                               name="pw"
                               placeholder="رمز عبور"
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
                               color: white;
                               "
                               name="submit"
                               /> 
                        <p style="margin-top: 30px;text-align: right;">
                            <a href="#" style="color: black;">
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
            <div style="width: 50%;display: inline-block;">
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
                               class="br-theme" 
                               placeholder="نام کاربری"
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
                               class="br-theme" 
                               placeholder="رمز عبور"
                               />
                        <input  style="background-color: white;
                                border-radius: 4px;
                                margin: 10px;
                                padding: 2px 10px 2px 2px;
                                width: 40%;
                                "
                                type="password"
                                name="vpw"
                                class="br-theme" 
                                placeholder="تکرار رمز عبور"
                                />
                        <br/>
                        <input style="background-color: white;
                               border-radius: 4px;
                               margin: 10px;
                               padding: 2px 10px 2px 2px;
                               width: 40%;
                               "
                               name="em"
                               class="br-theme" 
                               placeholder="ایمیل"
                               />
                        <input  style="background-color: white;
                                border-radius: 4px;
                                margin: 10px;
                                padding: 2px 10px 2px 2px;
                                width: 40%;
                                "
                                type="text"
                                name="m"
                                class="br-theme" 
                                placeholder="شماره موبایل"
                                />
                        <br/>


                        <div style="width: 85%;text-align: right;margin-top: 30px;" >
                            نوع کاربری:
                            <br/>
                            <input type="radio" style="width:auto;margin-top: 5px; " name="al"/>
                            <span style="margin-left: 15px;">
                                <?= $_ENUM2FA['fa']['worker']; ?>  
                            </span>
                            <input type="radio" checked="checked" style="width:auto;" name="al"/>
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

    <?
}


if ($_REQUEST['page'] == 'project_bid') {
    $p = new Project((int) $_REQUEST['pid']);
    $list = $bid->getProjectBids($p);

    foreach ($list as $bid0) {
        $refer = $user->getDiscountReferer($p->user_id);
        $u = new User($bid0['user_id']);
        echo ' <div class="live_project_bid_div" style="display:inline-block;width: 200px;border: 1px dotted #000;padding: 10px;margin: 5px;">
                    <div class="' . ($refer==$u->id ? 'bg-orange' : 'bg-theme') . '" style="padding: 3px;margin: -5px">
..::                        پیشنهاد 
                        '
        . ($refer==$u->id ? ("ویژه") : ("انجام کار"))
        . ' ::..
                        <p style="font-size:11px;">
                        برای پروژه ی
                        ' . $p->title . '
                            </p>
                    </div>'
        . '<span style="float: right;margin-top: 7px;">' . $u->displayAvator(TRUE) . '</span>'
        . '<p style="margin-top: 10px;text-align: left;width: 100%">'
        . $persiandate->date('d F Y', $bid0['dateline']) .
        '<br/><span style="font-size: 10px;">ساعت: ' . $persiandate->date('H:i:s', $bid0['dateline']) . '</span>'
        . '</p>
                    <p style="padding: 5px">
                        <a href="user_' . $bid0['user_id'] . '" style="color: green;" class="popup" target="_blank">
                        ارسال کننده:'
        . $u->getNickname()
        . '</a></p>'
        . $u->displayCups($u->rate)
        . '<p style="text-align: justify;min-height:80px;">
                    ' . nl2br($bid0['message']) . '
                    </p>'
        . ($p->type == "Agency" ? "" : '
                    <p style="color: red;padding: 10px">
                        مبلغ پیشنهاد شده:
                        <span  class="">
                            ' . number_format($bid0['price']) . '
                        </span>
                        ریال
                    </p>') .
        '<div style="text-align: center">' .
        '<div class="' . ($bid0['accepted'] >= 0 ? 'bg-theme' : 'bg-red') . '">
                        ' . $_ENUM2FA['verified'][$bid0['accepted']] . '
                        </div>'
        . '<p style="text-align: right;padding: 10px">'
        . (($p->typist_id || $bid0['accepted'] == Event::$V_CANCEL) ? '' : ('<img src="medias/images/icons/tick.png" align="absmiddle" /><a onclick="mhkform.ajax(\'accept-bid_' . $bid0['id'] . '?ajax=1\')">قبول پیشنهاد</a><br/>' ))
        . '<img src="medias/images/icons/sms.png" align="absmiddle" />'
        . '<a onclick="mhkform.ajax(\'send-message_' . $bid0['user_id'] . '?ajax=1\')" >ارسال پیام</a>'
        . '<br/>'
        . '</p>
                    </div>
                    <div class="clear"></div>
            </div>';
    }
}
?>

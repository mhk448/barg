<?php

class Event {

    public static $V_NONE = 0;
    public static $V_ACC = 1;
    public static $V_AUTO_ACC = 2;
    public static $V_REJECT = -1;
    public static $V_NEED_EDIT = -2;
    public static $V_DELETE = -1;
    public static $V_CANCEL = -3;
    //
    public static $T_PAYMENT = 'payment';
    public static $T_PAYOUT = 'payout';
    public static $T_MESSAGE = 'message';
    public static $T_PROJECT = 'project';
    public static $T_BID = 'bid';
    public static $T_USER = 'user';
    public static $T_GROUP = 'group';
    public static $T_ADMIN = 'admin';
    //
    public static $A_SEND = 'send';
    public static $A_SUBMIT = 'submit';
    public static $A_EDIT = 'edit';
    public static $A_DELETE = 'delete';
    public static $A_RECEIVE = 'receive';
    public static $A_CANCEL = 'cancel';
    public static $A_ACC = 'acc';
    public static $A_REQUEST = 'request';
    // message
    public static $A_M_REVIEW = 'review';
    // project
    public static $A_P_FINAL_FILE_SUBMIT = 'finalfilesubmit';
    public static $A_P_FINAL_FILE_RECEIVE = 'finalfilereceive';
    public static $A_NEED_STAKEHOLDER = 'needstakeholder';
    public static $A_P_CLOSE = 'close';
    public static $A_P_RUN = 'run';
    public static $A_P_PAY_FEE = 'payfee';
    public static $A_PRIVATE = 'private';
    public static $A_REFERER = 'referer';
    // user
    public static $A_U_SIGNUP = 'signup';
    public static $A_U_R_PASSWORD = 'rpassword';
    public static $A_U_CHANGE_CREDIT = 'changecredit';
    // group
    public static $A_G_INVITE= 'invite';
    public static $A_G_INVITE_PROJECT= 'inviteproject';
    public static $A_G_SHARE_PROJECT= 'shareproject';
    public static $A_G_SPLIT_PRICE= 'splitprice';
    // admin
    public static $A_INFO= 'info';
    public static $A_WARN= 'warn';
    public static $A_ERROR= 'error';
    
    private function getContent($type, $action) {
        $content[$action] = array();
//////////////// Payout ////////////////////////////
        if ($type == self::$T_PAYOUT) {
            $content[self::$V_ACC] = array(
                'title' => "Payout Accept:: تایید برداشت",
                'body' => 'کاربر محترم، برداشت شما در این مرکز تایید شد و اعتبار آن به حساب بانکیتان افزوده گردید<br/><br/>مبلغ تایید شده:_price_  ریال <br/> _com_ ',
                'sms' => '',
                'read' => 0, // defult readed
            );
            $content[self::$V_REJECT] = array(
                'title' => 'Payout Reject ::عدم تایید برداشت',
                'body' => '                            درخواست پرداخت  به حساب شما مورد تایید قرار نگرفت<br/> _com_ ',
                'read' => 0,
            );
            $content[self::$A_REQUEST] = array(
                'title' => 'Request of Payout :: درخواست برداشت',
                'body' => 'کاربر گرامی درخواست برداشت شما با موفقیت ارسال گردید.<br>در زمان تعیین شده و پس از بررسی های لازم مبلغ مورد نظر به حساب شما پرداخت خواهد شد',
                'read' => 1,
            );
        }
//////////////// Payment ////////////////////////////
        else if ($type == self::$T_PAYMENT) {
            $content[self::$V_ACC] = array(
                'title' => "Payment Accept:: تایید پرداخت",
                'body' => 'کاربر محترم، پرداخت شما در  _site_sub_nickname_  تایید شد و اعتبار آن به حساب کاربریتان افزوده گردید<br/><br/>مبلغ تایید شده:_price_  ریال <br/> <p style="display:none">_com_</p>',
                'sms' => '',
                'read' => 1,
            );
            $content[self::$V_REJECT] = array(
                'title' => 'Payment Reject ::عدم تایید پرداخت',
                'body' => 'پرداخت شما مورد تایید قرار نگرفت لطفا مستندات خود را به پشتیبانی سایت ارائه نمایید',
                'read' => 0,
            );
        }
//////////////// message ////////////////////////////
        else if ($type == self::$T_MESSAGE) {
            $content[self::$A_SEND] = array(
                'title' => "New Message :: پیام جدید",
                'body' => 'کاربر محترم، شما یک پیام جدید از طرف'
                . ' _nickname_ ' . 'دریافت نموده اید' . '<br/>' . ''
                . '<a class="ajax" href="_site_sub_path_message__msgid_">' . 'نمایش پیام'
                . '</a>',
                'sms' => '',
                'read' => 0,
            );
            $content[self::$A_M_REVIEW] = array(
                'title' => 'Review Request :: ثبت درخواست بازبینی',
                'body' => 'کاربر گرامی درخواست بازبینی برای پروژه ی '
                . ' _prjtitle_ ' . 'ثبت شد' . '<br/>' . ''
                . '<a class="ajax" href="_site_sub_path_project__prjid_">' . 'نمایش پروژه'
                . '</a>',
                'sms' => '',
                'read' => 1,
            );
        }
//////////////// project ////////////////////////////
        else if ($type == self::$T_PROJECT) {
            $content[self::$A_SUBMIT] = array(
                'title' => 'Project Submit :: ارسال پروژه',
                'body' => 'کاربر گرامی پروژه ی شما با عنوان  [ '
                . ' _prjtitle_ ' . ' ] با موفقیت ثبت شد' . '<br/>' . ''
                . '<a class="ajax" href="_site_sub_path_project__prjid_">' . 'نمایش جزئیات پروژه'
                . '</a>',
                'sms' => '',
                'read' => 1,
            );
            $content[self::$A_ACC] = array(
                'title' => 'Project Verified :: تایید پروژه',
                'body' => 'کاربر گرامی پروژه ی شما با عنوان '
                . ' _prjtitle_ ' . ' مورد تایید واقع شده و در وب سایت قرار گرفت' . '<br/>' . ''
                . '<a class="ajax" href="_site_sub_path_project__prjid_">' . 'نمایش جزئیات پروژه'
                . '</a>',
                'sms' => '',
                'read' => 1,
            );
            $content[self::$V_NEED_EDIT] = array(
                'title' => 'Edit Project :: ویرایش پروژه',
                'body' => 'کاربر گرامی پروژه ی شما با عنوان  [ '
                . ' _prjtitle_ ' . ' ] نیاز به اصلاح دارد لطفا بازبینی نمایید' . '<br/>' . ''
                . '<a class="ajax" href="_site_sub_path_project__prjid_">' . 'نمایش جزئیات پروژه'
                . '</a>',
                'sms' => '',
                'read' => 0,
            );
            $content[self::$A_EDIT] = array(
                'title' => 'Edit Project :: ویرایش پروژه',
                'body' => 'کاربر گرامی پروژه ی شما با عنوان  [ '
                . ' _prjtitle_ ' . ' ] اصلاح شد' . '<br/>' . ''
                . '<a class="ajax" href="_site_sub_path_project__prjid_">' . 'نمایش جزئیات پروژه'
                . '</a>',
                'sms' => '',
                'read' => 1,
            );
//            $content[self::$A_DELETE] = array(
//                'title' => 'Delete Project :: حذف پروژه',
//                'body' => 'کاربر گرامی پروژه ی شما با عنوان  [ '
//                . ' _prjtitle_ ' . ' ] حذف شد' . '<br/>' . ''
//                . '<a class="ajax" href="_site_sub_path_project__prjid_">' . 'نمایش جزئیات پروژه'
//                . '</a>',
//                'sms' => '',
//                'read' => 1,
//            );
            $content[self::$V_DELETE] = array(
                'title' => 'Delete Project :: حذف پروژه',
                'body' => 'کاربر گرامی پروژه ی شما با عنوان  [ '
                . ' _prjtitle_ ' . ' ] حذف شد' . '<br/>' . ''
                . '<a class="ajax" href="_site_sub_path_project__prjid_">' . 'نمایش جزئیات پروژه'
                . '</a>',
                'sms' => '',
                'read' => 1,
            );
            $content[self::$A_P_FINAL_FILE_SUBMIT] = array(
                'title' => 'Final File Submit :: ارسال فایل نهایی',
                'body' => 'کاربر گرامی فایل نهایی مربوط به پروژه ی '
                . ' _prjtitle_ ' . ' با موفقیت ارسال شد' . '<br/>' . ''
                . '<a class="ajax" href="_site_sub_path_project__prjid_">' . 'نمایش جزئیات پروژه'
                . '</a>',
                'sms' => '',
                'read' => 1,
            );
            $content[self::$A_P_FINAL_FILE_RECEIVE] = array(
                'title' => 'Final File Submit :: دریافت فایل نهایی',
                'body' => 'کاربر گرامی فایل نهایی مربوط به پروژه ی '
                . ' _prjtitle_ ' . ' آماده تحویل است ' . '<br/>' . ''
                . '<a class="ajax" href="_site_sub_path_project__prjid_">' . 'نمایش جزئیات پروژه'
                . '</a>',
                'sms' => '',
                'read' => 0,
            );
            $content[self::$A_P_CLOSE] = array(
                'title' => 'Project State Change :: تغییر وضعیت پروژه',
                'body' => 'کاربر گرامی پروژه ی شما با عنوان   '
                . ' _prjtitle_ ' . '  بسته شد' . '<br/>' . ''
                . '<a class="ajax" href="_site_sub_path_project__prjid_">' . 'نمایش جزئیات پروژه'
                . '</a>',
                'sms' => '',
                'read' => 0,
            );
            $content[self::$A_NEED_STAKEHOLDER] = array(
                'title' => 'Need Stakeholder :: نیاز به گروگزاری',
                'body' => 'کاربر گرامی مجری پروژه ی "'
                . ' _prjtitle_ ' . '" مشخص شده و منتظر گروگذاری شماست'
                . '<br/>' . ''
                . '<a class="ajax" href="_site_sub_path_project__prjid_" target="_blank">' . 'نمایش جزئیات پروژه'
                . '</a>',
                'sms' => '',
                'read' => 0,
            );
            $content[self::$A_P_RUN] = array(
                'title' => 'Project Start :: شروع پروژه',
                'body' => 'کاربر گرامی اجرای پروژه ی شما با عنوان  [ '
                . ' _prjtitle_ ' . ' ]  شروع شد' . '<br/>' . ''
                . '<a class="ajax" href="_site_sub_path_project__prjid_?start=1" target="_blank">' . 'نمایش جزئیات پروژه'
                . '</a>',
                'sms' => '',
                'read' => 0,
            );
            $content[self::$A_CANCEL] = array(
                'title' => 'Project Canceled :: انصراف از پروژه',
                'body' => 'کاربر گرامی مجری پروژه ی شما با عنوان '
                . ' _prjtitle_ ' . ' از ادامه کار انصراف داده است '
                . '<br/>' . 'لطفا سایر پیشنهادات را بررسی نمایید'
                . '<br/>' . 'لازم به ذکر است که انصراف از پروژه در بازه زمانی مجاز انجام شده است.'
                . '<br/>' . ''
                . '<a class="ajax" href="_site_sub_path_project__prjid_">' . 'نمایش جزئیات پروژه'
                . '</a>',
                'sms' => 'پروژه ی شما با کد ' . 'T_prjid_' . ' لغو شد',
                'read' => 0,
            );
            $content[self::$A_PRIVATE] = array(
                'title' => 'Private Project :: پروژه اختصاصی',
                'body' => 'مجری محترم: پروژه ای با عنوان '
                . ' _prjtitle_ ' . 'به صورت اختصاصی برای شما ارسال شده است'
                . '<br/>' . ''
                . '<a class="ajax" href="_site_sub_path_project__prjid_">' . 'نمایش جزئیات پروژه'
                . '</a>',
                'sms' => '',
                'read' => 0,
            );
            $content[self::$A_REFERER] = array(
                'title' => 'Private Project :: پروژه اختصاصی',
                'body' => 'مجری محترم: پروژه ای با عنوان '
                . ' _prjtitle_ ' . 'به صورت اختصاصی برای شما ارسال شده است'
                . '<br/>' . ''
                . '<a class="ajax" href="_site_sub_path_project__prjid_">' . 'نمایش جزئیات پروژه'
                . '</a>',
                'sms' => '',
                'read' => 0,
            );
            $content[self::$A_P_PAY_FEE] = array(
                'title' => 'Project Pay Fee ::  پرداخت دستمزد ',
                'body' => 'کاربر گرامی: مبلغ'
                . ' _price_ ' . 'ریال ' . ' بابت دستمزد پروژه ی '
                . ' "_prjtitle_" ' . 'به اعتبارات حسابتان اضافه شد'
                . '<br/>' . '',
//                . '<a class="" onclick="location.reload(false)">' . ''
//                . '</a>',
                'sms' => '',
                'read' => 0,
            );
        }
//////////////// bid ////////////////////////////
        else if ($type == self::$T_BID) {
            $content[self::$A_SUBMIT] = array(
                'title' => 'Bid Submit :: ارسال پیشنهاد',
                'body' => 'کاربر گرامی پیشنهاد شما برای پروژه ی '
                . ' _prjtitle_ ' . ' با موفقیت ارسال شد' . '<br/>' . ''
                . '<a class="ajax" href="_site_sub_path_project__prjid_">' . 'نمایش جزئیات پروژه'
                . '</a>',
                'sms' => '',
                'read' => 1,
            );
            $content[self::$A_RECEIVE] = array(
                'title' => 'Bid Submit :: ارسال پیشنهاد',
                'body' => 'کاربر گرامی برای پروژه ی '
                . ' _prjtitle_ ' . ' پیشنهاد جدیدی ارسال شده است' . '<br/>' . ''
                . '<a class="ajax" href="_site_sub_path_project__prjid_">' . 'نمایش جزئیات پروژه'
                . '</a>',
                'sms' => '',
                'read' => 0,
            );
            $content[self::$A_ACC] = array(
                'title' => 'Bid Accepeted :: قبول پیشنهاد',
                'body' => 'کاربر گرامی پیشنهاد شما برای پروژه ی '
                . ' _prjtitle_ ' . ' مورد تایید قرار گرفته و برنده ی مناقصه شده است'
                . '<br/>' . 'شما می توانید پروژه را شروع نمایید'
                . '<br/>' . ''
                . '<a class="ajax" href="_site_sub_path_project__prjid_">' . 'نمایش جزئیات پروژه'
                . '</a>',
                'sms' => 'پیشنهاد انجام پروژه با کد' . ' _site_sub_code__prjid_ ' . 'تایید شد'.'\n_site_sub_nickname_',
                'read' => 0,
            );
            $content[self::$A_CANCEL] = array(
                'title' => 'Bid Canceled :: انصراف از پیشنهاد',
                'body' => 'کاربر گرامی پیشنهاد شما برای پروژه ی '
                . ' _prjtitle_ ' . ' لغو شد'
                . '<br/>' . ''
                . '<a class="ajax" href="_site_sub_path_project__prjid_">' . 'نمایش جزئیات پروژه'
                . '</a>',
                'sms' => '',
                'read' => 1,
            );
            $content[self::$V_NEED_EDIT] = array(
                'title' => 'Bid Rejected ::  پیشنهاد نامعتبر ',
                'body' => 'کاربر گرامی پیشنهاد شما برای پروژه ی '
                . ' _prjtitle_ ' . ' به دلیل اختلاف زیاد با تعرفه، توسط سیستم لغو شد'
                . '<br/>' . ''
                . '<a class="ajax" href="_site_sub_path_project__prjid_">' . 'نمایش جزئیات پروژه'
                . '</a>',
                'sms' => '',
                'read' => 0,
            );
        }
//////////////// user ////////////////////////////
        else if ($type == self::$T_USER) {
            $content[self::$A_U_SIGNUP] = array(
                'title' => 'Welcome :: به _site_sub_nickname_ خوش آمدید',
                'body' => 'کاربر گرامی ورود شما را به '
                . ' _site_sub_nickname_ ' . 'تبریک می گوییم' . '<br/>',
                'sms' => '',
                'read' => 0,
            );
            $content[self::$A_U_R_PASSWORD] = array(
                'title' => 'Retrive Password :: بازیابی کلمه عبور',
                'body' => 'کلمه عبور شما با موفقیت بازیابی گردید'
                . "<br/>" . 'رمز عبور جدید شما' . "<br/>" . '_newpass_',
                'sms' => 'رمز عبور جدید شما:' . "\n" . '_newpass_' . "\n" . ' _site_sub_nickname_ ',
                'read' => 0,
            );
            $content[self::$A_U_CHANGE_CREDIT] = array(
                'title' => 'Change Credit :: تغییر اعتبار',
                'body' => 'کاربر گرامی: اعتبار شما به ارزش '
                . ' _price_ ' . 'ریال' . ' تغییر داده شد'
                . '<br/>' . ''
                . '<a class="ajax" href="_site_sub_path_report">' . 'نمایش تراکنش های مالی'
                . '</a>',
                'sms' => '',
                'read' => 0,
            );
        }
////////////////  ////////////////////////////
        else if ($type == self::$T_GROUP) {
            $content[self::$A_G_INVITE] = array(
                'title' => 'Invite To Group :: دعوت به گروه',
                'body' => 'کاربر گرامی شما به عضویت در گروه '
                . ' _title_ ' .' دعوت شده اید'
                . '<br/>' . ''
                . '<a class="active_btn" href="_site_sub_path_edit-group">' . 'نمایش جزئیات گروه'
               . '</a>',
                'sms' => '',
                'read' => 0,
            );
            $content[self::$A_G_INVITE_PROJECT] = array(
                'title' => 'Invite To Project :: دعوت به انجام پروژه',
                'body' => 'کاربر گرامی شما به انجام پروژه '
                . ' _title_ ' .' دعوت شده اید'
                . '<br/>' . ''
                . '<br/>' . '_msg_'
                . '<br/>' . ''
                . '<a class="active_btn" href="_site_sub_path_project__pid_">' . 'نمایش جزئیات پروژه'
               . '</a>',
                'sms' => '',
                'read' => 0,
            );
            $content[self::$A_G_SHARE_PROJECT] = array(
                'title' => 'Invite To Project :: دعوت به انجام پروژه',
                'body' => 'کاربر گرامی شما به انجام پروژه '
                . ' _title_ ' .' دعوت شده اید'
                . '<br/>' . ''
                . '<br/>' . '_msg_'
                . '<br/>' . ''
                . '<a class="active_btn" href="_site_sub_path_project__pid_">' . 'نمایش جزئیات پروژه'
               . '</a>',
                'sms' => '',
                'read' => 0,
            );
            $content[self::$A_G_SPLIT_PRICE] = array(
                'title' => 'Project Pay Fee ::  پرداخت دستمزد ',
                'body' => 'کاربر گرامی: مبلغ'
                . ' _price_ ' . 'ریال ' . ' بابت انجام گروهی پروژه ی '
                . ' "_prjtitle_" ' .' توسط کاربر '
                .' "_unickname_" '. 'به اعتبارات حسابتان اضافه شد'
                . '<br/>' . '',
                'sms' => '',
                'read' => 0,
            );
        }
        ////////////////  ////////////////////////////
        else if ($type == self::$T_ADMIN) {
            $content[self::$A_INFO] = array(
                'title' => 'Admin Info :: پیام مدیر',
                'body' => '_msg_',
                'sms' => '_msg_',
                'read' => 0,
            );
            $content[self::$A_WARN] = array(
                'title' => 'Admin Info :: هشدار مدیر',
                'body' => '_msg_',
                'sms' => '_msg_',
                'read' => 0,
            );
            $content[self::$A_ERROR] = array(
                'title' => 'Admin Info ::  خطا',
                'body' => '_msg_',
                'sms' => '_msg_',
                'read' => 0,
            );
        }
////////////////  ////////////////////////////
//        else if ($type == self::) {
//            $content[] = array(
//                'title' => '',
//                'body' => '',
//                'email' => '',
//                'sms' => ''
//            );
//        }

        return $content[$action];
    }

    public function call($user_id, $type, $action, $param = NULL, $sendSms = TRUE, $sendEmail = TRUE, $sendEvent = TRUE, $sendSuportMessage = FALSE) {
        global $database, $cdatabase, $personalmessage, $_CONFIGS;
        $dateline = time();
        $user_id = intval($user_id);
        $content = $this->getContent($type, $action);

        $t = explode("::", $content['title']);
        $content['title'] = $t[1];

        $ga = array(
            'site_sub_nickname' => $_CONFIGS['Site']['Sub']['NickName'],
            'site_sub_nickpath' => $_CONFIGS['Site']['Sub']['NickPath'],
            'site_sub_name' => $_CONFIGS['Site']['Sub']['Name'],
            'site_sub_path' => $_CONFIGS['Site']['Sub']['Path'],
            'site_sub_code' => $_CONFIGS['Site']['Sub']['code'],
        );
        if ($param !== NULL)
            $param = array_merge($ga, $param);
        else {
            $param = $ga;
        }

        if ($param !== NULL AND is_array($param)) {
            foreach ($param as $pkey => $pvalue) {
                foreach ($content as $ckey => $cvalue) {
                    $content[$ckey] = str_replace('_' . $pkey . '_', $pvalue, $cvalue);
                }
            }
        }


        if ($sendEvent) {
            $refid = (int) isset($param['prjid']) ? $param['prjid'] : (isset($param['msgid']) ? $param['msgid'] : 0);
            $database->insert('events', array(
                'user_id' => (int) $user_id,
                'dateline' => $dateline,
                'type' => $type,
                'action' => $action,
                'ref_id' => $refid,
                'title' => $content['title'],
                'body' => $content['body'],
                'readed' => (($user_id == 113 || $user_id == 2209 || $user_id == 3618)&& ($type == Event::$T_BID || $type == Event::$T_PROJECT)) ? 1 : $content['read']) //nc? tof iranian id =113
            );
        }


        if ($sendEmail) {
            $body = $content['body'];
            if (isset($content['email'])) {
                $body = $content['email'];
            }
            $personalmessage->sendEmail($user_id, $content['title'], $body, $type);
        }

        if ($sendSms) {
//            $body = $content['body'];
            if (isset($content['sms']) && $content['sms']) {
                $body = $content['sms'];
                $personalmessage->SMSSend(User::$SMS, $user_id, $body);
            }
        }

        if ($sendSuportMessage) {
            $body = $content['body'];
            if (isset($content['message'])) {
                $body = $content['message'];
            }
            $cdatabase->insert('messages', array(
                'from_id' => User::$SUPORT,
                'to_id' => (int) $user_id,
                'subsite' => $_CONFIGS['subsite'],
                'dateline' => time(),
                'title' => $content['title'],
                'body' => $body,
                'readed' => 0,
                'verified' => 1,
                'is_support' => 0
            ));
        }
    }

//    public function call($uid, $title, $body) {
//        global $database, $user, $mailer, $persiandate;
//        $dateline = time();
//        $database->insert('events', array(
//            'user_id' => (int) $uid,
//            'dateline' => $dateline,
//            'title' => $title,
//            'body' => $body));
//        $email = $user->getEmail?depricated($uid);
//        $mailer->sendMail($email, $title, '<a href="http://bargardoon.com/"><b>مرکز</b></a><br><br>' . $body . '<hr>تاریخ: ' . $persiandate->date('d F Y ساعت H:i:s', $dateline));
//    }

    public function setRead($id) {
        global $database;
        $database->update('events', array(
            'readed' => 1
                ), $database->whereId($id));
    }
    
     public function setReadAll($uid) {
        global $database;
        $database->update('events', array(
            'readed' => 1
                ), $database->whereId($uid,'user_id'));
    }

    public function setReadAllProject($user_id, $project_id) {
        global $database;
        $database->update('events', array(
            'readed' => 1
                ), $database->whereId($uid,'user_id') ." AND ");
    }

}

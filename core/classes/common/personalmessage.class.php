<?php

/*
 * In The Name of GOD
 * @author MHK448
 * Email: MHK448@gmail.com
 * Created at: Jul 25, 2013 , 8:19:04 AM
 * mhkInfo:
 */

/* @var $database Database */
/* @var $cdatabase Database */
/* @var $user User */
/* @var $message Message */

/**
 * Description of personalMessage
 *
 * @author MHK448
 */
class PersonalMessage {

    public function send($from, $to, $title, $body, $replyId = 0, $project_id = -1, $support = 0, $attached_files = '') {
        global $cdatabase, $message, $files, $_CONFIGS, $event, $user;

        if ($user->id != $from && !$user->isAdmin())
            return FALSE;

        // Upload file
//        $file_name = '';
//        if (isset($_FILES['fl']['name']) && $_FILES['fl']['name'] != '') {
//            $file_name = $files->generateUniqueFileName('zip');
//            if (!$files->upload('fl', $file_name, 'uploads/message/', 1024 * 1024 * 20, 'zip')) {
//                $message->addError('فایل مورد نظر معتبر نمی باشد.');
//                return false;
//            }
//        }
//        if ($support && $user->isAdmin())
//            $from = User::$SUPORT;// bad
//        if ($support)
//            Report::addLog("send support");

        $file_name = '';
        if ($attached_files) {
            $attached_files = str_replace('\\', "", $attached_files);
            $f = json_decode($attached_files, TRUE);
            $file_name = $f[0];
//            $file_name = substr($attached_files, 3, strlen($attached_files) - 6);
            if (!$file_name) {
                Report::addLog("d5dfd5dfgdf: send empty attached: " + $file_name);
            }
        }

        if ($to == User::$SUPORT && !$support)
            $support = 1;

        $cdatabase->insert('messages', array(
            'from_id' => (int) $from,
            'to_id' => (int) $to,
            'reply_id' => (int) $replyId,
            'subsite' => $_CONFIGS['subsite'],
            'project_id' => intval($project_id),
            'dateline' => time(),
            'title' => $title,
            'body' => $body,
            'attached_file' => $file_name,
            'readed' => 0,
            'verified' => $this->filter($title . $body, $support),
            'is_support' => intval($support)
        ));
        $msgid = $cdatabase->getInsertedId();
        $message->addMessage('پیام شما با موفقیت ارسال گردید.');

        if ($support && $user->hasFeature(User::$F_SUPPORT))
            $from = User::$SUPORT;

        $event->call($to, Event::$T_MESSAGE, Event::$A_SEND
                , array(
            'nickname' => $user->getNickname($from),
            'msgid' => $msgid,
                ), FALSE, (intval($project_id) > 0));
        return $msgid;
    }

    public function setRead($id) {
        global $cdatabase;
        return $cdatabase->update('messages', array(
                    'readed' => 1
                        ), $cdatabase->whereId($id));
    }

    public function setVerified($id, $v) {
        global $cdatabase;
        $v = (int) $v;
        return $cdatabase->update('messages', array(
                    'verified' => $v
                        ), $cdatabase->whereId($id));
    }

    private function sendSMSService($mobile, $message) {
        global $_CONFIGS;
        if ($_CONFIGS['TestMode'])
            return -1;
        $message = urlencode($message);
        // http://login.irpayamak.com/API/GetInbox.ashx?username=gooya&password=gooya&to=300089008900&year=1392&month=6&day=20
        $url = "http://smsfa.net/API/SendSms.ashx?username=".$_CONFIGS["SMS"]["username"]."&password=".$_CONFIGS["SMS"]["password"]."&from=".$_CONFIGS["SMS"]["from"]."&to=$mobile&text=$message";
        $agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $id_sms = curl_exec($ch); // returned sms id
        curl_close($ch);
        //<-- prv sms webservice -->
        //$client = new SoapClient(null, array('location' => "http://irpayamak.info/webservice.php", 'uri' => "urn://tyler/req"));
        //$result = $client -> __soapCall("send_sms", array('irtranslator321', '9177174733', array($message), array($mobile), '30008364524619', array('0'), array(NULL), array('1'), array('1')));
        //print_r($result);
        //<-- end -->
        return $id_sms;
    }

    public static function checkCreditSMSService() {
        global $_CONFIGS;
        $url = "http://login.irpayamak.com/API/GetCredit.ashx?username=gooya&password=gooya&from=300089008900&to=$mobile&text=$message";
        $agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $c = curl_exec($ch);
        curl_close($ch);
        return round($c);
    }

    public function SMSSend($sender, $receiver, $msg) {
        global $cdatabase, $creditlog, $_PRICES, $_CONFIGS, $message;
        if ($_CONFIGS['TestMode']) {
            $message->displayError('send SMS sender: ' . $sender . ' receiver: ' . $receiver . ' msg: ' . $msg);
        }

        if ($sender == User::$SMS) {
            $message = new Message();
        }

        $user = new User($sender);
        $msg = trim($msg);
        if (!$msg) {
            return FALSE;
        }
        $mobile = $cdatabase->selectField('users', 'mobile', $cdatabase->WhereId($receiver));
        if (trim($mobile) != '' AND is_numeric($mobile) AND strlen($mobile) >= 10) {

            $l = (int) (mb_strlen($msg . $_CONFIGS['SMS_Postfix'], "UTF-8") / 70) + 1;

            if (($user->isAdmin() || $sender == User::$SMS) || $user->getCredit() > ($_PRICES['SMS'] + $_PRICES['P_SMS']) * $l) {
                $id_sms = $this->sendSMSService($mobile, $msg . $_CONFIGS['SMS_Postfix']);

                if (!$id_sms) {
                    $id_sms = -1;
                }
                $cdatabase->insert('sms', array(
                    'sender' => intval($sender),
                    'receiver' => intval($receiver),
                    'subsite' => $_CONFIGS['subsite'],
                    'phone' => $mobile,
                    'message' => $msg,
                    'service_id' => ($id_sms),
                    'verified' => $this->filter($msg),
                    'dateline' => time()
                ));
                $id = $cdatabase->getInsertedId();

                if (($id_sms) < 0) {
                    global $event;
                    $message->addError("خطا در سرویس ارسال پیامک");
                    $msg0="مشکل در ارسال پیامک";
                    $msg0.="<br>";
                    $msg0.="<a href><a>";
                    $msg0.="<br>";
                    $msg0.=$msg;
                    $msg0.="<br>";
                    $msg0.="id:".$id;
                    $event->call(User::$ADMIN_1, Event::$T_ADMIN, Event::$A_WARN, array("msg" => $msg0), FALSE, FALSE, TRUE, TRUE);
                    return FALSE;
                }

                if ($sender != User::$SMS)
                    $message->addMessage("پیامک با موفقیت ارسال شد");


                if ($sender == User::$SMS) {
                    
                } else {
                    $creditlog->sub($sender, ($_PRICES['SMS'] + $_PRICES['P_SMS']) * $l
                            , 'sms', $id, "");
                    $creditlog->add(User::$SMS, ($_PRICES['SMS'] + $_PRICES['P_SMS']) * $l
                            , 'sms', $id, "");
                }
                return $id;
            } else {
                if ($sender != User::$SMS)
                    $message->addError("اعتبار شما کم است");
                return FALSE;
            }
        } else {
            if ($sender != User::$SMS)
                $message->addError("امکان ارسال پیامک به این کاربر وجود ندارد");
            return FALSE;
        }
    }

    public function SMSInbox($user_id) {
        
    }

    public function SMSSent($user_id) {
        
    }

    public function countNewMessage() {
        global $cdatabase, $user;
        return $cdatabase->selectCount('messages', $cdatabase->whereId($user->id, 'to_id'), ' verified=0 ');
    }

    public function countNewSupport() {
        global $cdatabase, $user;
        if ($user->isAdmin()) {
            return $cdatabase->selectCount('messages', ' WHERE verified=0 AND is_support>0 ');
        }
    }

    public function countNewSMS() {
        global $cdatabase, $user;
        //nc?
    }

    public function filter($text, $support = 0) {
        global $user;
        if ($user->isAdmin())
            return Event::$V_AUTO_ACC;

        if ($support)
            return Event::$V_NONE;

        $fword = array('09', '۰۹', 'ایمیل', 'آدرس', 'ادرس', 'email', '93', '91', 'mail', 'com', 'موبا', 'تلفن');
//        if (!$user->isAdmin()) {
        foreach ($fword as $word) {
//             if (!preg_match("/*^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+*$/", $this->email)) {
            if (mb_stripos($text, $word, 0, "UTF-8") !== FALSE) {
                return Event::$V_NONE;
            }
        }
//        }
        return Event::$V_AUTO_ACC;
    }

    public function sendEmail($user_id, $title, $body, $type) {
        global $persiandate, $_CONFIGS;

        $canSend = FALSE;

        $prj_a = array(
            Event::$T_PROJECT,
            Event::$T_PAYMENT,
        );
        $bid_a = array(
            Event::$T_BID,
        );
        $msg_a = array(
            Event::$T_MESSAGE,
        );
        $sys_a = array(
            Event::$T_PAYOUT,
            Event::$T_USER,
        );

        $type_prj = in_array($type, $prj_a);
        $type_bid = in_array($type, $bid_a);
        $type_msg = in_array($type, $msg_a);
        $type_sys = in_array($type, $sys_a);

        $u = new User($user_id);
        $u_prj = $u->send_projects_list;
        $u_bid = $u->send_bid_email;
        $u_msg = $u->send_notify_email;

        if ($type_prj && $u_prj)
            $canSend = TRUE;

        if ($type_bid && $u_bid)
            $canSend = TRUE;

        if ($type_msg && $u_msg)
            $canSend = TRUE;

        if ($type_sys)
            $canSend = TRUE;


        if (!$u->email)
            $canSend = FALSE;

        if ($canSend) {
            if ($_CONFIGS['TestMode']) {
                global $message;
                $message->displayError('send Email:' . $body);
                return;
            }
            $mailer = new Mailer();
            $mailer->sendMail($u->email, $title, self::CreateEmailMsg($body));
        }
    }

    public static function CreateEmailMsg($text) {
        global $persiandate, $_CONFIGS;
        $msg = '<div style="max-width: 500px;">
	<table style="max-width: 500px; background-color: rgb(51, 153, 255); margin: 30px auto; direction: rtl; text-align: center;">
		<tbody>
			<tr>
				<td style="padding:0px;">
					<div style="background-color: rgb(34, 119, 255); padding: 5px; margin: 15px 25px 0px; border: 1px solid rgb(242, 242, 242); text-align: center;">
						<a href="' . $_CONFIGS['Site']['Path'] . '" style="text-decoration: none;"><span style="color:#ffffff;"><span style="font-family: tahoma,geneva,sans-serif;">' . $_CONFIGS['Site']['NickName'] . '</span></span></a></div>
				</td>
			</tr>
			<tr>
				<td style="padding:0px;">
					<div style="background-color:#fff;border:1px solid #27f;margin:25px 25px 10px 25px;padding:25px;font:12px/25px tahoma;text-align:justify;">
						<p style="text-align: center;">
							بسمه تعالی</p>
						<br/><br/>
                                                <p>
							سلام
                                                </p><br/>
						<p>
							' . $text . '</p>
						<p>
							<br />
							با تشکر<br />
							مدیریت سایت
                                                        <br/>
							<a href="' . $_CONFIGS['Site']['Path'] . '" style="text-decoration: none;"><span style="color:#000000;">' . $_CONFIGS['Site']['NickPath'] . '</span></a></p>
						<hr />
						<ul>
							<li>
								این نامه به صورت اتوماتیک ارسال شده است، از جواب دادن به آن بپرهیزید.</li>
							<li>
								در صورتی که این ایمیل موجب آزار شما شده است، به حساب کاربری خود مراجعه کرده و در قسمت تنظیمات کاربر، گزینه &laquo;ارسال پیام از طریق ایمیل&raquo; را غیر فعال نمایید.</li>
							<li>
								نظرات، انتقادات و پیشنهادات خود را از طریق ایمیل &quot;' . $_CONFIGS['Site']['Sub']['Email'] . '&quot; ارسال نمایید.</li>
						</ul>
					</div>
				</td>
			</tr>
			<tr>
				<td style="padding:0px;">
					<div style="background-color:#2277ff;margin:5px 25px 20px 25px;border:1px solid #f2f2f2;padding:5px;font-family:tahoma,geneva,sans-serif;">
						<a href="' . $_CONFIGS['Pathes']['Blog'] . '" style="text-decoration: none;"><span style="color:#ffffff;">ارتباط با ما</span></a><span style="color:#ffffff;"> |</span><span style="color:#ffffff;"> </span><a href="' . $_CONFIGS['Site']['Sub']['Path'] . '" style="text-decoration: none;"><span style="color:#ffffff;">ورود به سایت</span></a><span style="color:#ffffff;"> | </span><a href="mailto:' . $_CONFIGS['Site']['Sub']['Email'] . '?subject=invite" style="text-decoration: none;"><span style="color:#ffffff;">ارتباط با مدیر</span></a></div>
					<div style="background-color:#2277ff;margin:5px 25px 20px 25px;border:1px solid #f2f2f2;padding:5px;font-family:tahoma,geneva,sans-serif;color:#FFF;text-align:left;">
                                                 تاریخ: 
                                           ' . $persiandate->date('d F Y ساعت H:i:s') . '
                                        </div>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<p>
	&nbsp;</p>

';

        return '<html><body><center>' . $msg . '</center></body></html>';
    }

}

?>

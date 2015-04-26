<?php

/* @var $database Database */
/* @var $cdatabase Database */
/* @var $user User */
/* @var $event Event */
/* @var $message Message */
/* @var $persiandate PersianDate */
/* @var $project Project */

class BaseProject {

    private $_info = array();
    public static $S_CLOSE = 'Close';
    public static $S_RUN = 'Run';
    public static $S_FINISH = 'Finish';
    public static $S_OPEN = 'Open';
    public static $T_AGENCY = 'Agency';
    public static $T_PUBLIC = 'Public';
    public static $T_PRIVATE = 'Private';

//    Private|Public|Protected|Agency|Referer

    public function __construct($id = NULL) {
        $this->_info['id'] = $id;
    }

    public function __get($name) {
        switch ($name) {
            case 'E_state':
            case 'E_user_id':
            case 'E_share':
            case 'E_online':
            case 'id':
                return $this->_info[$name];
//            case 'group_id':
//                return 1;
            default :
                if ($this->_info['id']) {
                    if (!isset($this->_info['title']))
                        $this->_setProjectInfo();
                    if (isset($this->_info[$name]))
                        return $this->_info[$name];
                }
        }
        return NULL;
    }

    public function getCode($id = NULL) {
        global $subSite, $_CONFIGS;
        if ($id)
            return $_CONFIGS["Site"][$subSite]['code'] . $id;
        if ($this->id)
            return $_CONFIGS["Site"][$subSite]['code'] . $this->id;
        return "";
    }

    private function _setProjectInfo() {
        global $database;
        $this->_info = $database->fetchAssoc($database->select('projects', '*', $database->whereId($this->id)));

        if ($this->_info['state'] == 'Close') {//nc?
            $this->_info['verified'] = -1;
        }
    }

    public function getOfGui() {
        global $discount;
//        'file_name' => $file_name,
        $p['title'] = $_REQUEST['t'];
        $p['lang'] = $_REQUEST['lan'];
        $p['guess_page_num'] = ($_REQUEST['gpn']);
        $p['description'] = $_REQUEST['desc'];
//        $p['expire_date'] = $_REQUEST['d1'];
//        $p['expire_time'] = $_REQUEST['d2'];
        $p['expire_interval_day'] = $_REQUEST['di1'];
        $p['expire_interval_hour'] = $_REQUEST['di2'];
        $p['expire_interval'] = ($_REQUEST['di1'] * 24 + $_REQUEST['di2']) * 60 * 60;
        $p['output'] = $_REQUEST['out'];
        $p['type'] = $_REQUEST['pt'];
        $p['selection_method'] = $_REQUEST['selectkarfarma'];
        $p['max_price'] = $_REQUEST['mp'];
        $p['min_rate'] = $_REQUEST['mr'];
        $p['private_typist_id'] = (isset($_REQUEST['private_typist_id']) && $_REQUEST['private_typist_id'] > 0) ? $_REQUEST['private_typist_id'] : '';
//        $p['private_typist_id'] = (isset($_REQUEST['private_typist_id']) && $_REQUEST['private_typist_id'] > 0) ? $_REQUEST['private_typist_id'] : $discount->getReferer();

        $p['discount_code'] = $_REQUEST['discount'];
        $p['earnest'] = $_REQUEST['earnest'];
        return $p;
    }

    public function submit() {
        global $_PRICES, $auth, $discount, $database, $files, $user, $message, $event, $persiandate;
        // Upload Image
        // t lan gpn desc d1 d2 out pt selectkarfarma mp mr private_typist_id discount earnest 

        $title = $_POST['t'];
        $lang = $_POST['lan'];
        $guess_page_num = ((int) $_POST['gpn']);
        $description = $_POST['desc'];
        $fileName = $_POST['fn'];
//        $expire_date = $_POST['d1'];
//        $expire_time = $_POST['d2'];
        $expire_interval_day = $_POST['di1'];
        $expire_interval_hour = $_POST['di2'];
        $out_format = $_POST['out'];
        $type = $_POST['pt'];
        $selectkarfarma = $_POST['selectkarfarma'];
        $max_price = $_POST['mp'];
        $min_rate = $_POST['mr'];
        $private_typist_id0 = $_POST['private_typist_id'];
        $discountCode = $_POST['discount'];
        $earnest = $_POST['earnest'];
        $editMode = ($_REQUEST['formName'] == 'EditProjectForm');
        ////////////////////////////////////
        $lang = strtoupper($lang);
        if (!isset($_PRICES['worker'][$lang])) {
            $message->addError('زبان تایپ خود را مشخص کنید');
            return false;
        }

        /////////////////////////////////move file to the end
//        $file_name = '';
//        if (isset($_FILES['fl']['name']) && $_FILES['fl']['name'] != '') {
//            $file_name = $files->generateUniqueFileName('zip');
//            if (!$files->upload('fl', $file_name, 'uploads/', 1024 * 1024 * 20, 'zip')) {
//                $message->addError('فایل مورد نظر معتبر نمی باشد.');
//                return false;
//            }
//        }
//        $datefild = explode("/", $expire_date);
//        $datefild_stamp = $persiandate->persianToTimestamp($datefild[0], $datefild[1], $datefild[2]);
//        $expire_date_time = $datefild_stamp + $expire_time * 60 * 60;
        $expire_interval = ($expire_interval_day * (24 * 60 * 60)) + ($expire_interval_hour * (60 * 60));

//        $dd = ($datefild_stamp - (time())) / (24 * 60 * 60);
//        $dd = $dd < 1 ? 1 : round($dd);

        if (!$auth->fildValid(strtolower($out_format), 'docx|online|doc|pptx|xlsx')) {
            $message->addError('فرمت فایل تحویلی را مشخص نمایید');
            return false;
        }
        $out_format = strtoupper($out_format);

        if (!$auth->fildValid($type, 'Private|Public|Protected|Agency|Referer')) {
            $message->addError('نوع پروژه را مشخص کنید');
            return false;
        }
        $type = ucfirst($type);


        $sum = 0;
        $private_typist_id = "";
        switch ($type) {
            case "Referer":
                if (!$private_typist_id0) {
                    $message->addError('تایپیست را مشخص نمایید');
                    return false;
                }
                $sum = $max_price;
                $private_typist_id = $private_typist_id0;
                break;
            case "Private":
                if (!$private_typist_id0) {
                    $message->addError('تایپیست را مشخص نمایید');
                    return false;
                }
                $sum = $max_price;
                $private_typist_id = $private_typist_id0;
                break;
            case "Protected":
                $sum = $guess_page_num * $_PRICES['user'][$lang]; //nc?  if rate is biger 2
                break;
            case "Public":
                $selectkarfarma = strtolower($selectkarfarma);
                if (!$auth->fildValid($selectkarfarma, 'li|fm|fim|mr')) {
                    $message->addError('روش انتخاب کارفرما را مشخص کنید');
                    return false;
                }
                $max_price = (int) $max_price;
                if (!$max_price) {
                    $message->addError('حدود قیمت پروژه ی خود را مشخص نمایید');
                    return false;
                }

                if ($selectkarfarma == 'mr') {
                    $min_rate = (int) $min_rate;
                    if (!$min_rate) {
                        $message->addError('حداقل رتبه ی مجری را مشخص کنید');
                        return false;
                    }
                }
                $sum = $max_price;
                break;
            case "Agency":
                if (!$user->isAgency()) {
                    $message->addError('نوع پروژه را مشخص کنید');
                    return false;
                }
                $sum = $guess_page_num * $_PRICES['agency'][$lang];
                break;
        }

        $discountCode = strtoupper($discountCode);
        $dis = new Discount($discountCode, ($user->id));
        if ($dis->isValid()) {
            $discountCode = ""; //nc?
        } else {
            $discountCode = "";
        }

        $max_price = $sum;
        $earnest = (int) $earnest;
        $sum = $sum * (1 - $dis->p) - ($dis->e);
        $sum = roundPrice($sum);
        $earnest0 = roundPrice($sum * $_PRICES['P_USER']);

        if ($earnest && $earnest != 0) {
            if ($earnest >= $earnest0) {
                $earnest0 = $earnest;
            } else {
                
            }
        }

        if ($type == "Agency") {
            $earnest0 = 0;
            $lock_price = $max_price;
        } elseif ($type == "Public" && $selectkarfarma == 'li') {
            $earnest0 = 0;
            $lock_price = $sum;
        } else {
            $lock_price = $earnest0;
        }




        $earnest = $earnest0;

        if (!$files->fileValid($fileName, 'x-zip|x-office|x-pic')) {
            return false;
        }

        $can_cancel = $out_format == 'ONLINE' ? 0 : 1;
//        $file_name = '';
//        if (isset($_FILES['fl']['name']) && $_FILES['fl']['name'] != '') {
//            $file_name = $files->generateUniqueFileName('zip');
//            if (!$files->upload('fl', $file_name, 'uploads/', 1024 * 1024 * 20, 'zip')) {
//                $message->addError('فایل مورد نظر معتبر نمی باشد.');
//                return false;
//            }
//        }
        //////////////////////

        if ($editMode) {
            ////////// EDIT ////////////////////////////////////
            $pid = (int) $_POST['pid'];
            $p = new Project($pid);
            if (($p->user_id != $user->id || $p->typist_id) && !$user->isAdmin())
                return;

            $database->update('projects', array(
//                'user_id' => (int) $user->id,
//                'state' => 'Open',
                'submit_date' => time(),
                'title' => $title,
                'lang' => $lang,
                'guess_page_num' => $guess_page_num,
                'description' => $description,
                'file_name' => $fileName,
//            'expire_time' => $expire_date_time,
                'expire_interval' => $expire_interval,
                'output' => $out_format,
                'type' => $type,
                'selection_method' => $selectkarfarma,
                'max_price' => $max_price,
//                'lock_price' => $lock_price,
                'min_rate' => $min_rate,
                'private_typist_id' => $private_typist_id,
                'discount_code' => $discountCode,
                'earnest' => (int) $earnest,
                'can_cancel' => $can_cancel,
                'verified' => ($user->isAgency()) ? 1 : Event::$V_AUTO_ACC,
                    ), "WHERE id = " . $pid);
////            $database->update('projects', array(
////                'verified' => Event::$V_DELETE,
////                    ), "WHERE id = " . $pid);
//            $prj = new Project($pid);
//            $prj->delete();
//
//            $database->insert('projects', array(
//                'user_id' => (int) $user->id,
//                'state' => 'Open',
//                'submit_date' => time(),
//                'title' => $title,
//                'lang' => $lang,
//                'guess_page_num' => $guess_page_num,
//                'description' => $description,
//                'file_name' => $fileName,
////            'expire_time' => $expire_date_time,
//                'expire_interval' => $expire_interval,
//                'output' => $out_format,
//                'type' => $type,
//                'selection_method' => $selectkarfarma,
//                'max_price' => $max_price,
//                'lock_price' => $lock_price,
//                'min_rate' => $min_rate,
//                'private_typist_id' => $private_typist_id,
//                'discount_code' => $discount,
//                'earnest' => (int) $earnest,
//                'can_cancel' => $can_cancel,
//                'verified' => ($user->isAgency()) ? 1 : Event::$V_AUTO_ACC,
//            ));
        } else {
            $database->insert('projects', array(
                'user_id' => (int) $user->id,
                'state' => 'Open',
                'submit_date' => time(),
                'title' => $title,
                'lang' => $lang,
                'guess_page_num' => $guess_page_num,
                'description' => $description,
                'file_name' => $fileName,
//            'expire_time' => $expire_date_time,
                'expire_interval' => $expire_interval,
                'output' => $out_format,
                'type' => $type,
                'selection_method' => $selectkarfarma,
                'max_price' => $max_price,
                'lock_price' => $lock_price,
                'min_rate' => $min_rate,
                'private_typist_id' => $private_typist_id,
                'discount_code' => $discountCode,
                'earnest' => (int) $earnest,
                'can_cancel' => $can_cancel,
                'verified' => ($user->isAgency()) ? 1 : Event::$V_AUTO_ACC,
            ));
            $pid = $database->getInsertedId();
        }
        if ($editMode) {
            $event->call($user->id, Event::$T_PROJECT, Event::$A_EDIT
                    , array(
                'prjtitle' => $title,
                'prjid' => $pid,
            ));
        } else {
            $event->call($user->id, Event::$T_PROJECT, Event::$A_SUBMIT
                    , array(
                'prjtitle' => $title,
                'prjid' => $pid,
            ));
        }
        // nc? send sms for private and protected project
        if ($type == "Private") {
            $event->call($private_typist_id, Event::$T_PROJECT, Event::$A_PRIVATE
                    , array(
                'prjtitle' => $title,
                'prjid' => $pid,
            ));
        }

//        if ($type == "Referer") {
        $refer = $user->getDiscountReferer();
        if ($refer && $refer > 0) {
            $event->call($refer, Event::$T_PROJECT, Event::$A_REFERER
                    , array(
                'prjtitle' => $title,
                'prjid' => $pid,
            ));
        }
//        $discount->deleteReferer();
        return $pid;
    }

//    public function edit() {
//        return $this->submit();
//    }

    public function delete() {
        global $user;
        if ($user->id == $this->user_id || $user->isAdmin()) {
            if (!$this->typist_id) {
                $b = $this->setVerifiedAndSendEvent(Event::$V_DELETE);
                $this->_setProjectInfo();
                User::subLockCredits($this);
                User::addCountRejectedPrj($user->id);
                return $b;
            }
        }
        return FALSE;
    }

    ///////

    public function isExists($id = NULL) {
        global $database;
        if (!is_numeric($id))
            return FALSE;

        if (!$database->isRowExists('projects', 'id', $database->whereId($id)))
            return FALSE;

        return TRUE;
    }

    public function getProject($id) {
        global $database;
        return $database->fetchAssoc($database->select('projects', '*', $database->whereId($id)));
    }

    public function getTitle($id) {
        global $database;
        return $database->selectField('projects', 'title', $database->whereId($id));
    }

    ////////////

    public function canCancelBid() {
        return $this->can_cancel == 1 && (($this->stakeholder_date + 2 * 60 * 60 ) > time() || ($this->type != "Agency" && $this->stakeholdered == 0));
//        return $this->can_cancel == 1;
    }

    public function getAcceptedBid() {
        global $database;
        $id = $database->selectField('bids', 'id', $database->whereId($this->id, "project_id") . " AND accepted ='" . Event::$V_ACC . "'");
        return new Bid($id);
    }

    public function cancelBid() {
        global $event, $database, $message, $user;
        if (($this->typist_id == $user->id && $this->can_cancel == 1) || $user->isAdmin()) {
            if (($this->stakeholder_date + 2 * 60 * 60 ) > time() || $user->isAdmin()) {
                User::subLockCredits($this);
                User::subCountRunningPrj($this);
                $database->update('projects', array(
                    'typist_id' => 0,
                    'state' => 'Open',
                    'accepted_price' => 0
                        ), $database->whereId($this->id));

                $res = $database->update('bids'
                        , array('accepted' => Event::$V_NONE)
                        , $database->whereId($this->id, 'project_id'));

                $res = $database->update('bids'
                        , array(
                    'accepted' => Event::$V_CANCEL,
                    'message' => 'انصراف توسط کاربر',
                    'price' => 0,
                        )
                        , $database->whereId($this->typist_id, 'user_id')
                        . " AND project_id = " . (int) $this->id);

//                User::addCountRejectedPrj($this->typist_id);

                $event->call($this->typist_id, Event::$T_BID, Event::$A_CANCEL
                        , array(
                    'prjtitle' => $this->title,
                    'prjid' => $this->id,
                ));
                $event->call($this->user_id, Event::$T_PROJECT, Event::$A_CANCEL
                        , array(
                    'prjtitle' => $this->title,
                    'prjid' => $this->id,
                ));
                $this->_setProjectInfo();
            } else {
                $message->addError('فرصت انصراف از انجام پروژه به پایان رسیده است');
                $message->addError('شما نمی توانید از انجام دادن این پروژه انصراف دهید');
                return FALSE;
            }
        } else {
            $message->addError('شما نمی توانید از انجام دادن این پروژه انصراف دهید');
            return FALSE;
        }

        return TRUE;
    }

    public function checkAutoAcceptBid($bid_id) {
        global $user, $database;
        $bid = $database->fetchAssoc($database->select('bids', '*', $database->whereId($bid_id)));
        if ($this->type == 'Public') {
            if ($bid['price'] <= $this->max_price) {
                switch ($this->selection_method) {
                    case 'mr': // min rate
                        $rankers = ($rankers == 0 ? 1 : $rankers);
                        if ($this->min_rate <= ($rank / $rankers)) {
                            $this->acceptBidAndSetStakeholder($bid);
                        }
                        break;
                    case 'fim':// first spisial mojri
//                        if($user[]){ // if user is spisial
//                            $this->acceptBid( $bid);
//                        }
                        break;
                    case 'fm':// first  mojri
//                        $this->acceptBidAndSetStakeholder($bid);
                        break;
                }
            }
        }
    }

    public function acceptBidAndSetStakeholder($bid) {
        if ($this->acceptBid($bid)) {
            return $this->setStakeholder();
        }
        return FALSE;
    }

    private function acceptBid($bid) {
        global $database, $event, $user;
        if ($bid['project_id'] != $this->id) {
            return FALSE;
        }

        if ($bid['accepted'] != Event::$V_NONE) {
            return FALSE;
        }

        if ($this->typist_id)
            return FALSE;

        $database->update('bids', array('accepted' => Event::$V_REJECT), $database->whereId($this->id, 'project_id') . ' AND accepted=0');
        $database->update('bids', array('accepted' => Event::$V_ACC), $database->whereId($bid['id']));

        if ($bid['type'] == Bid::$TYPE_PERPAGE ||
                $bid['type'] == Bid::$TYPE_PERWORD ||
                $bid['type'] == Bid::$TYPE_PERMIN) {
            $bid_price = $bid['price'] * $this->guess_page_num;
        } elseif ($bid['type'] == Bid::$TYPE_FULL) {
            $bid_price = $bid['price'];
        }

        $accepted_price = ($this->type == 'Agency') ? 0 : $bid_price;
        $lock_price = ($this->type == 'Agency') ? $this->lock_price : $bid_price;
        //only for monagese
        $earnest = ( $this->selection_method == 'li') ? $accepted_price : $this->earnest;

        $database->update('projects', array(
            'typist_id' => intval($bid['user_id']),
            'state' => 'Run',
            'earnest' => $earnest,
            'lock_price' => $lock_price,
            'stakeholder_date' => time(), // update needed for worker can cancel after 2 hour
            'expire_time' => time() + $this->expire_interval,
            'accepted_price' => $accepted_price
                ), $database->whereId($bid['project_id']));

        $this->_setProjectInfo(); //update info
        User::addCountRunningPrj($this);

        $event->call($bid['user_id'], Event::$T_BID, Event::$A_ACC
                , array(
            'prjtitle' => $this->title,
            'prjid' => $this->id,
                ), TRUE);
//        $event->call($this->user_id, Event::$T_PROJECT, Event::$A_P_RUN
//                , array(
//            'prjtitle' => $this->title,
//            'prjid' => $this->id,
//        ));
        // -1 is system auto
        return TRUE;
    }

    public function setStakeholder() {
        global $database, $event;

        if ($this->stakeholdered == 1)
            return TRUE;

        $earnest = $this->getAcceptedBid()->earnest;
        if ($this->type != 'Agency') {
            $user = new User($this->user_id);
            if ($user->getCredit() < $earnest) {
                $event->call($this->user_id, Event::$T_PROJECT, Event::$A_NEED_STAKEHOLDER
                        , array(
                    'prjtitle' => $this->title,
                    'prjid' => $this->id,
                ));
                return FALSE;
            }
        }
        $database->update('projects', array(
            'stakeholdered' => 1,
            'stakeholder_date' => time(),
            'expire_time' => time() + $this->expire_interval,
            'earnest' => $earnest
                ), $database->whereId($this->id));

        $this->_setProjectInfo();
        User::addLockCredits($this);

        $event->call($this->typist_id, Event::$T_PROJECT, Event::$A_P_RUN
                , array(
            'prjtitle' => $this->title,
            'prjid' => $this->id,
                ), TRUE);
        $event->call($this->user_id, Event::$T_PROJECT, Event::$A_P_RUN
                , array(
            'prjtitle' => $this->title,
            'prjid' => $this->id,
        ));

        return TRUE;
    }

    public function getBidsCount($id = NULL) {
        global $database;
        if ($id === NULL)
            $id = $this->id;
        return $database->selectCount('bids', $database->whereId($id, "project_id") . 'AND accepted<>-2');
    }

    //////////

    public function submitFinalFile() {
        global $database, $files, $user, $message, $event, $subSite;
        $p = $this->getProject((int) $_POST['pid']);
        // Upload File
        if ($this->output == 'ONLINE') {
            $file_name = 'ONLINE';
        } else {
            $file_name = '';
        }

        if (isset($_FILES['fl']['name']) && $_FILES['fl']['name'] != '') {
            $file_name = $files->generateUniqueFileName($files->extension($_FILES['fl']['name']));
            if (!$files->upload('fl', $file_name, 'uploads/' . $subSite . '/final/', 1024 * 1024 * 20, 'x-office')) {
                $message->addError('فایل مورد نظر معتبر نمی باشد.');
                return false;
            }
        }

        if ($file_name == '') {
            $message->addError('فایل مورد نظر معتبر نمی باشد.');
            return false;
        }
        //$pages = $this->getDOCXPagesNum('uploads/'.$file_name);
        $pages = 0;
        if (isset($_POST['pp']) && is_numeric($_POST['pp'])) {
            $pages = (int) $_POST['pp'];
        } else {
            $message->addError('تعداد صفحات فایل نهایی صحیح نمی باشد.');
            return false;
        }
        $database->insert('final_files', array(
            'user_id' => (int) $user->id,
            'project_id' => (int) $_POST['pid'],
            'dateline' => time(),
            'message' => $_POST['m'],
            'final_file' => $file_name,
            'pages' => $pages,
            'can_download' => (($p['state'] == 'Finish') ? 1 : 0)
        ));
        $event->call($user->id, Event::$T_PROJECT, Event::$A_P_FINAL_FILE_SUBMIT
                , array(
            'prjtitle' => $p['title'],
            'prjid' => $p['id'],
        ));
        $event->call($p['user_id'], Event::$T_PROJECT, Event::$A_P_FINAL_FILE_RECEIVE
                , array(
            'prjtitle' => $p['title'],
            'prjid' => $p['id'],
        ));
        return true;
    }

    public function submitGroupFile($msg) {
        global $database, $files, $user, $message, $event, $subSite;

        if (isset($_FILES['fl']['name']) && $_FILES['fl']['name'] != '') {
            $file_name = $files->generateUniqueFileName($files->extension($_FILES['fl']['name']));
            if (!$files->upload('fl', $file_name, 'uploads/' . $subSite . '/group_file/', 1024 * 1024 * 20, 'x-office|x-zip')) {
                $message->addError('فایل مورد نظر معتبر نمی باشد.');
                return false;
            }
        }

        if ($file_name == '') {
            $message->addError('فایل مورد نظر معتبر نمی باشد.');
            return false;
        }

        return $database->insert('group_files', array(
                    'user_id' => (int) $user->id,
                    'project_id' => (int) $this->id,
                    'dateline' => time(),
                    'message' => $msg,
                    'file' => $file_name
                ));
    }

    public function spelitCreditGroup($form_prefix) {
        global $user, $message, $creditlog, $database, $event;
        if ($this->group_split_info) {
            $message->addError("تقسیم دستمزد انجام شده است");
            return FALSE;
        }

        if ($user->id == $this->typist_id) {
            $mems = $this->getSharedUsers();
            $sumGroupCredit = 0;
            $a = array();
            foreach ($mems as $mem) {
                $c = 0;
                if (isset($_POST[$form_prefix . $mem['user_id']])) {
                    $c = intval($_POST[$form_prefix . $mem['user_id']]);
                }
                if ($c < 0) {
                    $message->addError("در هنگام تقسیم مبالغ دقت نمایید");
                    return FALSE;
                }
                if ($c != 0) {
                    $sumGroupCredit += $c;
                    $a[$mem['user_id']] = $c;
                }
            }
            if ($sumGroupCredit != $this->getWorkerPrice()) {
                $message->addError("در هنگام تقسیم مبالغ دقت نمایید");
                return FALSE;
            }

            $userNickname = $user->getNickname($uid);
            $changed = FALSE;
            foreach ($a as $uid => $price) {
                if ($uid != $this->typist_id) {
                    $creditlog->sub($this->typist_id, $price, "groups", $this->id, $uid);
                    $creditlog->add($uid, $price, "groups", $this->id, $this->typist_id);
                    $event->call($uid, Event::$T_GROUP, Event::$A_G_SPLIT_PRICE, array(
                        'price' => $price,
                        'prjtitle' => $this->title,
                        'unickname' => $userNickname
                    ));
                    $changed = TRUE;
                }
            }

            if ($changed) {
                $database->update('projects', array(
                    'group_split_info' => json_encode($a),
                        ), $database->whereId($this->id));
                $this->_info['group_split_info'] = json_encode($a);
            } else {
                $message->addError("انتقال اعتبار انجام نشد. در وارد کردن مبالغ دقت نمایید");
                return FALSE;
            }

            return TRUE;
        } else {
            $message->addError("امکان تقسیم دستمزد وجود ندارد");
        }
        return FALSE;
    }

    public function submitTypeOnlineFinalFile() {
        global $database, $files, $user, $message, $event;
        $p = $this->getProject((int) $_POST['pid']);
        //$pages = $this->getDOCXPagesNum('uploads/'.$file_name);
        $pages = 0;
        if (isset($_POST['pp']) && is_numeric($_POST['pp'])) {
            $pages = (int) $_POST['pp'];
        } else {
            $message->addError('تعداد صفحات فایل نهایی صحیح نمی باشد.');
            return false;
        }
        $database->insert('final_files', array(
            'user_id' => (int) $user->id,
            'project_id' => (int) $_POST['pid'],
            'dateline' => time(),
            'message' => $_POST['m'],
            'final_file' => 'online',
            'pages' => $pages,
            'can_download' => (($p['state'] == 'Finish') ? 1 : 0)
        ));
        $event->call($user->id, Event::$T_PROJECT, Event::$A_P_FINAL_FILE_SUBMIT
                , array(
            'prjtitle' => $p['title'],
            'prjid' => $p['id'],
        ));
        $event->call($p['user_id'], Event::$T_PROJECT, Event::$A_P_FINAL_FILE_RECEIVE
                , array(
            'prjtitle' => $p['title'],
            'prjid' => $p['id'],
        ));
        return true;
    }

    public function getProjectFileLinks() {
        global $subSite;
        $a = array();
        if (strpos($this->file_name, ']')) {
            $b = json_decode($this->file_name, TRUE);
            foreach ($b as $value) {
                if (substr($value, 0, 4) == "http") {
                    $a[] = $value;
                } else {
                    $a[] = 'uploads/' . $subSite . '/project/' . $value;
                }
            }
        } else {
            if (substr($this->file_name, 0, 4) == "http") {
                $a[] = $this->file_name;
            } else {
                $a[] = 'uploads/' . $subSite . '/project/' . $this->file_name;
            }
        }

        return $a;
    }

    public function getFinalFile() {
        global $database;
        return $database->fetchAll($database->select('final_files', '*', $database->whereId($this->id, "project_id")));
    }

    public function getGroupFile() {
        global $database;
        return $database->fetchAll($database->select('group_files', '*', $database->whereId($this->id, "project_id")));
    }

    public function getFinalPageCount($id = NULL) {
        global $database;
        $id = $id ? $id : $this->id;
        return $database->selectField('final_files', 'pages', $database->WHEREid($id, 'project_id'));
    }

    public function setFinish($elmend_price, $accepted_price) {
        global $database, $creditlog, $event, $user, $_PRICES;
        $accepted_price = intval($accepted_price);
        $elmend_price = intval($elmend_price);
        $database->update('projects', array(
            'state' => 'Finish',
            'elmend_price' => ($elmend_price),
            'accepted_price' => ($accepted_price)
                ), $database->whereId($this->id));
        $this->_setProjectInfo();
        User::subLockCredits($this);
        User::addCountFinishedPrj($this);

        $referer_price = 0;
        $referer = $user->getDiscountReferer($this->user_id);
        if ($referer && $referer > 0) {
            $referer_price = round(($accepted_price * $_PRICES['P_REFERER']) / (10)) * 10;
            $creditlog->add($referer, $referer_price
                    , 'refers', $this->id, "بابت دعوت از کاربر" + " " + $user->getNickname($this->user_id));
        }

        $creditlog->sub($this->user_id, $accepted_price
                , 'projects', $this->id, "");
        $creditlog->add($this->typist_id, $accepted_price - $elmend_price
                , 'projects', $this->id, "");

        if ($elmend_price - $referer_price != 0) {
            $creditlog->add(User::$ELMEND, $elmend_price - $referer_price
                    , 'projects', $this->id, "");
        }



        $database->update('final_files', array(
            'can_download' => 1
                ), $database->whereId($this->id, 'project_id'));

        $event->call($this->typist_id, Event::$T_PROJECT, Event::$A_P_PAY_FEE
                , array(
            'prjtitle' => $this->title,
            'prjid' => $this->id,
            'price' => $accepted_price - $elmend_price,
        ));
    }

    public function setGroup($group_id, $prefix_check, $prefix_text) {
        global $database, $user, $event;

        $res = FALSE;
        if ($user->containGroup($group_id)) {
            $res = $database->update('projects', array(
                'group_id' => $group_id,
                    ), $database->whereId($this->id));
            $this->_info['group_id'] = $group_id;
            $res = TRUE;
        }

        if ($res) {
            $group = new Group($group_id);
            $mems = $group->getMembers();
            foreach ($mems as $mem) {
                if (isset($_POST[$prefix_check . '_' . $mem['user_id']])) {
                    $msg = $_POST[$prefix_text . '_' . $mem['user_id']];
                    $event->call($mem['user_id'], Event::$T_GROUP, Event::$A_G_INVITE_PROJECT, array(
                        'pid' => $this->id,
                        'title' => $this->title,
                        'msg' => $msg
                    ));
                }
            }
        }

        return $res;
    }

    public function addShare($user_id, $msg) {
        global $database, $user, $event;

        if ($user->id != $this->typist_id && !$user->isAdmin())
            return FALSE;

        $sh_u = $this->getSharedUsers();

        foreach ($sh_u as $u) {
            if ($u->id == $user_id)
                return FALSE;
        }

        $b = $database->insert('share_projects', array(
            'user_id' => intval($user_id),
            'prj_id' => intval($this->id)
                ));
        $this->_setProjectInfo();

        $event->call($user_id, Event::$T_GROUP, Event::$A_G_INVITE_PROJECT, array(
            'pid' => $this->id,
            'sender' => $user->getNickname(),
            'title' => $this->title,
            'msg' => $msg
        ));

        return $b;
    }

    /**
     * 
     * @return  User Array
     */
    public function getSharedUsers() {
        global $database;
        $us = array();

        $shs = $database->fetchAll($database->select('share_projects', '*', $database->whereId($this->id, "prj_id")));
        if ($shs) {
            foreach ($shs as $uid) {
                $us[] = $uid;
            }
        }

        $g = $this->getGroup();
        if ($g) {
            $mems = $g->getMembers();
            $us = array_merge($us, $mems);
        } else {
            $c['user_id'] = $this->typist_id;
            $us[] = $c;
        }

        return $us;
    }

    public function isSharedWorker($user_id) {
        $shus = $this->getSharedUsers();
        for ($index = 0; $index < count($shus); $index++) {
            if ($shus[$index]['user_id'] == $user_id) {
                return TRUE;
            }
        }
        return FALSE;
    }

    public function isShared() {
        $shus = $this->getSharedUsers();
        return count($shus) > 1;
    }

    /**
     * 
     * @return boolean|\Group
     */
    public function getGroup() {
        if (!$this->group_id)
            return FALSE;
        return new Group($this->group_id);
    }

    /**
     * sahm worker
     */
    public function getWorkerPrice() {
        return $this->accepted_price - $this->elmend_price;
    }

//    public function getDOCXPagesNum($filename) {
//        $zip = new ZipArchive();
//        if ($zip->open($filename) === true) {
//            if (($index = $zip->locateName('docProps/app.xml')) !== false) {
//                $data = $zip->getFromIndex($index);
//                $zip->close();
//                $xml = new SimpleXMLElement($data);
//                return $xml->Pages;
//            }
//            $zip->close();
//        }
//        return false;
//    }
    //////////

    public function getList($limit = 1, $condition = NULL) {
        global $_CONFIGS, $pager, $user;

        // only for check sql safe (non injection )
        $this->_info['E_state'] = (isset($_CONFIGS['Params'][1]) AND in_array(strtolower($_CONFIGS['Params'][1]), array('open', 'run', 'finish', 'close'))) ? ucfirst($_CONFIGS['Params'][1]) : 'All';
        $this->_info['E_user_id'] = (isset($_CONFIGS['Params'][2]) AND is_numeric($_CONFIGS['Params'][2])) ? (int) $_CONFIGS['Params'][2] : 0;
        $this->_info['E_share'] = isset($_CONFIGS['Params'][1]) && $_CONFIGS['Params'][1] == "share";

        $this->_info['E_online'] = isset($_REQUEST['typeonline']);


        if ($this->E_user_id > 0 && !$user->isAdmin())
            $this->E_user_id = $user->id;

        $where = "";
        if ($this->E_share)
            $where .= " LEFT JOIN share_projects as shp ON shp.prj_id = projects.id ";

        $where .= ' WHERE ';
        if ($this->E_user_id > 0)
            $where .= ' ( verified <> -3 ) ';
        else
            $where .= ' verified>0 ';


        if (!is_null($condition))//securety //nc? mhk 
            $where .= ' AND ' . $condition;
        if ($this->E_state != 'All')
            $where .= " AND state='{$this->E_state}'";
        if ($this->E_online) {
            $where .= " AND output='ONLINE' ";
        }

        if ($this->E_user_id > 0) {
            if ($this->E_share) {
                $u = new User($this->E_user_id);
                $gs = $u->getGroups();
                $where .= " AND ( shp.user_id = {$this->E_user_id} ";
                if ($gs) {
                    foreach ($gs as $g) {
                        $where .= " OR group_id=" . $g['id'];
                    }
                }
//                $where .= " OR (typist_id={$this->E_user_id} AND shp.user_id > 0)";
                $where .= " AND (typist_id<>{$this->E_user_id} )";
                $where .= ")";
            } else {
                $where .= " AND (typist_id={$this->E_user_id} OR user_id={$this->E_user_id} OR  private_typist_id = {$this->E_user_id} )";
            }
        } else if ($this->E_user_id > 0) {
            $where .= " AND (type='Public' OR type='Agency' OR private_typist_id = {$this->E_user_id})";
        } else {
            $where .= " AND ( type='Public' OR type='Agency' )";
        }
        if (isset($_REQUEST['state_filter'])) {
            global $database;
            $state_filter = $_REQUEST['state_filter'];
            $state_filter = $database->escapeString($state_filter);
            $where .= " AND state='$state_filter'";
        }
        return $pager->getList('projects', ' DISTINCT projects.*', $where, ' ORDER BY submit_date DESC', 'title', $limit);
    }

    public function getAbilityList() {
        global $_CONFIGS, $pager, $user;


        return $pager->getList('projects', '*', $where, ' ORDER BY submit_date DESC', 'title');
    }

    public function getListName() {

        $postFix = (($this->E_share) ? ' گروهی ' : '');
        $postFix.=(($this->E_user_id > 0) ? ' من' : '');
        $postFixY = (($this->E_user_id > 0) ? 'ی ' : '');
        switch ($this->E_state) {
            case 'Open':
                if ($this->E_online)
                    return 'لیست پروژه های تایپ آنلاین' . $postFix;
                return 'لیست پروژه های باز' . $postFix;
            case 'Close': return 'لیست پروژه های بسته شده' . $postFix;
            case 'Run': return 'لیست پروژه های درحال اجرا' . $postFixY . $postFix;
            case 'Finish': return 'لیست پروژه های تمام شده' . $postFix;
            case 'All': return 'لیست تمام پروژه ها' . $postFixY . $postFix;
        }
    }

    public function addRank($rank1, $rank2, $typist_comment, $site_comment) {
        global $database, $message;
        if ($this->ranked_typist == -1) {
            $rank = ((int) $rank1) + ((int) $rank2);

            $u = new User($this->typist_id);
            $u->addRank($rank);

            if ($this->group_id) {
                $g = new Group($this->group_id);
                $g->addRank($rank);
            }

            $database->update('projects', array(
                'ranked_typist' => $rank
                    ), $database->whereId($this->id));

            if (trim($typist_comment)) {
                global $cdatabase, $_CONFIGS;
                $cdatabase->insert('user_comment', array(
                    'user_id' => $this->user_id,
                    'worker_id' => $this->typist_id,
                    'project_id' => $this->id,
                    'subsite' => $_CONFIGS['subsite'],
                    'comment' => $typist_comment,
                    'dateline' => time()
                ));
            }

            if (trim($site_comment)) {
                global $personalmessage;
                $personalmessage->send($this->user_id, User::$SUPORT, 'poll', $site_comment, 0, $this->id, 2);
                $message->clear();
            }

            $this->_setProjectInfo();

            $message->addMessage('امتیاز شما به مجری، با موفقیت ثبت گردید.');
            return TRUE;
        } else {
            $message->addError('شما پیش از این امتیاز خود را ثبت نموده اید.');
            return FALSE;
        }
    }

    public function addReviewRequest($user_id) {
        global $database, $message, $event;
        $database->insert('review_requests', array(
            'user_id' => $user_id,
            'project_id' => $this->id,
            'body' => $_POST['b'],
            'dateline' => time(),
        ));
        $message->addMessage('درخواست شما با موفقیت ارسال گردید.');
        $event->call($user_id, Event::$T_MESSAGE, Event::$A_M_REVIEW
                , array(
            'prjtitle' => $this->title,
            'prjid' => $this->id,
        ));
    }

    ///////

    private function setVerified($verified) {
        global $database;
        $b = $database->update('projects', array(
            'verified' => (int) $verified
                ), $database->whereId($this->id));
        $this->_setProjectInfo();
        return $b;
    }

    public function setVerifiedAndSendEvent($verified) {
        global $event;
        $verified_old = $this->verified;
        $res = $this->setVerified($verified);

        if ($verified == Event::$V_ACC) {
            $event->call($this->user_id, Event::$T_PROJECT, Event::$V_ACC
                    , array(
                'prjtitle' => $this->title,
                'prjid' => $this->id,
            ));
        }
        if ($verified == Event::$V_NEED_EDIT) {
            $event->call($this->user_id, Event::$T_PROJECT, Event::$V_NEED_EDIT
                    , array(
                'prjtitle' => $this->title,
                'prjid' => $this->id,
            ));
        }
        if ($verified == Event::$V_DELETE) {
            if ($verified_old != Event::$V_NEED_EDIT) {
                $event->call($this->user_id, Event::$T_PROJECT, Event::$V_DELETE
                        , array(
                    'prjtitle' => $this->title,
                    'prjid' => $this->id,
                ));
            }
        }
        return $res;
    }

    private function setState($state) {
        global $database;
        $b = $database->update('projects', array(
            'state' => ucfirst($state)
                ), $database->whereId($this->id));
        $this->_setProjectInfo();
        return $b;
    }

    public function setStateAndSendEvent($state) {
        global $event;
        $state = ucfirst($state);
        $this->setState($state);
        if ($state == 'Close') {
            $this->setVerifiedAndSendEvent(Event::$V_DELETE);
            User::subLockCredits($this);
            User::subCountRunningPrj($this);
            User::addCountRejectedPrj($this->user_id);
            $event->call($this->user_id, Event::$T_PROJECT, Event::$A_P_CLOSE
                    , array(
                'prjtitle' => $this->title,
                'prjid' => $this->id,
            ));
        }
    }

    public function countNewReviewRequests() {
        global $database;
        return $database->selectCount('review_requests', ' WHERE readed=0 ');
    }

    /////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////
    /**
     * only check open prroject and close long opened thats
     * @global type $database
     * @global type $event
     */
    public static function checkOpenProjects($age = 4) {
        global $database, $event;
        $ti = time() - $age * 24 * 60 * 60;
        $ps = $database->fetchAll($database->select('projects', '*', "WHERE state='Open' and submit_date < '$ti'"));
        foreach ($ps as $p) {
            $prj = new Project($p['id']);
            $prj->setStateAndSendEvent(ucfirst(Event::$A_P_CLOSE));
        }
    }

    public static function deleteOldProjectFile($age = 10) {
        global $database, $subSite, $project;

        $path = "uploads/" . $subSite . "/project";
        $allFile = scandir($path);
        $keepFile = $project->getOldProjectFiles($age);

        $dd = array();
        foreach ($allFile as $file) {
            if (!isset($keepFile[$file]) && substr($file, 0, 1) == 'F') {
//                @unlink($path . "/" . $file);
                $dd[] = $file;
            }
        }
    }

}

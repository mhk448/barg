<?php

abstract class BaseBid {

    public static $TYPE_FULL = "Full";
    public static $TYPE_PERPAGE = "Perpage";
    public static $TYPE_PERWORD = "Perword";
    public static $TYPE_PERMIN = "Permin";
    private $_info = array();

//    private $_project;

    public function __construct($id = NULL) {
        $this->_info['id'] = $id;
    }

    public function __get($name) {
        switch ($name) {
            case 'id':
                return $this->_info[$name];
            default :
                if ($this->_info['id']) {
                    if (!isset($this->_info['dateline']))
                        $this->_setBidInfo();
                    if (isset($this->_info[$name]))
                        return $this->_info[$name];
                }
        }
        return NULL;
    }

    private function _setBidInfo() {
        global $database;
        $this->_info = $database->fetchAssoc($database->select('bids', '*', $database->whereId($this->id)));
        $this->_info['_project'] = new Project($this->project_id);
    }

//re
    public function setMyProjectBid($project_id, $user_id) {
        global $database;
        $id = intval($project_id);
        $user_id = intval($user_id);
        $this->_info = $database->fetchAssoc($database->select('bids', '*', "WHERE project_id = {$id} AND user_id = {$user_id}" . " AND accepted<>-1 AND accepted<>-3"));
        $this->_info['_project'] = new Project($this->project_id);
        return $this;
    }

//re
    public function getProjectBids($project, $ver = 0) {
        global $database, $user;
        return $database->fetchAll($database->select('bids', '*', $database->whereId($project->id, "project_id") . 'AND accepted<>-2 AND dateline > ' . (int) ($ver)));
    }

    public function getFullPrice() {
        if ($this->type == Bid::$TYPE_PERPAGE ||
                $bid->type == Bid::$TYPE_PERWORD ||
                $bid->type == Bid::$TYPE_PERMIN)
            return roundPrice($this->_project->guess_page_num * $this->price);
        if ($this->type == Bid::$TYPE_FULL)
            return $this->price;
        return NULL;
    }

    public abstract function checkValidate($project, $price);

//re
    public function add($project) {
        global $database, $files, $user, $message, $event, $_PRICES, $subSite;
        if ($project->state != 'Open') {
            $message->addError('پروژه مورد نظر برای ارسال پیشنهاد باز نیست.');
            return false;
        }
        if (!$user->isWorker()) {
            $message->addError('فقط مجریان  اجازه ارسال پیشنهاد دارند.');
            return false;
        }
//        if ($database->isRowExists('bids', 'user_id', "WHERE project_id = '".intval($p['id'])."' AND user_id = '".intval($user->id)."'")) {
//            $message->addError('شما پیش از این پیشنهاد خود را ارسال نموده اید.');
//            return false;
//        }
//        
        $pr = (isset($_POST['p'])) ? (int) $_POST['p'] : 0;
        $type = (isset($_POST['bt'])) ? $_POST['bt'] : self::$TYPE_PERPAGE;
//        $lock_price=$project->lock_price;
        $lock_price= roundPrice($pr*2/10);
        if ($lock_price > $user->getCredit()) {
            $message->addError('شما حداقل اعتبار مورد نیاز برای پیشنهاد به این پروژه را ندارید. &nbsp;&nbsp;'
                    . '<br/> اعتبار شما:‌ ' . $user->getCredit() . ' ریال '
                    . '<br/><a href="' . $_CONFIGS['Site']['Sub']['Blog'] . '/type-help/type-why-typist-stakeholder"' . ' target="_blank">چرا باید این میزان اعتبار را داشته باشم؟</a> &nbsp;&nbsp;&nbsp; '
                    . '<br/><a href="add-credit?need_p=' . $lock_price . '" class="active_btn popup">افزایش اعتبار</a>');

            return false;
        }
        // Upload file
        $file_name = '';
        if (isset($_FILES['fl']['name']) && $_FILES['fl']['name'] != '') {
            $file_name = $files->generateUniqueFileName('zip');
            if (!$files->upload('fl', $file_name, 'uploads/' . $subSite . '/bid/', 1024 * 1024 * 20, 'x-doc|x-pic|x-zip')) {
                $message->addError('فایل مورد نظر معتبر نمی باشد.');
                return false;
            }
        }
        

        $mode = (isset($_POST['mode'])) ? $_POST['mode'] : 'Add';
        if ($database->selectField('bids', 'id', $database->whereId($user->id, 'user_id') . " AND project_id = " . (int) $_POST['pid']))
            $mode = "Edit";

        $accepted = $this->checkValidate($project, $pr);
//        $earnest = intval($_POST['er']);
        $earnest = $pr;

        if ($mode == "Add") {
            $database->insert('bids', array(
                'user_id' => (int) $user->id,
                'project_id' => (int) $_POST['pid'],
                'dateline' => time(),
                'price' => $pr,
                'type' => $type,
                'earnest' => $earnest,
                'accepted' => $accepted,
                'message' => $_POST['m'],
                'attached_file' => $file_name,
            ));
            $bid_id = $database->getInsertedId();
        } else if ($mode == "Edit") {
            $database->update('bids', array(
                'dateline' => time(),
                'price' => $pr,
                'type' => $type,
                'message' => $_POST['m'],
                'earnest' => $earnest,
                'accepted' => $accepted,
                'attached_file' => $file_name,
                    ), $database->whereId($user->id, 'user_id')
                    . " AND project_id = " . (int) $_POST['pid']
                    . " AND accepted  < 1 "
            );
            $bid_id = $database->selectField('bids', 'id', $database->whereId($user->id, 'user_id')
                    . " AND project_id = " . (int) $_POST['pid']
                    . " AND accepted  = " . $accepted);
        }

        if (!$bid_id) {
            return FALSE;
        }

        $event->call($user->id, Event::$T_BID, Event::$A_SUBMIT
                , array(
            'prjtitle' => $project->getTitle($_POST['pid']),
            'prjid' => (int) $_POST['pid'],
                ), FALSE, FALSE);
        $event->call($project->user_id, Event::$T_BID, Event::$A_RECEIVE
                , array(
            'prjtitle' => $project->getTitle($_POST['pid']),
            'prjid' => (int) $_POST['pid'],
                ), FALSE, FALSE);

        $project->checkAutoAcceptBid($bid_id);
        return true;
    }

    public function delete($project, $user_id) {
        global $database;
        $res = $database->update('bids'
                , array(
            'accepted' => Event::$V_CANCEL,
            'message' => 'انصراف توسط کاربر',
            'price' => 0,
                )
                , $database->whereId($user_id, 'user_id')
                . " AND project_id = " . (int) $project->id
                . " AND accepted  = 0 ");
        return $res;
    }

//re
    public function displayBid($msg = NULL) {
        global $user, $persiandate, $_ENUM2FA;
        $p = $this->_project;
        $u = new User($this->user_id);
        if ($user->id != $this->user_id && $user->id != $p->user_id && !$user->isAdmin()) {
            Report::addLog("show bid with no permition");
            return;
        }



        $div = ' <div id="bid_' . $this->id . '" class="live_project_bid_div" >';

        $div.= '<div>';

        $div.= '<div style="float:right;background-color: #f5f5f5;min-height:150px; width: 20%;border: 1px dotted #000;padding: 10px;margin: 5px;">'
                . '<p style=" padding-bottom: 1px;font-size:12pt;">عملیات پیشنهاد</p>'
                .
                '<div style="text-align: center">' .
                '<div  class="' . ($this->accepted >= 0 ? 'bg-theme' : 'bg-red') . '">
                        ' . $_ENUM2FA['verified'][$this->accepted] . '
                        </div>'
                . '<p style="text-align: center;width: 100%">'
                . $persiandate->displayDate($this->dateline)
                . '</p>
		 </div>';


        if ($this->user_id == $user->id || $user->isAdmin()) {
            $div .= '<p style="padding: 10px">'
                    . '<span class="tooltip3" title="ویرایش پیشنهاد"><a href="project_' . $p->id . '?showBidForm=1" ><img style="margin:5px;" src="medias/images/icons/acceptbid.png" align="absmiddle" /></a></span>'
//                    . '<span class="tooltip3" title="حذف کردن پیشنهاد"><a onclick="" ><img style="margin:5px;" src="medias/images/icons/hidebid.png" align="absmiddle" /></a></span>'
//                    . '<span class="tooltip3" title="ارسال پیام متنی"><a onclick="mhkform.ajax(\'send-message_' . $p->user_id . '_' . $p->id . '?ajax=1\')" ><img style="margin-right:10px;" src="medias/images/icons/sendmessage.png" align="absmiddle" /></a></span>'
                    . '</p>';
        }

        if ((!$msg && $this->user_id != $user->id ) || $user->isAdmin()) {
            $div .= '<p style="padding: 10px">'
                    . ((($p->typist_id || $this->accepted == Event::$V_CANCEL || $user->id != $p->user_id ) && !$user->isAdmin()) ? '' : ('<span class="tooltip3" title="قبول پیشنهاد"><a onclick="mhkform.ajax(\'accept-bid_' . $this->id . '?ajax=1\')"><img style="margin:5px;" src="medias/images/icons/acceptbid.png" align="absmiddle" /></a></span>' ))
//                    . '<span class="tooltip3" title="حذف کردن پیشنهاد"><a onclick="" ><img style="margin:5px;" src="medias/images/icons/hidebid.png" align="absmiddle" /></a></span>'
                    . '<span class="tooltip3" title="ارسال پیام متنی"><a onclick="mhkform.ajax(\'send-message_' . $u->id . '_' . $p->id . '?ajax=1\')" ><img style="margin:5px;" src="medias/images/icons/sendmessage.png" align="absmiddle" /></a></span>'
                    . '</p>';
        }
        if ($msg || $user->isAdmin()) {
            $div.=$msg;
        }
        $div.='</div>';
        $div.='</div>';

        $div .= '<div style="display:inline-block;width: 70%;float:right; background-color: #f5f5f5; min-height:150px; border: 1px dotted #000;padding: 10px;margin: 5px; ">'
                . '<span style="float: right; margin-top: 12px;">' . $u->displayAvator(TRUE) . '</span>'
                . '<p style="padding: 5px">
                        <a href="user_' . $u->id . '" style="color: green; font-size: 12pt; margin-top:5px; margin-right:10px; float: right;" class="popup" target="_blank">
                        '
                . $u->getNickname()
                . '</a> <span style=" text-align:right; float:right; padding: 5px 10px;">'
//                . '('
//                . $u->city
//                . ')'
                . '</span></p>'
                . ($p->type == "Agency" ? "" : '
                    <div style="float:left;">
                    <p style="color: red;">
                        مبلغ پیشنهاد شده:</br>
                        <span  class="" style="padding: 0 10px;;background-color: #de2b2b; color: #fff; font-size:15pt;">
                            ' . number_format($this->price) . '
                        
                        ریال
                    </span>
					</p>
					<p style=" color: #0000ff;display:none;">
                         بیعانه درخواستی مجری:</br>
                        <span  class="" style=" padding: 0 10px;background-color:#203fb4; color: #fff; font-size:15pt;">
                            ' . number_format($this->earnest) . '
                        
                        ریال
                    </span></p></div>
					  ')


//                . $u->displayCups($u->rate)
                . '</br></br></br>'
                . '<p style="text-align: justify; float: right; width: 66%;">
                    ' . nl2br($this->message) . '</p>';


        $div.='</div>';
        $div.='</div>';
        $div.='<div class="clear"></div>';
        return $div;
    }

}

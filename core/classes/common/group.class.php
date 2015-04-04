<?php

/*
 * In The Name of GOD
 * @author MHK448
 * Email: MHK448@gmail.com
 * Created at: Mar 12, 2014 , 11:31:47 PM
 * mhkInfo:
 */


/* @var $database Database */
/* @var $cdatabase Database */
/* @var $user User */
/* @var $message Message */

class Group {

    public static $maxGroup = 1;
    private static $minMember = 3;
    private static $maxMember = 5;
    private $_info = array();

    public function __construct($id = NULL) {
        $this->_info['id'] = $id;
    }

    public function __get($name) {
        if ($name == 'id') {
            return $this->_info['id'];
        } elseif ($name == 'members') {
            return $this->getMembers();
        } elseif ($this->_info['id']) {
            if (!isset($this->_info['title']))
                $this->_setGroupInfo();
            if (isset($this->_info[$name]))
                return $this->_info[$name];
        }
        return NULL;
    }

    private function _setGroupInfo() {
        global $database;
        $this->_info = $database->fetchAssoc($database->select('groups', '*', $database->whereId($this->id)));
    }

    public function getMembers($full = FALSE) {
        if ($full) {
            global $database;
            return $database->fetchAll($database->select('group_members', '*', $database->whereId($this->id, "group_id")));
        }
        if (isset($this->_info['members']))
            return $this->_info['members'];
        global $database;
        $members = $database->fetchAll($database->select('group_members', '*', $database->whereId($this->id, "group_id") . ' AND verified > 0'));
        $this->_info['members'] = $members;
        return $members;
    }

    public function add($creator_id, $title, $file) {
        global $database, $user, $message, $subSite, $files;

        if ($creator_id != $user->id && !$user->isAdmin())
            return;

        $database->insert('groups', array(
            'title' => $title,
            'creator' => $creator_id));

        $gid = $database->getInsertedId();
        $database->insert('group_members', array(
            'group_id' => $gid,
            'user_id' => $creator_id,
            'verified' => 1,
            'dateline' => time()));

        if (isset($_FILES[$file]) && $_FILES[$file]['name']) {
            if (!$files->upload($file, 'GL_' . $gid . '.png', 'uploads/' . $subSite . '/group/', 30 * 1024, 'x-pic')) {
                $message->addError('امکان ارسال این تصویر وجود ندارد');
//                return false;
            }
        }
        $message->addMessage("گروه $title با موفقیت ایجاد شد. شما می توانید دوستانتان را به عضویت در گروه دعوت کنید");
        return TRUE;
    }

    public function update($title, $file) {
        global $database, $user, $message, $subSite, $files;

        if ($this->creator != $user->id && !$user->isAdmin())
            return;

        if (isset($_FILES[$file]) && $_FILES[$file]['name']) {
            if (!$files->upload($file, 'GL_' . $this->id . '.png', 'uploads/' . $subSite . '/group/', 30 * 1024, 'x-pic')) {
                $message->addError('امکان ارسال این تصویر وجود ندارد');
//                return false;
            }
        }

        $database->update('groups', array(
            'title' => $title), $database->whereId($this->id));


        return TRUE;
    }

    public function inviteUser($user_id) {
        global $database, $user, $message, $event;

        if ($this->hasMember($user_id)) {
            $message->addError("این کاربر عضو گروه است");
            return;
        }

        if ($user_id != $user->id) {
            if (($user->id == $this->creator && $user_id != $user->id) || $user->isAdmin()) {
                $database->insert('group_members', array(
                    'group_id' => $this->id,
                    'user_id' => $user_id,
                    'verified' => 0,
                    'dateline' => time()
                ));
                $event->call($user_id, Event::$T_GROUP, Event::$A_G_INVITE, array("title" => $this->title));
                $message->addMessage("دعوت نامه ارسال شد");
            }
        }
    }

    public function hasMember($user_id) {
        foreach ($this->getMembers(TRUE) as $mem) {
            if ($mem['user_id'] == $user_id) {
                return TRUE;
            }
        }
        return FALSE;
    }

    public function removeUser($user_id) {
        global $database, $user, $message;
        if ($user_id == $user->id OR $user->id == $this->creator OR $user->isAdmin()) {
            $database->update("group_members", array(
                'verified' => -1,
                    ), $database->whereId($user_id, "user_id") . " AND group_id = " . $this->id);
        } else {
            $message->addError("امکان حذف این کاربر وجود ندارد");
        }
    }

    public function acceptUser($user_id) {
        global $database, $user, $message;
        $u = new User($user_id);
        if (count($u->getGroups()) >= self::$maxGroup && !$user->isAdmin()) {
            $message->addError("هر کاربر می تواند فقط عضو " . self::$maxGroup . " گروه باشد. ");
        } else {
            if ($user_id == $user->id OR $user->isAdmin()) {
                $database->update("group_members", array(
                    'verified' => 1,
                        ), $database->whereId($user_id, "user_id") . " AND group_id = " . $this->id);
                return TRUE;
            } else {
                $message->addError("امکان عضویت وجود ندارد");
            }
        }
        return FALSE;
    }

    public function delete() {
        global $user, $database;
        //nc?
    }

    public function addRank($rank) {
        global $database;
        return $database->update("groups", array(
                    'rankers' => $this->rankers + 1,
                    'rank' => $this->rank + $rank,
                        ), $database->whereId($this->id));
    }

    public function isValid() {
        $c = count($this->getMembers());
        if ($c >= self::$minMember && $c <= self::$maxMember) {
            return TRUE;
        }
        return FALSE;
    }
    ///////////////////////////////////////
    public function displayMembers() {
        $out = "";
        foreach ($this->getMembers() as $mem) {
            $u = new User($mem['user_id']);
            $out .= $u->displayMiniInfo(TRUE, TRUE, TRUE) . " ";
        }
        return $out;
    }

     public function displayRank() {
        global $message;
        $message->displayRank($this->rank, $this->rankers);
    }
    
    public function displayCups($rate = -1) {
        $count = 0;
        $out = '';
        if ($rate > 0 && $rate <= 5) {
            $count++;

            $out.= '<img class="help cup" style="cursor: help;" width="20" src="medias/images/icons/cup_green.png" alt="type cup"/>
            <div class="help_comment">
                ..:: رتبه برتر ::..
                <br/>        
                کسب رتبه ی 
                ' . $rate . '
                از بین گروه ها
            </div>';
        }

        if ($this->rankers >= 10) {
            $count++;
            $out.='
            <img class="help cup" style="cursor: help;" width="20" src="medias/images/icons/cup_red.png" alt="type cup"/>
            <div class="help_comment">
                ..::  گروه با تجربه ::..
                <br/>
                انجام موفق بیش از 
                ' . $this->rankers . '    
                پروژه 
            </div>';
       
        }
        $rankers = ($this->rankers == 0 ? 1 : $this->rankers);
        if ($this->rank / $rankers >= 9) {
            $count++;
            $out.='
            <img class="help cup" style="cursor: help;" width="20" src="medias/images/icons/cup_blue.png" alt="type cup"/>
            <div class="help_comment">
                ..::گروه ممتاز ::..
                <br/>
                دریافت امتیاز عالی از کارفرما
            </div>';
        }

        return $out;
    }
}
?>

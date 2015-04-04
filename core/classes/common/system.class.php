<?php

/*
 * In The Name of GOD
 * @author MHK448
 * Email: MHK448@gmail.com
 * Created at: Jan 8, 2014 , 8:08:18 PM
 * mhkInfo:
 */

class System {

    private static $S_DEL_OLD_FILE = 'delOldFile';
    private static $S_CLOSE_PROJECT = 'closeProject';
    private static $S_FINISH_PROJECT = 'finishProject';
    private static $S_CHECK_SMS = 'checkSMS';
    private static $S_HOME_RATE = 'homeRate';
    private static $S_FULL_BACKUP_COM = 'fullBackupCom';
    private static $S_FULL_BACKUP_SUB = 'fullBackupSub';
    private static $S_DAILY_BACKUP_COM = 'dailyBackupCom';
    private static $S_DAILY_BACKUP_SUB = 'dailyBackupSub';
    private static $S_CHECK_DAILY_COM = 'checkDailyCom';
    private static $S_CHECK_DAILY_SUB = 'checkDailySub';
    private $_info = array();

    public function __construct() {
        
    }

    public function __get($name) {
        if (isset($this->_info[$name]))
            return $this->_info[$name];
        return '';
    }

    public function getAll() {
        $this->_setSystemInfo();
        return $this->_info;
    }

    public function update($name, $value, $comment) {
        $this->_setSystemInfo();
        $s = $this->_info[$name];
        if (!$s)
            return FALSE;

        if ($s['sub'] == 'com') {
            global $cdatabase;
            $db = $cdatabase;
        } else {
            global $database;
            $db = $database;
        }
        $db->update('settings'
                , array('value' => $value, 'comment' => $comment)
                , " WHERE name='" . $name . "'");
        $this->_setSystemInfo();
        return TRUE;
    }

    private function _setSystemInfo() {
        global $database, $cdatabase, $subSite;
        $settings = $cdatabase->fetchAll($cdatabase->select('settings'));
        foreach ($settings as $s) {
            $s['sub'] = 'com';
            $this->_info[$s['name']] = $s;
        }
        $settings = $database->fetchAll($database->select('settings'));
        foreach ($settings as $s) {
            $s['sub'] = $subSite;
            $this->_info[$s['name']] = $s;
        }
    }

    private function getTiket($name) {
        $sd = $this->_info[$name . '_delay'];
        $sl = $this->_info[$name . '_last'];
        if ($sd != NULL && $sl['value'] < time()) {
            if ($sd['sub'] == 'com') {
                global $cdatabase;
                $db = $cdatabase;
            } else {
                global $database;
                $db = $database;
            }
            $newval = $sd['value'] + ($sl['value'] ? $sl['value'] : time());
            return $db->update('settings'
                            , array('value' => $newval)
                            , " WHERE value='" . $sl['value'] . "' AND name='" . $sl['name'] . "'");
        }
        return FALSE;
    }

    public function checkAllCronjob() {
        global $user, $_CONFIGS;
        if ($_CONFIGS['TestMode'])
            return;
        $this->_setSystemInfo();
        if ($this->getTiket(System::$S_DEL_OLD_FILE)) {
            $this->deleteOldProjectFile();
        } elseif ($this->getTiket(System::$S_CLOSE_PROJECT)) {
            $this->closeProject();
        } elseif ($this->getTiket(System::$S_FINISH_PROJECT)) {
            $this->finishProject();
        } elseif ($this->getTiket(System::$S_CHECK_SMS)) {
            $this->checkSMS();
        } elseif ($this->getTiket(System::$S_HOME_RATE)) {
            $this->updateHomeRate();
        } elseif ($this->getTiket(System::$S_CHECK_DAILY_SUB)) {
            $this->resetRate();
        } elseif ($this->getTiket(System::$S_CHECK_DAILY_COM)) {
            $this->resetSigninKey();
            $this->checkCreditSMS();
            //////////////////////
        } elseif ($this->getTiket(System::$S_FULL_BACKUP_COM)) {
            $this->dbBackUp("com", "full");
        } elseif ($this->getTiket(System::$S_FULL_BACKUP_SUB)) {
            $this->dbBackUp("sub", "full");
        } elseif ($this->getTiket(System::$S_DAILY_BACKUP_COM)) {
            $this->dbBackUp("com", "daily");
        } elseif ($this->getTiket(System::$S_DAILY_BACKUP_SUB)) {
            $this->dbBackUp("sub", "daily");
        }
    }

    //////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////
    private function deleteOldProjectFile() {
        Project::deleteOldProjectFile($this->delOldFile_age['value']);
    }

    private function closeProject() {
        Project::checkOpenProjects($this->closeProject_age['value']);
    }

    private function finishProject() {
        
    }

    private function checkSMS() {
        
    }

    private function updateHomeRate() {
        global $database;
        $start7day = intval((time() - 7 * 24 * 60 * 60) / (24 * 60 * 60)) * 24 * 60 * 60 - (12600); // 12600 = 3:30 h
        $end7day = $start7day + (7 * 24 * 60 * 60);
        $users_top = $database->fetchAll($database->select('projects', '`typist_id` as `uid`', "WHERE `ranked_typist`<>-1 AND `submit_date`>'" . $start7day . "' AND `submit_date`<'" . $end7day . "'  GROUP BY `typist_id` ORDER BY sum(`ranked_typist`)/count(`ranked_typist`) DESC LIMIT 3"));
        $users_active = $database->fetchAll($database->select('final_files', 'user_id, sum( pages )', "WHERE dateline>'" . $start7day . "' AND dateline<'" . $end7day . "'  GROUP BY `user_id` ORDER BY sum( pages ) DESC LIMIT 3"));
        foreach ($users_top as $us) {
            $users_top_a[] = intval($us['uid']);
        }
        foreach ($users_active as $us) {
            $users_active_a[] = intval($us['user_id']);
        }
        $this->update('homeRate_userTop', json_encode($users_top_a), 'مجری برتر ۷ روز');
        $this->update('homeRate_userActive', json_encode($users_active_a), 'مجری فعال ۷ روز');
    }

    function dbBackUp($db, $type) {
        global $backup_db, $backup_state, $_CONFIGS;
        $backup_db = $db;
        $backup_state = $type;
        include_once "plugin/phpmysqlautobackup/create.php";
//        exit;
    }

    private function resetRate() {
        global $database;
        return $database->update('users_sub', array('rate' => 0));
    }

    private function resetSigninKey() {
        global $cdatabase;
        return $cdatabase->update('users', array('login_key' => ''));
    }

    private function checkCreditSMS() {
        $c = PersonalMessage::checkCreditSMSService();
        if ($c < 200) {
            global $event;
            $msg = "اعتبار سامانه پیامک " . $c;
            $msg.=" (لطفا شارژ شود) ";
            $event->call(User::$ADMIN_1, Event::$T_ADMIN, Event::$A_WARN, array("msg" => $msg), TRUE, FALSE, TRUE, TRUE);
            $event->call(User::$ADMIN_2, Event::$T_ADMIN, Event::$A_WARN, array("msg" => $msg), TRUE, FALSE, TRUE, TRUE);
        }
    }

}

?>
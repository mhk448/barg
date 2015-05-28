<?php

/*
 * In The Name of GOD
 * @author MHK448
 * Email: MHK448@gmail.com
 * Created at: Mar 23, 2014 , 4:58:07 PM
 * mhkInfo:
 */

/* @var $database Database */
/* @var $cdatabase Database */
/* @var $user User */
/* @var $message Message */

class Content {

    public static $CONTENT_HOME_RIGHT_1 = 1;
    public static $CONTENT_HOME_RIGHT_2 = 2;
    public static $CONTENT_HOME_RIGHT_3 = 3;
    public static $NOTE_PROJECT_FINISH = 11;
    public static $NOTE_PROJECT_BID = 12;
    public static $NOTE_PROJECT_FINAL_FILE = 13;
    public static $NOTE_PROJECT_BID_NO_AGENCY = 14;
    
    public static $NOTE_PROJECTS_OPEN_ALL = 15;
    public static $NOTE_PROJECTS_OPEN_WORKER = 16;
    
    public static $TWITTS = 17;
//    public static $NOTE_PROJECTS_OPEN_USER = ;
//    public static $NOTE_PROJECTS_OPEN_AGENCY = ;
    
    private $_info = array();

    public function __construct($id = NULL) {
        $this->_info['id'] = $id;
    }

    public function __get($name) {
        if ($name == 'id') {
            return $this->_info['id'];
        } elseif ($this->_info['id']) {
            if (!isset($this->_info['title']))
                $this->_setContentInfo();
            if (isset($this->_info[$name]))
                return $this->_info[$name];
        }
        return NULL;
    }

    private function _setContentInfo() {
        global $database, $user;
        $this->_info = $database->fetchAssoc($database->select('contents', '*', $database->whereId($this->id)));


        // check validate
        if ($this->user_type == "All")
            return TRUE;
        if ($user->isAdmin())
            return TRUE;
        if ($this->user_type == "Worker" && $user->isWorker())
            return TRUE;
        if ($this->user_type == "Agency" && $user->isAgency())
            return TRUE;
        if ($this->user_type == "User" && $user->isMaster() && !$user->isAgency())
            return TRUE;



        $this->_info['title'] = '';
        $this->_info['body'] = '';
        return FALSE;
    }

    public function add($user_type, $title, $body) {
        global $database, $user, $message;

        if (!$user->isAdmin())
            return FALSE;

        $database->insert('contents', array(
            'user_type' => $user_type,
            'title' => $title,
            'body' => $body,
            'verified' => 1,
            'dateline' => time()));

        $id = $database->getInsertedId();

        $message->addMessage("added whith id :" . $id);
        return TRUE;
    }

    public function update($user_type, $title, $body) {
        global $database, $user, $message;

        if (!$user->isAdmin())
            return FALSE;

        return $database->update('contents', array(
                    'user_type' => $user_type,
                    'title' => $title,
                    'body' => $body,
                    'verified' => 1,
                    'dateline' => time())
                        , $database->whereId($this->id));
    }

    public static function BODY($id) {
        $c = new Content($id);
        return $c->body;
    }

}

?>

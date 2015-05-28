<?php

/*
 * In The Name of GOD
 * @author MHK448
 * Email: MHK448@gmail.com
 * Created at: Jun 1, 2013 , 12:16:08 AM
 * mhkInfo:
 */

/**
 * Description of discount
 *
 * @author MHK448
 */
class Discount {

    public $e;
    public $p;

    public function set($code, $uid, $pid = 0) {
        $this->e = 0;
        $this->c = 0;
    }

    public function IsValid() {
        return FALSE;
    }

    public function add() {
        return TRUE;
    }

    public function createCode($p, $e) {

        return 'P' . $p . 'E' . $e;
    }

    public function get($code, $price) {// fa-> mohasebe bedun batel kardan
        return $price;
    }

    public function derogate($code, $price) {// fa-> batel kardan takhfif
        //nc? derogate discount of sql
        return $this->get($code, $price);
    }

    public function setReferer($uid) {
        global $auth;
        $expire_date = 3600 * 24 * 7;
        $auth->_setCookies('referer', $uid, $expire_date);
    }

    public function getReferer() {
        global $auth;
        if ($auth->_getCookies('referer'))
            if (intval($auth->_getCookies('referer')))
                return intval($auth->_getCookies('referer'));
        return '';
    }

    public function deleteReferer() {
        global $auth;
        $auth->_deleteCookies('referer');
    }

}

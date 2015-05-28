<?php

/* @var $database Database */
/* @var $cdatabase Database */
/* @var $user User */
/* @var $message Message */

class Auth { //Authentication

    public $id = 0;
    public $group = 'Guest';
    public $member_name = '';

    public function __construct() {
        
    }

    public function validate($form_name, $fields = array()) {
        global $message;
        if (isset($_POST['submit']) && isset($_POST['formName']) && $_POST['formName'] == $form_name) {
            // Check Fields
            for ($i = 0; $i < count($fields); $i++) {
                switch ($fields[$i][1]) {
                    case 'Required':
                        if (!isset($_POST[$fields[$i][0]]) || trim($_POST[$fields[$i][0]]) == '')
                            $message->addError($fields[$i][2]);
                        break;
                    case 'Selected':
                        if ($_POST[$fields[$i][0]] === '0')
                            $message->addError($fields[$i][2]);
                        break;
                    case 'Checked':
                        if (!isset($_POST[$fields[$i][0]]))
                            $message->addError($fields[$i][2]);
                        break;
                    case 'UserName':
                        if (!(isset($_POST[$fields[$i][0]]) && strlen($_POST[$fields[$i][0]]) < 20 && preg_match("/^[A-Za-z0-9_]+$/", $_POST[$fields[$i][0]])))
                            $message->addError($fields[$i][2]);
                        break;
                    case 'Email':
                        if (!preg_match("/^[-_a-z0-9\'+*$^&%=~!?{}]++(?:\.[-_a-z0-9\'+*$^&%=~!?{}]+)*+@(?:(?![-.])[-a-z0-9.]+(?<![-.])\.[a-z]{2,6}|\d{1,3}(?:\.\d{1,3}){3})(?::\d++)?$/iD", $_POST[$fields[$i][0]]))
                            $message->addError($fields[$i][2]);
                        break;
                    case 'File':
                        if (!(isset($_FILES[$fields[$i][0]]) || $_FILES[$fields[$i][0]]['name'] == '' ))
                            $message->addError($fields[$i][2]);
                        break;
                }
            }

            // Check CAPTCHA
            if (isset($_POST['captcha'])) {

                @session_start();
                if (strtoupper($_POST['captcha']) != $_SESSION['_CAPTCHA_'])
                    $message->addError('&#1705;&#1583; &#1575;&#1605;&#1606;&#1740;&#1578;&#1740; &#1608;&#1575;&#1585;&#1583; &#1588;&#1583;&#1607; &#1548; &#1589;&#1581;&#1740;&#1581; &#1606;&#1605;&#1740;&#1576;&#1575;&#1588;&#1583;.');
                session_destroy();
            }

            if ($message->errors_count == 0)
                return true;
            else
                return false;
        }
        else
            return false;
    }

    public function fildValid($fild, $validValue) {
        if ($fild == null || trim($fild) == "")
            return FALSE;

        $validStr = 'a|';
        if (is_array($validValue)) {
            for ($index = 0; $index < count($validValue); $index++) {
                $validStr.=strtoupper($validValue[$index] . '|');
            }
        } else {
            $validStr.=strtoupper($validValue . '|');
        }

        $fild = strtoupper(trim($fild));
        $fild = '|' . $fild . '|';
        if (strpos($validStr, $fild) === FALSE)
            return FALSE;
        return TRUE;
    }

    public function _setCookies($name, $values, $expire = 0, $path = '/', $domain = '') {
        if (headers_sent())
            return;
        $expire = ($expire > 0) ? time() + $expire : 0;
        if (is_array($values)) {
            foreach ($values as $key => $value) {
                $this->_setCookies($name . "[$key]", urlencode($value), $expire, $path, $domain);
            }
        } else {
//            setcookie($name, urlencode($values), $expire, $path, $domain);
        global $_CONFIGS;
            $domains = explode("|", $_CONFIGS['domains']);
            if ($_CONFIGS['TestMode'])
                setcookie($name, urlencode($values), $expire, $path);
            foreach ($domains as $d) {
                setcookie($name, urlencode($values), $expire, $path, $d);
            }
        }
    }

    public function _getCookies($name, $index = '') {
        if ($index != '')
            if (isset($_COOKIE[$name][$index]))
                return urldecode($_COOKIE[$name][$index]);
            else
                return false;
        else
        if (isset($_COOKIE[$name]))
            return urldecode($_COOKIE[$name]);
        else
            return false;
    }

    public function _deleteCookies($name) {
        if (headers_sent())
            return;
        $this->_setCookies($name, '', time() - 3600 * 24);
        unset($_COOKIE[$name]);
    }

    public function canSendMessage(User $user) {
        return TRUE;
    }

    public function canSendTwitt(User $user) {
        return TRUE;
    }

    public function canSendProject(User $user) {
        if ($user->isAgency())
            return TRUE;
        return TRUE;
    }

    public function canSignup() {
        return TRUE;
    }

}
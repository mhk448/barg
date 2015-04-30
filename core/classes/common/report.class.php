<?php

class Report {

    public function __construct() {
        
    }

    public function getPayments($user) {
        global $cdatabase;
        return $cdatabase->fetchAll($cdatabase->select('payments', '*', $cdatabase->whereId($user->id, "user_id") . ' ORDER BY dateline DESC LIMIT 20'));
    }

    public function getPayouts($user) {
        global $cdatabase;
        return $cdatabase->fetchAll($cdatabase->select('payouts', '*', $cdatabase->whereId($user->id, "user_id") . ' ORDER BY dateline DESC LIMIT 20'));
    }

    public function getReleases($user) {
        
    }

    public function getListLockedCredit($user) {
        global $cdatabase;
        return $cdatabase->fetchAll($cdatabase->select('lock_credit', '*', $cdatabase->whereId($user->id, "user_id") . " AND `locked` = '1' " . ' ORDER BY date DESC'));
    }

    public function countNewPayments() {
        global $cdatabase;
        return $cdatabase->selectCount('payments', ' WHERE verified=0 ');
    }

    public function countNewPayouts() {
        global $cdatabase;
        return $cdatabase->selectCount('payouts', ' WHERE verified=0 ');
    }

    public function countNewAgency() {
        global $database;
        return $database->selectCount('representative_requests', ' WHERE readed<>-1 ');
    }

//    public function getCreditReport($user) {
//        global $cdatabase;
//        return $cdatabase->fetchAll($cdatabase->select('credits', '*', $cdatabase->whereId($user->id, "user_id") . ' ORDER BY dateline DESC'));
//    }

    public static function addLog($msg) {
        global $user, $project, $persiandate, $_CONFIGS, $message,$subSite;
        if (is_array($msg))
            $msg = json_encode($msg);


        $sep = "<br/>\n";
        $reg = '';
        $reg.='user:  ' . $user->id . ' ' . $user->username . ' ' . $user->email . ' ' . $sep;
        $reg.='project:  ' . $project->id . ' ' . $project->title . $sep;
        $reg.='page:  ' . getCurPageName() . $sep;
        $reg.='Param:  ';
        foreach ($_REQUEST as $key => $value)
            $reg.= $key . ':' . $value . ' , ';
        $reg.=$sep;

        $reg.='SERVER:  ';
        foreach ($_SERVER as $key => $value)
            $reg.= $key . ':' . $value . ' , ';
        $reg.=$sep;

        $reg.='Subsite:  ' . $subSite . $sep;
        $reg.='Param:  ' . getCurPageName() . $sep;
        $reg.='IP:  ' . mh_getIp() . $sep;
        if($persiandate)
            $reg.='Time:  ' . $persiandate->date("Y/m/d h:i:s") . $sep;
        $reg.='msg:  ' . $msg . $sep;

        if ($_CONFIGS['TestMode']) {
            $message->displayError('<div class="english" style="text-align:left">' . $reg . '</div>');
            return;
        }
        $reg.="HHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHH" . $sep;

//        $headers = "From: mcatalog_robot@mhk448.ir\n" .
//                "MIME-Version: 1.0\n" .
//                "Content-Type: text/html;\n";
//        //"Content-Type: multipart/mixed;\n";
//        $fill2 = @mail("mhk448@yahoo.com", "register mcatalog", $reg, $headers);

        try {
            $myFile = "/errorReport.txt";
            $fh = fopen($myFile, 'a') or die("can't open file"); // w | r | a | wb
            fwrite($fh, $reg);
            fclose($fh);
        } catch (Exception $exc) {
            
        }
    }

    public static function getLogs() {
        try {
            $myFile = "/errorReport.txt";
            $fh = @fopen($myFile, 'r') or die("can't open file"); // w | r | a | wb
            $d = @fread($fh, 100000);
            @fclose($fh);
        } catch (Exception $exc) {
            
        }
        return $d;
    }

    public function addIfExistReferer() {
        global $cdatabase, $discount;
        //mc? bargardoon.com
        if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']) {
            if (strpos($_SERVER['HTTP_REFERER'], 'bargardoon.com') === FALSE) {
                if ($_SERVER['HTTP_REFERER'] != 'https://www.google.com/')
                    if (strpos($_SERVER['HTTP_REFERER'], 'baidu.com') === FALSE)
                        if (strpos($_SERVER['HTTP_REFERER'], 'www.google.com') === FALSE)
                            if (strpos($_SERVER['HTTP_REFERER'], 'search.ask.com') === FALSE)
                                if (strpos($_SERVER['HTTP_REFERER'], 'paypaad.bankpasargad') === FALSE)
                                    if (strpos($_SERVER['HTTP_REFERER'], 'elmend.lc') === FALSE) {
                                        if (isset($_REQUEST['r'])) {
                                            $user_id = intval($_REQUEST['r']);
                                            $discount->setReferer($user_id);
                                        } else {
                                            $user_id = 0;
                                        }

                                        $cdatabase->insert('user_referer_site', array(
                                            'user_id' => $user_id,
                                            'dateline' => time(),
                                            'site' => $_SERVER['HTTP_REFERER']
                                                )
                                        );
                                    }
            }
        }
    }

    public function appendAdminComment($comment, $type, $text) {
        global $database, $user;
        if (trim($text)) {
            if ($comment) {
                if (is_array($comment)) {
                    
                } else {
                    $array = json_decode($comment, TRUE);
                    if (!is_array($array) && trim($comment)) {
                        $array = array();
                        $d = time() - 1;
                        $array[$d]['u'] = $user->id;
                        $array[$d]['t'] = 'old';
                        $array[$d]['m'] = $comment;
                    }
                    $comment = $array;
                }
            } else {
                $comment = array();
            }
            $d = time();
            $comment[$d]['u'] = $user->id;
            $comment[$d]['t'] = $type;
            $comment[$d]['m'] = $text;
        }

        return $comment;
    }

    public function displayAdminComment($adminComment) {
        global $user, $persiandate;
        $out = '';
        $acs = json_decode($adminComment, TRUE);
        if (!is_array($acs) && $adminComment) {
            $acs = array();
            $d = time();
            $acs[$d]['u'] = $user->id;
            $acs[$d]['t'] = 'old';
            $acs[$d]['m'] = $adminComment;
        }
        if ($acs) {
            foreach ($acs as $acd => $ac) {
                $out .= '<br/>' . $persiandate->date('d F Y', $acd) . ' - ' . $ac['u'] . ' - ' . $ac['t'] . ' - ' . $ac['m'];
            }
        }
        return $out;
    }

}

?>
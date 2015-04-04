<?php

/*
 * In The Name of GOD
 * @author MHK448
 * Email: MHK448@gmail.com
 * Created at: Jul 26, 2013 , 11:32:15 AM
 * mhkInfo:
 */

if (isset($_REQUEST['s'])
        && isset($_REQUEST['t'])
        && isset($_REQUEST['p'])) {

    SMSPars($_REQUEST['s'], $_REQUEST['t']);
    echo 'ok';
} else {
    echo 'Error';
}

function SMSPars($sender_mob, $msg) {
    global $user, $personalmessage;
    $msg_array = explode("\n", $msg);
    $personalmessage = new PersonalMessage();
    $user = $user->getUserByMobile($sender_mob);
    $reaciver = extractUser($msg_array);
    $prj = extractProject($msg_array);
    $action = extractAction($msg_array);
    $text = extractText($msg_array);
    $last_sms_user = $user->getLastSmsSender();

    if ($action && $prj && $action == "cancel") {
        $prj->cancelBid();
    } elseif ($action && $prj && $action == "share" && $reaciver) {
        $prj->addShare($reaciver, $text);
    } elseif ($prj && $prj->typist_id == $user) {
//        $personalmessage->SMSSend($user->id, $prj->user_id, $text);
        $personalmessage->send($user->id, $prj->user_id, $subject, $text, 0, $prj->id);
    } elseif ($prj && $prj->user_id == $user) {
//        $personalmessage->SMSSend($user->id, $prj->typist_id, $text);
        $personalmessage->send($user->id, $prj->typist_id, $subject, $text, 0, $prj->id);
    } elseif ($reaciver) {
//        $personalmessage->SMSSend($user->id, $reaciver->id, $text);
        $personalmessage->send($user->id, $reaciver->id, $subject, $text);
    } elseif ($last_sms) {
//        $personalmessage->SMSSend($user->id, $last_sms_user->id, $text);
        $personalmessage->send($user->id, $last_sms_user->id, $subject, $text);
    } else {
        $personalmessage->send($user->id, User::$SUPORT, $subject, $text, 0, -1, 1);
    }
}

//function getLastSmsSender($user) {
//    
//}
//
//function getUserByMobile($mobile) {
//    
//}

function extractAction($msg_array) {
    $users = preg_grep('/[A][0-9]+/i', $msg_array);
    if (count($users) > 0) {
        return $users[0];
    }
    return FALSE;
}

function extractUser($msg_array) {
    $users = preg_grep('/[W|M][0-9]+/i', $msg_array);
    if (count($users) > 0) {
        return new User($users[0]);
    }
    return FALSE;
}

function extractProject($msg_array) {
    $prjs = preg_grep('/[T|R][0-9]+/i', $msg_array);
    if (count($prjs) > 0) {
        return new Project($prjs[0]);
    }
    return FALSE;
}

function extractText($msg_array) {
    $prjs = preg_grep('/[T|R][0-9]+/i', $msg_array, PREG_GREP_INVERT);
    if (count($prjs) > 0) {
        return $prjs[0];
    }
    return FALSE;
}


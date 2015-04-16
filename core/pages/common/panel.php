<?php

if (isset($_CONFIGS['Params'][1]) && $_CONFIGS['Params'][1] == 'logout') {
    $user->signout();
    header('Location: success-logout');
    exit();
}

if ($auth->validate('LoginForm', array(
            array('un', 'Required', 'نام کاربری را وارد نمایید.'),
            array('pw', 'Required', 'کلمه عبور را وارد نمایید.'),
        ))) {
    if ($user->signin()) {
        if (isset($_REQUEST['afterlink'])) {
            header('Location: ' . $_REQUEST['afterlink']);
        }else
            header("Location: success-login");
        exit();
    }
}

if (isset($_REQUEST['formName']) && ($_REQUEST['formName'] == 'userlevel')) {
    if ($userlevel->saveLevel($user, $_REQUEST['qid'], $_REQUEST['a0'], $_REQUEST['a1'], $_REQUEST['a2'], $_REQUEST['a3'], $_REQUEST['a4'], $_REQUEST['a5'])) {
        $message->addMessage('باتشکر<br>اطلاعات با موفقیت ذخیره شد');
    }
}

if (isset($_REQUEST['formName']) && ($_REQUEST['formName'] == 'SelectGroup')) {
    if (!$user->hasGroup()) {
        if (isset($_REQUEST['Worker']) || isset($_REQUEST['Worker_x']))
            $user->setType(User::$G_WORKER);
        else {
            $user->setType(User::$G_USER);
        }
        header("Location: panel");
        exit();
    }
}
if ($user->isSignin()) {
    $last_prj = array();
    $last_event = array();
//    $last_prj = $pager->getList('projects', '*', "WHERE user_id={$user->id} OR typist_id={$user->id}", 'ORDER BY submit_date DESC', NULL, 5);
    $last_msg = $pager->getComList('messages', '*', "WHERE to_id={$user->id}", 'ORDER BY dateline DESC', NULL, 5);
//    $last_event = $pager->getList('events', '*', "WHERE user_id={$user->id}", 'ORDER BY dateline DESC', NULL, 5);
}

if ($user->state == 'Inactive')
    $message->addError('&bull; کاربری شما هنوز فعال نشده است. &nbsp;&nbsp;&nbsp; لطفا اطلاعات خود را تکمیل نمایید تا توسط مدیریت فعال گردید. &nbsp;&nbsp;&nbsp; <a href="edit-profile">تکمیل اطلاعات</a>');

if (!$user->isSignin() || !$user->hasGroup()) {
    include 'core/pages/common/panel-login.php';
} elseif ($user->isWorker()) {
    include 'core/pages/' . 'common/header.php';
    include 'core/pages/' . $subSite . '/panel-worker.php';
    include 'core/pages/' . 'common/footer.php';
} else {
    include 'core/pages/' . 'common/header.php';
    include 'core/pages/' . $subSite . '/panel-user.php';
    include 'core/pages/' . 'common/footer.php';
}
?>
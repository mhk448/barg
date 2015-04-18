<?php
ob_start();

include "core/config/initialize.php";
register_shutdown_function("fatal_handler");
include 'test.php';

$page = $_PAGES['Home'];

if (!suportBrowser()) {
    $page = $_PAGES['BadBrowser'];
    setPage($page[0], $page[1], $page[2], $page[3], $page[4]);
} elseif (in_array($_CONFIGS['Params'][0], array_keys($_PAGES))) {
    $page = $_PAGES[$_CONFIGS['Params'][0]];
    // Check Permission
    if (in_array('All', explode(',', $page[5])) || $user->isSuperAdmin()) {
        // any thing
    } elseif (in_array($user->usergroup, explode(',', $page[5]))) {
        // any thing
    } else if ($user->isSignin()) {
        $page = $_PAGES['PermissionDenied'];
    } else {
        $page = $_PAGES['LoginDenied'];
    }
    setPage($page[0], $page[1], $page[2], $page[3], $page[4]);
} elseif ($user->isSignin() && !$user->hasGroup()) {
    $page = $_PAGES['panel'];
    setPage($page[0], $_CONFIGS['Params'][0], $_CONFIGS['Params'][0], $page[3], $page[4]);
} elseif (getCurPageName(FALSE) != 'home') {
    header('Location: ' . $_CONFIGS['Site']['Sub']['Path']);
    exit;
} else {
    setPage($page[0], $_CONFIGS['Params'][0], $_CONFIGS['Params'][0], $page[3], $page[4]);
}

User::addVisitLog();
$report->addIfExistReferer();

//$PAGE_NUM = isset($_REQUEST['pagen']) ? (int) $_REQUEST['pagen'] : 1;
if ($_CONFIGS['Page']['File'] == 'blog') {
    header('Location: ' . $_CONFIGS['Pathes']['Blog']);
    exit;
}

if (substr($_CONFIGS['Page']['File'], 0, 4) == 'http') {
    header('Location: ' . $_CONFIGS['Page']['File']);
    exit;
}

if ($_REQUEST['request'] == "mob" || $_REQUEST['request'] == "/mob") {
    include 'mobile/service.php';
} elseif (isset($_REQUEST['ajax'])) {
    if (getCurPageName() == 'home') {
        include 'core/pages/' . $subSite . '/panel.php';
    } else {
        include 'core/pages/' . $_CONFIGS['Page']['File'];
    }
} else if (getCurPageName(FALSE) == "register") {
    include 'core/pages/' . $_CONFIGS['Page']['File'];
} else if (getCurPageName(FALSE) == "panel") {
    include 'core/pages/' . $_CONFIGS['Page']['File'];
} else if (getCurPageName(FALSE) == "typeonline") {
    include 'core/pages/' . $_CONFIGS['Page']['File'];
} else if (getCurPageName(FALSE) == "ajax-pages") {
    include 'core/pages/' . $_CONFIGS['Page']['File'];
} else if (getCurPageName(FALSE) == 'home') {
    include 'core/pages/' . $_CONFIGS['Page']['File'];
} else {
    $system->checkAllCronjob();
    include 'core/pages/' . 'common/header.php';
    include 'core/pages/' . $_CONFIGS['Page']['File'];
    include 'core/pages/' . 'common/footer.php';
}

finishTest();

ob_end_flush();


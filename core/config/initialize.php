<?php

error_reporting(E_ALL & ~E_NOTICE);

$subSite = getSubSite();
// Load Global Functions
include 'functions.php';

// Load Configs
include 'configs_1.php';// mhk

// Load pages
include 'pages.php';

// Load Price List
include 'enums.php';

// Load Price List
include 'core/config/' . $subSite . '/prices.php';


date_default_timezone_set('Asia/Tehran');

initHeader();

// Load Interface
//include_once "core/classes/updatable.interface.php";

global $_CONFIGS; // common database
include_once "core/classes/common/database.class.php";
$cdatabase = new Database($_CONFIGS['CDatabase']['Server'], $_CONFIGS['CDatabase']['User'], $_CONFIGS['CDatabase']['Password'], $_CONFIGS['CDatabase']['DatabaseName']);

// Load Classes
loadClasses(array(
    'Report',
    'Database', 'Auth',
    'Message', 'User',
    'Files',
    'PersianDate',
    'Mailer', 'Event',
    'Discount', 'Pager',
    'PersonalMessage',
    'CreditLog', 'UserLevel',
    'Twitt', 'Group', 'System', 'Content'));

loadClasses($_CONFIGS['Classes'], $subSite);

function fatal_handler() {
    $errfile = "unknown file";
    $errstr = "shutdown";
    $errno = E_CORE_ERROR;
    $errline = 0;

    $error = error_get_last();

    if ($error !== NULL) {
        $errno = $error["type"];
        $errfile = $error["file"];
        $errline = $error["line"];
        $errstr = $error["message"];
    }
    switch ($errno) {
        case E_NOTICE:
        case E_USER_NOTICE:
        case E_CORE_ERROR:
            break;

        default:
            Report::addLog("Fatal Error: $errno : $errstr : $errfile : $errline");
            exit();
            break;
    }
//  error_mail( format_error( $errno, $errstr, $errfile, $errline ) );
}

function getSubSite() {
//    if (preg_match('/type\./i', $_SERVER['SERVER_NAME'])) {
//        return 'type';
//    }
//    if (preg_match('/temp\./i', $_SERVER['SERVER_NAME'])) {
//        return 'graphic';
//    }
//    if (preg_match('/translate\./i', $_SERVER['SERVER_NAME'])) {
//        return 'translate';
//    }
//    if (preg_match('/tarjomeiran\./i', $_SERVER['SERVER_NAME'])) {
//        return 'translate';
//    }
//    if (preg_match('/graphic\./i', $_SERVER['SERVER_NAME'])) {
//        return 'graphic';
//    }
//    return 'type';
    return 'translate';
}

function initHeader() {
    global $_CONFIGS;
    if ($_SERVER['HTTP_ORIGIN'] == NULL ||
            $_CONFIGS['Site']['type']['Path'] == $_SERVER['HTTP_ORIGIN'] . "/" ||
            $_CONFIGS['Site']['translate']['Path'] == $_SERVER['HTTP_ORIGIN'] . "/") {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
    }
}

?>
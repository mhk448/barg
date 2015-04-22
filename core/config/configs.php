<?php

// local change TestMode FALSE & 3 lc2ir & 2 db info & FileServer & Backupserver 
// Configurations

$GLOBALS['_CONFIGS'] = array(
    'TestMode' => FALSE,
    'domains' => '.bargardoon.com',
    'FileServerPath' => 'http://fileserver.bargardoon.com/type/',
    'BackupServerPath' => 'http://fileserver.bargardoon.com/type/',
    'Site' => array(
        'Name' => 'برگردون',
        'Path' => 'http://bargardoon.com/',
        'NickName' => 'برگردون',
        'NickPath' => 'www.bargardoon.com',
        'type' => array(
            'Name' => 'برگردون',
            'Path' => 'http://bargardoon.com/',
            'NickName' => 'برگردون',
            'NickPath' => 'www.bargardoon.com', // 'Type.Elmend.ir',
            'Email' => 'info@bargardoon.com',
            'Blog' => 'http://blog.bargardoon.com/type', //sub path without "/"
            'Forum' => 'http://forum.bargardoon.com/', //sub path
            'SMS_Postfix' => "\nwww.bargardoon.com", //"\nwww.Elmend.ir",
            'fg_color' => "#bace39",
            'bg_color' => "#bace39",
            'code' => "T",
        ),
        'translate' => array(
            'Name' => 'برگردون',
            'Path' => 'http://bargardoon.com/',
            'NickName' => 'برگردون',
            'NickPath' => 'www.Tarjomeiran.com',
            'Email' => 'info@bargardoon.com',
            'Blog' => 'http://blog.bargardoon.com/type', //sub path without "/"
            'Forum' => 'http://forum.bargardoon.com/', //sub path
            'SMS_Postfix' => "\nwww.bargardoon.com",
            'fg_color' => "#b9e2ff",
            'bg_color' => "#b9e2ff",
            'code' => "R",
        ),
        'graphic' => array(
            'Name' => 'برگردون',
            'Path' => 'http://graphic.bargardoon.com/',
            'NickName' => 'برگردون',
            'NickPath' => 'graphic.bargardoon.com',
            'Email' => 'info@graphic.bargardoon.com',
            'Blog' => 'http://blog.bargardon.net/type', //sub path without "/"
            'Forum' => 'http://forum.bargardoon.com/', //sub path
            'SMS_Postfix' => "\ngraphic.bargardoon.com",
            'fg_color' => "#b9e2ff",
            'bg_color' => "#b9e2ff",
            'code' => "G",
        ),
    ),
    // Path Informations
    'Pathes' => array(
        'Blog' => 'http://blog.bargardoon.com/',
        'Root' => 'http://bargardoon.com/',
    ),
    // Security
    'Security' => array(
        'CommandKey' => 'MHK448þì´G¹îojnÿJÑ0×d',
    ),
    //HHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHH
    // Database Informations
    'CDatabase' => array(
        'Server' => 'localhost',
        'User' => 'bargardo_user',
        'Password' => 'Wqm30Vp[B.Ks',
        'DatabaseName' => 'bargardo_common',
    ),
    // Database Informations
    'Database_type' => array(
        'Server' => 'localhost',
        'User' => 'bargardo_user',
        'Password' => 'Wqm30Vp[B.Ks',
        'DatabaseName' => 'bargardo_type',
    ),
    'Database_graphic' => array(
        'Server' => 'localhost',
        'User' => 'bargardo_user',
        'Password' => 'Wqm30Vp[B.Ks',
        'DatabaseName' => 'bargardo_type',
    ),
    'Database_translate' => array(
        'Server' => 'localhost',
        'User' => 'bargardo_user',
        'Password' => 'Wqm30Vp[B.Ks',
        'DatabaseName' => 'bargardo_translate',
    ),
    'Ftp' => array(//create backup dir in root
        'Server' => 'bargardon.xzn.ir',
        'User' => 'u820903543',
        'Password' => '12341234',
        'Path' => '/public_html/',
    ),
    // Page Informations
    'Page' => array(
        'File' => '',
        'Title' => '',
        'Header' => '',
        'Description' => '',
        'Keywords' => '',
        'Options' => array(),
    ),
    // Page Parameters
//'Params' => (isset($_GET['request'])) ? explode('_', str_replace('/IrType/', '', str_replace("-", " ", $_GET['request']))) : array('خانه'),
    'Params' => (isset($_GET['request'])) ? explode('_', str_replace('/', '', str_replace("-", " ", $_GET['request']))) : array('مرکز تخصصی '.  (isSubType()?"تایپ":"ترجمه")),
);

$_CONFIGS['subsite'] = $subSite;
$_CONFIGS['Database'] = $_CONFIGS['Database_' . $subSite];
$_CONFIGS['Site']['Sub'] = $_CONFIGS['Site'][$subSite];

if (isSubType()) {
    $_CONFIGS['Classes'] = array('Project', 'Bid');
} else if (isSubTranslate()) {
    $_CONFIGS['Classes'] = array('Project', 'Bid');
} else if (isSubGraphic()) {
    $_CONFIGS['Classes'] = array('Project', 'Bid');
}
?>
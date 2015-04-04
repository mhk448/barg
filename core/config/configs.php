<?php

// local change TestMode FALSE & 3 lc2ir & 2 db info & FileServer & Backupserver 
// Configurations

$GLOBALS['_CONFIGS'] = array(
    'TestMode' => FALSE,
    'domains' => 'bargardon.ir',
    'FileServerPath' => 'http://fileserver.bargardon.ir/type/',
    'BackupServerPath' => 'http://fileserver.bargardon.ir/type/',
    'Site' => array(
        'Name' => 'برگردون',
        'Path' => 'http://bargardon.ir/',
        'NickName' => 'برگردون',
        'NickPath' => 'www.bargardon.ir',
        'type' => array(
            'Name' => 'برگردون',
            'Path' => 'http://bargardon.ir/',
            'NickName' => 'برگردون',
            'NickPath' => 'www.bargardon.ir', // 'Type.Elmend.ir',
            'Email' => 'info@bargardon.ir',
            'Blog' => 'http://blog.bargardon.ir/type', //sub path without "/"
            'Forum' => 'http://forum.bargardon.ir/', //sub path
            'SMS_Postfix' => "\nwww.bargardon.ir", //"\nwww.Elmend.ir",
            'fg_color' => "#bace39",
            'bg_color' => "#bace39",
            'code' => "T",
        ),
        'translate' => array(
            'Name' => 'برگردون',
            'Path' => 'http://bargardon.ir/',
            'NickName' => 'برگردون',
            'NickPath' => 'www.Tarjomeiran.com',
            'Email' => 'info@bargardon.ir',
            'Blog' => 'http://blog.bargardon.ir/type', //sub path without "/"
            'Forum' => 'http://forum.bargardon.ir/', //sub path
            'SMS_Postfix' => "\nwww.bargardon.ir",
            'fg_color' => "#b9e2ff",
            'bg_color' => "#b9e2ff",
            'code' => "R",
        ),
        'graphic' => array(
            'Name' => 'برگردون',
            'Path' => 'http://graphic.bargardon.ir/',
            'NickName' => 'برگردون',
            'NickPath' => 'graphic.bargardon.ir',
            'Email' => 'info@graphic.bargardon.ir',
            'Blog' => 'http://blog.bargardon.net/type', //sub path without "/"
            'Forum' => 'http://forum.bargardon.ir/', //sub path
            'SMS_Postfix' => "\ngraphic.bargardon.ir",
            'fg_color' => "#b9e2ff",
            'bg_color' => "#b9e2ff",
            'code' => "G",
        ),
    ),
    // Path Informations
    'Pathes' => array(
        'Blog' => 'http://blog.bargardon.ir/',
        'Root' => 'http://bargardon.ir/',
    ),
    // Security
    'Security' => array(
        'CommandKey' => 'ÑëÌ°áþì´G¹îojnÿJÑ0×d',
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
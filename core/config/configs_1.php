<?php

// local change TestMode FALSE & 3 lc2ir & 2 db info & FileServer & Backupserver 
// Configurations

$GLOBALS['_CONFIGS'] = array(
    'TestMode' => TRUE,
    'domains' => 'bargardoon.com|bargardoon.com', //deprcated
    'FileServerPath' => 'http://fileserver.bargardoon.com/type/',
//    'FileServerPath' => 'http://www.bargardoon.lc/',
    'BackupServerPath' => 'http://fileserver.bargardoon.com/type/',
//    'BackupServerPath' => 'http://www.bargardoon.lc/',
    'Site' => array(
        'Name' => 'برگردون',
        'Path' => 'http://bargardoon.com/',
        'Path' => 'http://www.bargardoon.lc/',
        'NickName' => 'برگردون',
        'NickPath' => 'www.bargardoon.com',
        'type' => array(
            'Name' => 'برگردون',
            'Path' => 'http://bargardoon.com/',
            'Path' => 'http://type.bargardoon.lc/',
            'NickName' => 'برگردون',
            'NickPath' => 'www.bargardoon.com', // 'Type.bargardoon.ir',
            'Email' => 'type@bargardoon.com',
            'Blog' => 'http://blog.bargardoon.com/type', //sub path without "/"
            'Forum' => 'http://forum.bargardoon.com/', //sub path
            'SMS_Postfix' => "\nwww.bargardoon.com", //"\nwww.bargardoon.ir",
            'fg_color' => "#bace39",
            'bg_color' => "#bace39",
            'code' => "T",
            'bank' => array(
                'parspal' => array(
                    'merchant'=>'',
                    'password'=>''
                )
            ),
        ),
        'translate' => array(
            'Name' => 'برگردون',
            'Path' => 'http://bargardoon.com/',
            'Path' => 'http://translate.bargardoon.lc/',
            'NickName' => 'برگردون',
            'NickPath' => 'www.bargardoon.com',
            'Email' => 'info@bargardoon.com',
            'Blog' => 'http://blog.bargardoon.com/type', //sub path without "/"
            'Forum' => 'http://forum.bargardoon.com/', //sub path
            'SMS_Postfix' => "\nwww.bargardoon.com",
            'fg_color' => "#b9e2ff",
            'bg_color' => "#b9e2ff",
            'code' => "B",
            'bank' => array(
                'parspal' => array(
                    'merchant'=>'',
                    'password'=>''
                )
            ),
        ),
        'graphic' => array(
            'Name' => 'برگردون',
            'Path' => 'http://type.bargardoon.lc/',
            'NickName' => 'برگردون',
            'NickPath' => 'graphic.bargardoon.com',
            'Email' => 'info@graphic.bargardoon.com',
            'Blog' => 'http://blog.bargardoon.com/type', //sub path without "/"
            'Forum' => 'http://forum.bargardoon.com/', //sub path
            'SMS_Postfix' => "\ngraphic.bargardoon.com",
            'fg_color' => "#b9e2ff",
            'bg_color' => "#b9e2ff",
            'code' => "G",
            'bank' => array(
                'parspal' => array(
                    'merchant'=>'',
                    'password'=>''
                )
            ),
        ),
    ),
    // Path Informations
    'Pathes' => array(
        'Blog' => 'http://blog.bargardoon.com/',
        'Root' => 'http://bargardoon.com/', //'http://type.bargardoon.ir/'
//        'Root' => 'http://bargardoon.lc/',
    ),
    // Security
    'Security' => array(
        'CommandKey' => 'M',
    ),
    // SMS
    'SMS' => array(
        'username' => '',
        'password' => '',
        'from' => '5000290909' //from=30002592
    ),
    //HHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHH
    // Database Informations
    'CDatabase' => array(
        'Server' => 'localhost',
        'User' => 'root',
        'Password' => '',
        'DatabaseName' => 'mhk_elmend_common'
    ),
    // Database Informations
    'Database_type' => array(
        'Server' => 'localhost',
        'User' => 'root',
        'Password' => '',
        'DatabaseName' => 'mhk_elmend_type',
    ),
    'Database_translate' => array(
        'Server' => 'localhost',
        'User' => 'root',
        'Password' => '',
        'DatabaseName' => 'mhk_elmend_translate',
    ),
    'Database_graphic' => array(
        'Server' => 'localhost',
        'User' => 'root',
        'Password' => '',
        'DatabaseName' => 'mhk_elmend_translate',
    ),
    'Ftp' => array(//create backup dir in root
        'Server' => 'bargardoon.xzn.ir',
        'User' => '',
        'Password' => '',
        'Path' => '/',
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
    'Params' => (isset($_GET['request'])) ? explode('_', str_replace('/', '', str_replace("-", " ", $_GET['request']))) : array('مرکز تخصصی ' . (isSubType() ? "تایپ" : "ترجمه")),
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
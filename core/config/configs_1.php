<?php

// local change TestMode FALSE & 3 lc2ir & 2 db info & FileServer & Backupserver 
// Configurations

$GLOBALS['_CONFIGS'] = array(
    'TestMode' => TRUE,
    'domains' => 'typeiran.com|tarjomeiran.com', //deprcated
    'FileServerPath' => 'http://fileserver.typeiran.com/type/',
//    'FileServerPath' => 'http://www.elmend.lc/',
    'BackupServerPath' => 'http://fileserver.typeiran.com/type/',
//    'BackupServerPath' => 'http://www.elmend.lc/',
    'Site' => array(
        'Name' => 'تایپیران',
        'Path' => 'http://typeiran.com/',
        'Path' => 'http://www.elmend.lc/',
        'NickName' => 'تایپیران',
        'NickPath' => 'www.TypeIran.com',
        'type' => array(
            'Name' => 'تایپیران',
            'Path' => 'http://typeiran.com/',
            'Path' => 'http://type.elmend.lc/',
            'NickName' => 'تایپایران',
            'NickPath' => 'www.TypeIran.com', // 'Type.Elmend.ir',
            'Email' => 'type@typeiran.com',
            'Blog' => 'http://blog.typeiran.com/type', //sub path without "/"
            'Forum' => 'http://forum.typeiran.com/', //sub path
            'SMS_Postfix' => "\nwww.Typeiran.com", //"\nwww.Elmend.ir",
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
            'Name' => 'ترجمه‌ایران',
            'Path' => 'http://typeiran.com/',
            'Path' => 'http://translate.elmend.lc/',
            'NickName' => 'ترجمه‌ایران',
            'NickPath' => 'www.Tarjomeiran.com',
            'Email' => 'info@Tarjomeiran.com',
            'Blog' => 'http://blog.typeiran.com/type', //sub path without "/"
            'Forum' => 'http://forum.typeiran.com/', //sub path
            'SMS_Postfix' => "\nwww.Tarjomeiran.com",
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
            'Name' => 'ترجمه‌ایران',
            'Path' => 'http://type.elmend.lc/',
            'NickName' => 'ترجمه‌ایران',
            'NickPath' => 'graphic.typeiran.com',
            'Email' => 'info@graphic.typeiran.com',
            'Blog' => 'http://blog.kariran.net/type', //sub path without "/"
            'Forum' => 'http://forum.typeiran.com/', //sub path
            'SMS_Postfix' => "\ngraphic.typeiran.com",
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
        'Blog' => 'http://blog.typeiran.com/',
        'Root' => 'http://typeiran.com/', //'http://type.elmend.ir/'
//        'Root' => 'http://elmend.lc/',
    ),
    // Security
    'Security' => array(
        'CommandKey' => 'MHK448þì´G¹îojnÿJÑ0×d',
    ),
    //HHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHH
    // Database Informations
    'CDatabase' => array(
        'Server' => 'localhost',
        'User' => 'elmend_user',
        'Password' => 'GJtfzPmwWw329wxH',
        'DatabaseName' => 'elmend_common',
        ////
        'User' => 'elmend_mhk448',
        'Password' => 'M@z0?{&^JsK.',
        'DatabaseName' => 'elmend_common',
        ////
        'User' => 'hessammo_loc',
        'Password' => 'M@z0?{&^JsK.',
        'DatabaseName' => 'hessammo_common',
        ////
        'User' => 'root',
        'Password' => '',
        'DatabaseName' => 'mhk_elmend_common'
    ),
    // Database Informations
    'Database_type' => array(
        'Server' => 'localhost',
        'User' => 'elmend_user',
        'Password' => 'GJtfzPmwWw329wxH',
        'DatabaseName' => 'elmend_type',
        ////
        'User' => 'hessammo_loc',
        'Password' => 'M@z0?{&^JsK.',
        'DatabaseName' => 'hessammo_type',
        ////
        'User' => 'root',
        'Password' => '',
        'DatabaseName' => 'mhk_elmend_type',
    ),
    'Database_translate' => array(
        'Server' => 'localhost',
        'User' => 'elmend_mhk448',
        'Password' => 'M@z0?{&^JsK.',
        'DatabaseName' => 'elmend_translate',
        ////
        'User' => 'hessammo_loc',
        'Password' => 'M@z0?{&^JsK.',
        'DatabaseName' => 'hessammo_type',
        ////
        'User' => 'root',
        'Password' => '',
        'DatabaseName' => 'mhk_elmend_translate',
    ),
    'Database_graphic' => array(
        'Server' => 'localhost',
        'User' => 'elmend_mhk448',
        'Password' => 'M@z0?{&^JsK.',
        'DatabaseName' => 'elmend_translate',
        ////
        'User' => 'hessammo_loc',
        'Password' => 'M@z0?{&^JsK.',
        'DatabaseName' => 'hessammo_type',
        ////
        'User' => 'root',
        'Password' => '',
        'DatabaseName' => 'mhk_elmend_translate',
    ),
    'Ftp' => array(//create backup dir in root
        'Server' => 'typeiran.xzn.ir',
        'User' => 'u820903543',
        'Password' => '12341234',
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
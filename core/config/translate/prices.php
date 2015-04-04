<?php

/*
 * In The Name of GOD
 * @author MHK448
 * Email: MHK448@gmail.com
 * Created at: May 27, 2013 , 1:27:24 PM
 * mhkInfo:
 */

$GLOBALS['_PRICES'] = array(
    'agency' => array(
        'FA2EN' => 160,
        'EN2FA' => 90,
    ),
    'worker' => array(
        'FA2EN' => 130,
        'EN2FA' => 70,
    ),
    'user' => array(
        'FA2EN' => 100,
        'EN2FA' => 200,
    ),
    ///////////////////////
    'SMS' => 120, // sms serv price

    'P_USER' => 0.7, // fa-> beyane %
    'P_AGENCY' => 0.95, // fa-> sahm namayandegi %
//    'P_ELMEND' => 0.8, // fa-> sahm Elmend % nabayad bashe!!
    'P_TYPIST' => 0.8, // fa-> sahm typist %
    'P_REFERER' => 0.05, // fa-> sahm referer %
    'P_SMS' => 40, // fa-> mizan sood dar har sms be rial

    'LOCK_CREDITS_USER' => 0.7,
    'LOCK_CREDITS_TYPIST' => 0.7
);

function SHOW_PRICE_TABLE($type) {
    global $_PRICES;
    '<table width="100%" class="projects">
    <tr><th>زبان</th><th>قیمت </th></tr>
    <tr><td>' . 'فارسی' . '</td><td>' . $_PRICES[$type]['FA'] . '   ریال</td></tr>
    <tr><td>' . 'انگلیسی' . '</td><td>' . $_PRICES[$type]['EN'] . '   ریال</td></tr>
    <tr><td>' . 'عربی' . '</td><td>' . $_PRICES[$type]['AR'] . '   ریال</td></tr>
    <tr><td>' . 'ریاضی' . '</td><td>' . $_PRICES[$type]['MA'] . '   ریال</td></tr>
    <tr><td>' . 'جدول فارسی' . '</td><td>' . $_PRICES[$type]['TAFA'] . '   ریال</td></tr>
    <tr><td>' . 'جدول انگلیسی' . '</td><td>' . $_PRICES[$type]['TA+EN'] . '   ریال</td></tr>
    <tr><td>' . 'فارسی+انگلیسی' . '</td><td>' . $_PRICES[$type]['FA+EN'] . '   ریال</td></tr>
    <tr><td>' . 'فارسی+فرمول' . '</td><td>' . $_PRICES[$type]['FA+MA'] . '   ریال</td></tr>
    <tr><td>' . 'فارسی+عربی' . '</td><td>' . $_PRICES[$type]['FA+AR'] . '   ریال</td></tr>
    <tr><td>' . 'فارسی+جدول' . '</td><td>' . $_PRICES[$type]['TA+FA'] . '   ریال</td></tr>
</table>';
}

?>
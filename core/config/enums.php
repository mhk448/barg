<?php

/*
 * In The Name of GOD
 * @author MHK448
 * Email: MHK448@gmail.com
 * Created at: May 27, 2013 , 1:27:24 PM
 * mhkInfo:
 */

$GLOBALS['_ENUM2FA'] = array(
    // state
    'state' => array(
        'Open' => 'باز',
        'Finish' => 'پایان یافته',
        'Run' => 'درحال اجرا',
        'Close' => 'بسته شده',
        'Active' => 'فعال',
        'Inactive' => 'غیر فعال',
        'Banned' => 'مسدود',
        'FirstDay' => 'جدید',
    ),
    // type
    'type' => array(
        'Public' => 'مناقصه',
        'Private' => 'خصوصی',
        'Agency' => 'نمایندگی',
        'Referer' => 'معرفی شده',
        'Protected' => 'تضمین شده'
    ),
    // usergroup
    'usergroup' => array(
        'Both' => 'کاربر',
        'Worker' => 'مجری',
        'Admin' => 'مدیر',
        'Bookkeeper' => 'حسابدار',
        'User' => 'کارفرما',
        'Administrator' => 'مدیر فنی',
        'System' => 'کاربر سیستمی',
        'Agency' => 'نماینده'
    ),
    // level
    'level' => array(
        'student' => 'دانشجویی',
        'normal' => 'معمولی',
        'advance' => 'حرفه‌ای'
    ),
    // special_type
    'specialtype' => array(
        'None' => 'عادی',
        'Special' => 'ویژه',
        'Emploee' => 'استخدام'
    ),
    // verified
    'verified' => array(
        0 =>
        'منتظر تایید'
        , 1 =>
        'تایید شده'
        , 2 =>
        'تایید شده'
        , -1 =>
        'رد شد'
        , -2 =>
        'ویرایش شود'
        , -3 =>
        'انصراف داده شده'
    ),
    // output
    'output' => array(
        'DOCX' => '   تایپ در ورد (Word)',
        'ONLINE' => 'تایپ آنلاین',
        'XLSX' => ' ورود داده به اکسل (Excel)',
        'PPTX' => ' پاورپوینت (PowerPoint)',
        'ACCS' => ' اکسس (Access)',
        'EDIT' => ' ویرایش و صفحه آرایی',
        'WAVE' => ' فایل صوتی',
        'SRCH' => 'انجام تحقیق و مقاله',
        'CHRT' => '  رسم نمودار و چارت',
        'SPSS' => 'SPSS',
        'TEXT' => ' متن',
        'MDIA' => ' صوتی و تصویری',
        'SITE' => 'وب سایت',
        'BOOK' => 'کتاب',
        'FAST' => 'فوری',
    ),
    // payment_type
    'payment_type' => array(
        'Bank' => 'واریز نقدی',
        'Online' => 'اینترنتی',
    ),
    // ref_table credit
    'ref_table' => array(
        'sms' => 'بابت ارسال پیامک',
        'projects' => 'بابت انجام پروژه',
        'payments' => 'پرداخت وجه',
        'payouts' => 'دریافت وجه',
        'review_requests' => 'بازبینی',
//        'bargardoon' => 'سایت قدیم ',
        'groups' => ' انجام گروهی پروژه ',
    ),
    // bid_type
    'bid_type' => array(
        'Perpage' => 'هر صفحه',
        'Permin' => 'هر دقیقه',
        'Full' => 'تمام پروژه',
        'Perword' => 'هر کلمه'
    ),
    'bid_type_word' => array(
        'Perpage' => ' صفحه',
        'Permin' => ' دقیقه',
        'Full' => 'کل',
        'Perword' => 'کلمه'
    ),
    'sub' => array(
        'type' => array(
            'work' => 'تایپ',
            'work_results' => 'صفحات تایپ شده',
            'worker' => 'تایپیست',
            'workers' => 'تایپیست‌ها',
        ),
        'translate' => array(
            'work' => 'ترجمه',
            'work_results' => 'صفحات ترجمه شده',
            'worker' => 'مترجم',
            'workers' => 'مترجم‌ها',
        ),
    ),
    '' => '',
    '' => ''
);

function ENUM2FA_Event() {
    return array(
        Event::$T_PROJECT => array(
            Event::$A_SUBMIT =>
            'پروژه جدید ثبت و در انتظار تایید'
            , Event::$A_ACC =>
            'پروژه جدید تایید و آماده دریافت پیشنهاد'
            , Event::$A_EDIT =>
            'پروژه نیاز به ویرایش'
            , Event::$A_P_FINAL_FILE_RECEIVE =>
            'فایل نهایی ارسال شد'
            , Event::$A_NEED_STAKEHOLDER =>
            'در انتظار گروگذاری کارفرما'
            , Event::$A_P_CLOSE =>
            ' پروژه بسته شد'
            , Event::$A_P_PAY_FEE =>
            'دستمزد تایپیست پرداخت شد'
            , Event::$A_P_RUN =>
            'x'//removed at webservise events
            , Event::$A_CANCEL =>
            'پروژه لغو شد'
        ),
        Event::$T_BID => array(
            Event::$A_SUBMIT =>
            'پیشنهاد جدیدی ارسال شد'
            , Event::$A_ACC =>
            'مجری پروژه تعیین شد'
            , Event::$A_CANCEL =>
            'مجری از انجام پروژه انصراف داد'
        ),
    );
}

$_ENUM2FA['fa'] = $_ENUM2FA['sub'][$subSite];

if (isSubType()) {
    $_ENUM2FA['usergroup']['Worker'] = 'تایپیست';
    $_ENUM2FA['lang'] = array(
        'FA' => 'فارسی',
        'EN' => 'انگلیسی',
        'AR' => 'عربی',
        'MA' => 'فرمول(ریاضی)',
        'TAFA' => 'جدول فارسی',
        'TA+EN' => 'جدول انگلیسی',
        'FA+EN' => 'فارسی + انگلیسی',
        'FA+MA' => 'فارسی + فرمول',
        'FA+AR' => 'فارسی + عربی',
        'TA+FA' => 'فارسی + جدول',
    );
} else if (isSubTranslate()) {
    $_ENUM2FA['usergroup']['Worker'] = 'مترجم';
    $_ENUM2FA['lang'] = array(
        'EN' => 'انگلیسی',
        'FA' => 'فارسی',
        'FR' => 'فرانسه',
        'AR' => 'عربی',
        'RU' => 'روسی',
        'DE' => 'آلمانی',
        'ZH' => 'چینی',
        'TR' => 'ترکی',
        'JA' => 'ژاپنی',
        'IT' => 'ایتالیایی',
        'ES' => 'اسپانیایی',
        'CO' => 'کره ای',
        'HI' => 'هندی',
        'UR' => 'اردو',
        'NL' => 'هلندی',
        'KR' => 'کردی',
        'SV' => 'سوئدی',
        'PL' => 'لهستانی',
        'PT' => 'پرتغالی',
        'HU' => 'مجاری',
        'TA' => 'تاجیک'
    );
}
?>
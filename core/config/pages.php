<?php

$GLOBALS['_PAGES'] = array(
    'PermissionDenied' => array('common/permission-denied.php', 'عدم وجود دسترسی', 'عدم وجود دسترسی', '', '', 'All'),
    'LoginDenied' => array('common/login-denied.php', 'نیاز به ورود', 'نیاز به ورود', '', '', 'All'),
    'BadBrowser' => array('common/bad-browser.php', 'مرورگر', 'مرورگر', '', '', 'All'),
    'error' => array('common/error.php', 'خطا', 'خطا', '', '', 'All'),
    //-- user ---//

    'register' => array('common/register.php', 'ثبت نام', 'ثبت نام', '', '', 'All'),
    'user' => array('common/user.php', 'کاربر', 'کابر', '', '', 'All'),
    'success register' => array('common/success-register.php', 'ثبت نام موفق', 'ثبت نام موفق', '', '', 'All'),
    'success login' => array('common/success-login.php', 'ورود موفق', 'ورود موفق', '', '', 'Admin,Bookkeeper,System,User,Agency,Both,Worker,Unknown'),
    'success logout' => array('common/success-logout.php', 'خروج موفق', 'خروج موف', '', '', 'All'),
    'edit profile' => array('common/edit-profile.php', 'ویرایش اطلاعات کاربری', 'ویرایش اطلاعات کاربری', '', '', 'Admin,Bookkeeper,System,User,Agency,Both,Worker'),
    'edit settings' => array('common/edit-settings.php', 'ویرایش تنظیمات کاربری', 'ویرایش تنظیمات کاربری', '', '', 'Admin,Bookkeeper,System,User,Agency,Both,Worker'),
    'edit credential' => array('common/edit-credential.php', 'ویرایش مدارک', 'ویرایش مدارک', '', '', 'Admin,Both,Worker'),
    'change password' => array('common/change-password.php', 'تغییر کلمه عبور', 'تغییر کلمه عبور', '', '', 'Admin,Bookkeeper,System,User,Agency,Both,Worker'),
    'retrive password' => array('common/retrive-password.php', 'بازیابی کلمه عبور', 'بازیابی کلمه عبور', '', '', 'All'),
    //-- panel ---//
    'users' => array('common/panel.php', 'بخش کاربران', 'بخش کاربران', '', '', 'All'),
    'panel' => array('common/panel.php', 'پنل کاربری', 'پنل کاربری', '', '', 'All'),
    'user list' => array('common/user-list.php', 'لیست کاربران', 'لیست کاربران', '', '', 'All'),
    'ability' => array('common/ability.php', 'تخصص های من', 'تخصص های من', '', '', 'Admin,Bookkeeper,System,Both,Worker'),
    //-- project ---//

    'projects' => array($subSite . '/projects.php', 'لیست پروژه ها', 'لیست پروژه ها', '', '', 'All'),
    'submit project' => array($subSite . '/submit-project.php', 'ارسال پروژه جدید', 'ارسال پروژه جدید', '', '', 'Admin,Bookkeeper,System,User,Agency'),
    'project' => array('common/project.php', 'لیست پروژه ها', 'لیست پروژه ها', '', '', 'All'),
    'bids' => array('common/bids.php', 'لیست پیشنهادات شما', 'لیست پیشنهادات شما', '', '', 'Admin,Bookkeeper,System,Both,Worker'),
    'finish project' => array('common/finish-project.php', 'پایان پروژه', 'پایان پروژه', '', '', 'Admin,Bookkeeper,System,User,Agency,Both'),
    'edit project' => array('common/edit-project.php', 'ویرایش اطلاعات پروژه', 'ویرایش اطلاعات پروژه', '', '', 'Admin,Bookkeeper,System,User,Agency,Both'),
    'cancel bid' => array('common/cancel-bid.php', 'انصراف از پروژه', 'انصراف از پروژه', '', '', 'Both,Worker'),
    //-- credit ---//

    'report' => array('common/report.php', 'گزارش مالی', 'گزارش مالی', '', '', 'Admin,Bookkeeper,System,User,Agency,Both,Worker'),
    'report chart' => array('common/report-chart.php', 'گزارش مالی', 'گزارش مالی', '', '', 'Admin,Bookkeeper,System,User,Agency,Both,Worker'),
    'refer' => array('common/refer.php', 'افزایش درآمد', 'افزایش درآمد', '', '', 'Admin,System,User,Agency,Both,Worker'),
    'add credit' => array('common/add-credit.php', 'افزودن اعتبار', 'افزودن اعتبار', '', '', 'Admin,Bookkeeper,System,User,Agency,Both,Worker'),
    'accounting' => array('common/accounting.php', 'حسابرسی', 'حسابرسی', '', '', 'Admin,Bookkeeper,System,User,Agency,Both,Worker'),
//    'cart' => array('cart.php', 'خرید', 'خرید', '', '', 'All'),
    'response' => array('common/response.php', 'پاسخ بانک', 'پاسخ بانک', '', '', 'All'),
    'accept bid' => array('common/accept-bid.php', 'قبول پیشنهاد', 'قبول پیشنهاد', '', '', 'Admin,Bookkeeper,System,User,Agency,Both'),
    'stakeholdere' => array('common/stakeholdere.php', 'گروگزاری', 'گروگزاری', '', '', 'Admin,Bookkeeper,System,User,Agency,Both'),
    'earnest' => array('common/earnest.php', 'پرداخت بیعانه ', 'پرداخت بیعانه ', '', '', 'Admin,Bookkeeper,System,User,Agency,Both,Worker'),
    //-- message ---//
    'send message' => array('common/send-message.php', 'ارسال پیام', 'ارسال پیام', '', '', 'Admin,Bookkeeper,System,User,Agency,Both,Worker'),
    'messages' => array('common/messages.php', 'پیام ها', 'پیامها', '', '', 'Admin,Bookkeeper,System,User,Agency,Both,Worker'),
    'message' => array('common/message.php', 'پیام', 'پیام', '', '', 'Admin,Bookkeeper,System,User,Agency,Both,Worker'),
    'support' => array('common/support.php', 'پشتیبانی', 'پشتیبانی', '', '', 'Admin,Bookkeeper,System,User,Agency,Both,Worker'),
    'request for representative' => array('common/request-for-representative.php', 'درخواست نمایندگی', 'درخواست نمایندگی', '', '', 'All'),
    'events' => array('common/events.php', 'رخدادها', 'رخدادها', '', '', 'Admin,Bookkeeper,System,User,Agency,Both,Worker'),
    'event' => array('common/event.php', 'رخداد', 'رخداد', '', '', 'Admin,Bookkeeper,System,User,Agency,Both,Worker'),
    'review request' => array('common/review-request.php', 'درخواست بازبینی', 'درخواست بازبینی', '', '', 'Admin,Bookkeeper,System,User,Agency,Both,Worker'),
    'kart request' => array('common/kart-request.php', 'درخواست کارت بانکی', 'درخواست کارت بانکی ', '', '', 'Admin,Bookkeeper,System,User,Agency,Both,Worker'),
    'sendsms' => array('common/sendsms.php', 'ارسال پیامک', 'ارسال پیامک', '', '', 'Admin,Bookkeeper,System,User,Agency,Both,Worker'),
    'getsms' => array('common/getsms.php', ' پیامک', ' پیامک', '', '', 'All'),
    'smses' => array('common/smses.php', 'صندوق پیامک', 'صندوق پیامک', '', '', 'Admin,Bookkeeper,System,User,Agency,Both,Worker'),
    'twitt' => array('common/twitt.php', ' توییت', ' توییت ', '', '', 'All'),
    'twitts' => array('common/twitts.php', ' توییت', ' توییت ', '', '', 'All'),
    'group' => array('common/group.php', ' گروه', 'گروه', '', '', 'All'),
    'edit group' => array('common/edit-group.php', ' گروه', 'گروه', '', '', 'Admin,Bookkeeper,System,Both,Worker'),
    'group list' => array('common/group-list.php', ' گروه', 'گروه', '', '', 'All'),
    //-- manage ---//
    'manage users' => array('manage/manage-users.php', 'مدیریت کاربران', 'مدیریت کاربران', '', '', 'Admin,Bookkeeper,System'),
    'manage users online' => array('manage/manage-users-online.php', 'مدیریت کاربران', 'مدیریت کاربران', '', '', 'Admin,Bookkeeper,System'),
    'manage projects' => array('manage/manage-projects.php', 'مدیریت پروژه ها', 'مدیریت پروژه ها', '', '', 'Admin,Bookkeeper,System'),
    'manage payments' => array('manage/manage-payments.php', 'مدیریت دریافتها', 'مدیریت دریافتها', '', '', 'Admin,Bookkeeper,System'),
    'manage payouts' => array('manage/manage-payouts.php', 'مدیریت پرداختها', 'مدیریت پرداختها', '', '', 'Admin,Bookkeeper,System'),
    'manage accounting' => array('manage/manage-accounting.php', 'مدیریت مالی', 'مدیریت مالی', '', '', 'Admin,Bookkeeper,System'),
    'manage news' => array('manage/manage-news.php', 'مدیریت خبرنامه', 'مدیریت خبرنامه', '', '', 'Admin,Bookkeeper,System'),
    'manage rrequests' => array('manage/manage-rrequests.php', 'مدیریت درخواستهای نمایندگی', 'مدیریت درخواستهای نمایندگی', '', '', 'Admin,Bookkeeper,System'),
    'manage reviewrequests' => array('manage/manage-reviewrequests.php', 'مدیریت درخواستهای بازبینی', 'مدیریت درخواستهای بازبینی', '', '', 'Admin,Bookkeeper,System'),
    'manage reviewrequest' => array('manage/manage-reviewrequest.php', 'مدیریت درخواستهای بازبینی', 'مدیریت درخواستهای بازبینی', '', '', 'Admin,Bookkeeper,System'),
    'manage messages' => array('manage/manage-messages.php', 'پیامهای کاربران', 'پیامهای کاربران', '', '', 'Admin,Bookkeeper,System,Worker'),
    'manage smses' => array('manage/manage-smses.php', 'پیامکهای کاربران', 'پیامکهای کاربران', '', '', 'Admin,Bookkeeper,System,Worker'),
    'manage support' => array('manage/manage-support.php', 'درخواست های پشتیبانی ', ' درخواست های پشتیبانی', '', '', 'Admin,Bookkeeper,System,Worker'),
    'manage userlevel' => array('manage/manage-userlevel.php', 'درخواست های پشتیبانی ', ' درخواست های پشتیبانی', '', '', 'Admin,Bookkeeper,System'),
    'manage userlevel answer' => array('manage/manage-userlevel-answer.php', 'درخواست های پشتیبانی ', ' درخواست های پشتیبانی', '', '', 'Admin,Bookkeeper,System'),
    'manage content' => array('manage/manage-content.php', ' مطالب ', 'مطالب', '', '', 'Admin,Bookkeeper,System'),
    'manage contents' => array('manage/manage-contents.php', 'مطالب', '', 'مطالب', '', 'Admin,Bookkeeper,System'),
    'manage kartrequests' => array('manage/manage-kartrequests.php', 'درخواست کارت بانکی', '', 'درخواست کارت بانکی', '', 'Admin,Bookkeeper,System'),
    //-- system ---//
    'system settings' => array('manage/system-settings.php', 'تنظیمات سیستم', 'تنظیمات سیستم', '', '', 'Admin,Bookkeeper,System'),
    'system reports' => array('manage/system-reports.php', 'گزارشهای سیستمی و کاربری', 'گزارشهای سیستمی و کاربری', '', '', 'Admin,Bookkeeper,System'),
    //-- webservice ---//
    'webservice' => array('common/webservice.php', 'w', 'w', '', '', 'All'),
    'ajax pages' => array('common/ajax-pages.php', 'w', 'w', '', '', 'All'),
    //-- help ---//
    'help' => array('blog', 'راهنما', 'راهنما', '', '', 'All'),
    'about' => array('blog', 'درباره ما', 'درباره ما', '', '', 'All'),
    'contact' => array('blog', 'تماس با ما', 'تماس با ما', '', '', 'All'),
    'rules' => array('blog', 'شرایط و قوانین', 'شرایط و قوانین', '', '', 'All'),
    'faq' => array('blog', 'پرسشهای متداول', 'پرسشهای متداول', '', '', 'All'),
);

if (isSubType()) {
    $_PAGES['rules'] = array('http://blog.bargardon.ir/type/type-rols/%D8%B4%D8%B1%D8%A7%DB%8C%D8%B7-%D9%88-%D9%82%D9%88%D8%A7%D9%86%DB%8C%D9%86-%D8%A7%D8%B3%D8%AA%D9%81%D8%A7%D8%AF%D9%87-%D8%A7%D8%B2-%D8%AE%D8%AF%D9%85%D8%A7%D8%AA-%D9%85%D8%B1%DA%A9%D8%B2-%D8%AA%D8%A7/', 'شرایط و قوانین', 'شرایط و قوانین', '', '', 'All');
    $_PAGES['Home'] = array($subSite . '/home.php', 'مرکز تخصصی تایپ', 'مرکز تخصصی تایپ', '', '', 'All');
    $_PAGES['typeonline'] = array($subSite . '/typeonline.php', 'تایپ آنلاین', 'تایپ آنلاین', '', '', 'Admin,Bookkeeper,System,User,Agency,Both,Worker');
} else if (isSubTranslate()) {
    $_PAGES['Home'] = array($subSite . '/home.php', 'مرکز تخصصی ترجمه', 'مرکز تخصصی ترجمه', '', '', 'All');
} else if (isSubGraphic()) {
    $_PAGES['Home'] = array($subSite . '/home.php', 'مرکز تخصصی ترجمه', 'مرکز تخصصی ترجمه', '', '', 'All');
}
?>
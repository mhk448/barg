<?php
/* @var $user User */
$ref_id = 0;
$ref_page = 'twitt';
$maxSize = 80;
$title = "به توئیت خوش آمدید";
$description = " در این صفحه می‌توانید اطلاعات و نظرات خود را به اشتراک بگذارید.";

if (isset($_CONFIGS['Params'][1])) {
    if ($_CONFIGS['Params'][1] == 'sp' && ($user->special_type == User::$S_SPECIAL || $user->isAdmin())) {
        $ref_id = 1;
    } elseif ($_CONFIGS['Params'][1] == 'group' && is_numeric($_CONFIGS['Params'][2]) && ($user->containGroup($_CONFIGS['Params'][2]) || $user->isAdmin())) {
        $group = new Group($_CONFIGS['Params'][2]);
        $ref_page = 'group';
        $ref_id = $_CONFIGS['Params'][2];
        $title = "توئیت اختصاصی گروه " . $group->title;
    } elseif ($_CONFIGS['Params'][1] == 'projectworker' && is_numeric($_CONFIGS['Params'][2])) {
        $p = new Project($_CONFIGS['Params'][2]);
        if ($p->isSharedWorker($user->id) || $user->isAdmin()) {
            $ref_page = 'projectworker';
            $ref_id = $_CONFIGS['Params'][2];
            $title = "توئیت مجریان پروژه " . $p->title;
        }
    }
}

if (isset($_REQUEST['timg'])) {
    ?>
    انتخاب تصویر
    <hr/>
    تصویر مورد نظر خود را ارسال کنید و یا لینک آن را وارد نمایید
    <form class="form">
        <label>آپلود تصویر</label>
        <?= uploadFild('timg', '', $subSite . '/twitt', 20 * 1024 * 1024, 'x-pic'); ?>
        <br/>
        <label>لینک تصویر</label>
        <input type="text" id="imgLink" class="english" value="http://" />
    </form>
    <br/>
    <br/>
    <br/>
    <br/>
    <a class="active_btn" onclick="mhktwitt.appendImage(<?= $_REQUEST['timg'] ?>)">
        تایید
    </a>
<? } else { ?>
    <div id="content-wrapper">
        <div id="content">
            <br/><h1>..:: <?= $title ?> ::..</h1><br/>
            <h3><?= $description; ?></h3><br/><hr/>
            سایر توئیت‌ها:  
            <? if ($_CONFIGS['Params'][1] != 'sp' && ($user->special_type == User::$S_SPECIAL || $user->isAdmin())) { ?>
                <a href="/twitts_sp" class="active_btn">توئیت کاربران ویژه</a>
            <? }if ($ref_id != 0) { ?>
                <a href="/twitts" class="active_btn">توئیت عمومی</a>
            <? }if ($ref_page != 'group') { ?>
                <? $gs = $user->getGroups(); ?>
                <? foreach ($gs as $g) { ?>
                    <a href<?= '="/twitts_group_' . $g['id'] . '"'; ?> class="active_btn">
                        توئیت اختصاصی گروه
                        <?= $g['title']; ?></a>
                    <? } ?>
            <? } ?>
            <hr/>
            <br/>
            <div style="width: 500px;">
                <? echo $twitt->display($ref_page, $ref_id, $maxSize); ?>
            </div>
            <br/>
            <img src="medias/images/icons/loading2.gif" width="32" height="32">
        </div>
    </div>
<? } ?>

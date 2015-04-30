<?php
$p = $project->getOfGui();

/* @var $message Message */


$subj[] = 'عمومی';
$subj[] = 'اسناد تجاری';
$subj[] = 'اقتصاد و حسابداری';
$subj[] = 'سینما و زیرنویس فیلم';
$subj[] = 'مدیریت و بازرگانی';
$subj[] = 'فیزیک';
$subj[] = 'ریاضی';
$subj[] = 'زمین شناسی، معدن و جغرافیا';
$subj[] = 'شیمی';
$subj[] = 'زیست شناسی';
$subj[] = 'برق و الکترونیک';
$subj[] = 'عمران و سازه';
$subj[] = 'روان شناسی و علوم تربیتی';
$subj[] = 'تاریخ';
$subj[] = 'سیاسی و علوم اجتماعی';
$subj[] = 'فقه و علوم اسلامی';
$subj[] = 'فلسفه';
$subj[] = 'پتروشیمی و نفت';
$subj[] = 'کشاورزی و زراعت';
$subj[] = 'معماری';
$subj[] = 'صنایع غذایی';
$subj[] = 'پزشکی ';
$subj[] = 'پرستاری و علوم آزمایشگاهی';
$subj[] = 'هنر';
$subj[] = 'مکانیک';
$subj[] = 'کامپیوتر و آی تی';
$subj[] = 'سایر';


$v = $auth->validate('SubmitProjectForm', array(
        ));
if ($v) {
    $pid = $project->submit();

    if ($pid) {
        $_CONFIGS['Params'][1] = $pid;
        include 'core/pages/common/earnest.php';
        exit;
    }
}
?>

<script  type="text/javascript" >
<?
global $_PRICES;
if ($user->isAgency()) {
    echo 'var prices=' . json_encode($_PRICES['agency']) . ';';
} else {
    echo 'var prices=' . json_encode($_PRICES['user']) . ';';
}
echo 'percent=' . $_PRICES['P_USER'] . ';';
echo 'var agencyForm=' . ($user->isAgency() ? 'true' : 'false') . ';';
?>
</script>
<script  type="text/javascript" src="/medias/scripts/translate/submit_project.js?v=2">
</script>
<style>
    .submit_project .advance{
        display: none;
    }
    input.advance,
    select.advance,
    textarea.advance{
        background-color: #babaff;
    }
</style>

<div id="content-wrapper">
    <div id="content" class="submit_project" >
        <?php $message->display() ?>
        <? include 'submit-project-body.php'; ?>
    </div>
</div>
<?

$_CONFIGS['Params'][1] = "all";
$_CONFIGS['Params'][2] = $user->id;
include 'projects.php';

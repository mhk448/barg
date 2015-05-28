<?php
/*
 * In The Name of GOD
 * @author MHK448
 * Email: MHK448@gmail.com
 * Created at: Jun 4, 2013 , 10:02:08 AM
 * mhkInfo:
 */
$p = $pager->getParamById('projects');
$project = new Project($p['id']);

if ($p['stakeholdered'] == 1) {
    include 'success-submit.php';
    exit;
}
if ($p['type'] == 'Agency') {
//    $message->addMessage('پروژه شما ثبت شد');
    include 'success-submit.php';
    exit;
}
if ($p['selection_method'] == 'li' && !$p['typist_id'] && $p['type'] == 'Public') {
    $message->addMessage('منتظر پیشنهادات '.$_ENUM2FA['fa']['workers'].' بمانید ');
    include 'success-submit.php';
    exit;
}
//if (!$p['lock_price']) {// monaghese
//    include 'success-submit.php';
//    exit;
//}
if ($p['state'] == "Run" && $p['stakeholdered'] == 0 && $user->getCredit() >= $p['lock_price']) {
    if ($project->setStakeholder()) {
        ?>
        گروگذاری با موفقیت ثبت شد.
        <br/>
        <br/>
        <a href<?= '="project_'.$p['id'].'"';?> class="ajax active_btn">
تایید
        </a>
        <?
    }
//    include 'project.php';
    exit;
}

if ($user->getCredit() >= $p['lock_price']) {
    include 'core/pages/'.$subSite.'/project.php';
    exit;
}

if(isset($_CONFIGS['Params'][2])&& $_CONFIGS['Params'][2] =="PA"){//payed stackhohder but not admin acc yet
//    include 'project.php';
    header('Location: project_'.$project->id);
    exit;
}

$ajax = isset($_REQUEST['ajax']) ? "&ajax=1" : "";
header('Location: add-credit?need_p=' . $project->lock_price .'&sq=earnest_'.$project->id.'_PA'. $ajax);
exit;
?>
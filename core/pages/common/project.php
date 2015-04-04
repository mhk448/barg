<?php
//if (isset($_CONFIGS['Params'][1]) && is_numeric($_CONFIGS['Params'][1])) {
//    while ($_CONFIGS['Params'][1] > 1100) // nc? temp
//        $_CONFIGS['Params'][1] = $_CONFIGS['Params'][1] - 1100;
//}

$p0 = $pager->getParamById('projects', FALSE);


if (!$p0)
    header('Location: projects_finish');

$project = new Project($p0['id']);

//////////// ether pad ///////////
if (isset($_REQUEST['share_pad'])) {
    displaySharePad($project);
    return;
}

if ($project->verified == Event::$V_DELETE) {
    $message->addError('این پروژه حذف شده است');
} elseif ($project->verified == Event::$V_NEED_EDIT) {
    $message->addError('این پروژه نیاز به ویرایش دارد');
}

if ($project->output == 'ONLINE' && isset($_REQUEST['start'])) {
    header('Location: typeonline_' . $project->id);
    exit;
}

$pre_include = 'core/pages/' . $subSite . '/';
include $pre_include . 'project.php';

if ($user->isAdmin()) {
    include 'project-sender.php';
    include 'project-worker.php';
    showReviewRequests($project);
    showMessages($project);
    showTwitt($project);
} elseif ($project->user_id == $user->id) {
    include 'project-sender.php';
    showReviewRequests($project);
    showMessages($project);
    showTwitt($project);
} elseif ($project->verified == Event::$V_DELETE || $project->verified == Event::$V_NEED_EDIT) {
    showProjectInfo();
    $message->display();
} elseif (isset($_REQUEST["showBidForm"])) {
    include 'project-worker.php';
} elseif (isset($_REQUEST["showFinalForm"])) {
    include 'project-worker.php';
} elseif (isset($_REQUEST["showAddGroupForm"])) {
    include 'project-worker.php';
} elseif (isset($_REQUEST["showShareForm"])) {
    include 'project-worker.php';
} elseif (isset($_REQUEST["showGroupFileForm"])) {
    include 'project-worker.php';
} elseif (isset($_REQUEST["showCreditGroupForm"])) {
    include 'project-worker.php';
} else if ($user->isWorker()) {
    include 'project-worker.php';
    if (isCurrentWorker()) {
        showReviewRequests($project);
        showMessages($project);
    }
    showTwitt($project);
} else {
    ?>
    <div id="content-wrapper">
        <div id="content">

            <?= showProjectInfo(); ?>
            <div class="clear"></div>
            <?php $message->display() ?>        
            <?php if (!$user->isSignin()) { ?>
                <div class="info-box">
                    <a href<?= '="ajax-pages?page=fastreg&afterlink=project_' . $project->id . '"' ?> class="popup">
                        <img src="medias/images/theme/download1.png" />
                        ورود
                    </a>
                    <div >
                        جهت ارسال پیشنهاد انجام کار ابتدا وارد شوید
                    </div>
                </div>
            <?php } ?>
            <?
            showVisitor($project);
            showBiders($project);
            showTwitt($project);
            ?>
        </div>
    </div>

    <?
}

//
//
// ------------ isCurrentWorker -----------------
//
//
function isCurrentWorker() {
    global $user, $project;
    if ($project->id == 1)
        return TRUE;
    if ($user->isAdmin())
        return TRUE;
    if ($project->typist_id == $user->id)
        return TRUE;
    if ($project->isSharedWorker($user->id))
        return TRUE;
    return FALSE;
}

//
//
// ------------ showMessages -----------------
//
//
function showMessages($p) {
    global $_ENUM2FA, $pager, $user, $persiandate, $_CONFIGS;
    $adm = 'verified>=0 AND is_support = 0 And ';
    $adm .= isCurrentWorker() ? ' ' : (' ( from_id=' . $user->id . ' OR to_id=' . $user->id . ') And ');
    if ($user->isAdmin())
        $adm = '';
    if (!$p->id) {
        return FALSE;
    }
    $msglist = $pager->getComList('messages', '*', 'WHERE ' . $adm . ' project_id =' . $p->id, 'ORDER BY dateline DESC');
//    $msglist = $pager->getComList('messages', '*', 'WHERE 1 ', 'ORDER BY dateline DESC');
    ?>
    <div class="info-box1">
        <?
        if ($msglist)
            foreach ($msglist as $m0) {
                ?>
                <div class="" style="display:inline-block;width: 93%;border: 1px dotted #000;padding: 10px;margin: 5px;">
                    <div class="bg-theme" style="padding: 3px;margin: -5px">


                        <div style="float: left;"> 
                            <?php echo $persiandate->displayDate($m0['dateline']) ?>
                        </div>

                        <? if ($m0['from_id'] != $user->id) { ?>
                            <img class="user-avator" style="float: right;margin: 5px;" src<?= '="' . $_CONFIGS['Site']['Path'] . 'user/avatar/UA_' . $m0['from_id'] . '.png"' ?> width="40" height="40" >
                            <div style="float: right;"> 
                                از طرف: 
                                <br>
                                <a href="user_<?= $m0['from_id'] ?>" style="color: green;" class="popup" target="_blank">
                                    <?php echo $user->getNickname($m0['from_id']) ?>    
                                </a>
                            </div>
                        <? } ?>
                        <? if ($m0['to_id'] != $user->id) { ?>
                            <img class="user-avator" style="float: right;margin: 5px;" src<?= '="' . $_CONFIGS['Site']['Path'] . 'user/avatar/UA_' . $m0['to_id'] . '.png"' ?> width="40" height="40" >
                            <div style="float: right;"> 
                                به: 
                                <br>
                                <a href="user_<?= $m0['to_id'] ?>" style="color: green;" class="popup" target="_blank">
                                    <?php echo $user->getNickname($m0['to_id']) ?>    
                                </a>
                            </div>
                        <? } ?>
                        <h1>
                            <a href<?= '="message_' . $m0['id'] . '"'; ?>>
                                <?php echo $m0['title'] ?>
                            </a>
                        </h1>
                        <div class="clear"></div>
                    </div>
                    <!--<hr/>-->

                    <p style="text-align: justify;padding: 20px;">
                        <?php echo nl2br($m0['body']) ?>
                    </p>

                    <div class="bg-theme" style="padding: 3px;margin: -5px;text-align: right">
                        <?php if ($m0['attached_file'] != '') { ?>
                            <b>فایل ضمیمه :‌ </b> 
                            <a href="uploads/message/<?php echo $m0['attached_file'] ?>">دانلود</a> 
                            <?php
                        }
                        ?>

                    </div>
                    <div class="clear"></div>
                </div>
                <br>
                <hr>

            <? } ?>
    </div>
    <?
}

//
//
// ------------ displaySharePad -----------------
//
//
function displaySharePad($project) {
    global $user;
    if (isCurrentWorker() || $project->user_id == $user->id || $user->isAdmin()) {
        echo '<html><head></head><body style="margin:0;padding:0;">'
        . '<iframe id="myFrame" style="direction:rtl;width:100%;border:none;margin:0;padding:0;height: 100%" name="embed_readwrite" '
        . 'src="https://pad.lqdn.fr/p/DFX34' . $project->id . '675?showControls=true&showChat=true&showLineNumbers=true&useMonospaceFont=true&alwaysShowChat=true&lang=fa&rtl=true&userName=' . urlencode($user->getNickname()) . '" ></iframe>'
        . '</body></html>';
    }
}

//
//
// ------------ showTwitt -----------------
//
//
function showTwitt($p) {
    global $twitt;
    ?>
    <br/>
    <h3>
        نظرات خود را در مورد پروژه «
        <?= $p->title ?>
        » به صورت عمومی به اشتراک بگذارید
    </h3>
    <hr/>
    <br/>
    <div style="width: 500px;">
        <? echo $twitt->display('project', $p->id, 50); ?>
    </div>
    <br/>
    <!--<img src="medias/images/icons/loading2.gif" width="32" height="32">-->
    <?
}

//
//
// ------------ showBiders -----------------
//
//
function showBiders($p) {
    global $bid;
    $ulist = $bid->getProjectBids($p);
    $vis = '';
    foreach ($ulist as $row) {
        $u = new User($row['user_id']);
        $vis.=$u->displayAvator();
    }
    if ($vis)
        echo '<div class="info-box">کاربرانی که پیشنهاد ارسال کرده اند<br/>' . $vis . '</div>';
}

function showVisitor($p) {
    return;
    global $pager, $user;
    $ulist = $pager->getList('user_visit', '*', " where page = 'project_" . $p->id . "'", ' ORDER BY date DESC', '', 1000);
    $v = array();
    $user_visite = '';
    foreach ($ulist as $row) {
        if (!isset($v['u' . $row['user_id']]) && $row['user_id'] > 100) {
            $v['u' . $row['user_id']] = 1;
            $u = new User($row['user_id']);
            $user_visite.=$u->displayAvator(FALSE, TRUE);
        }
    }
    if ($user_visite)
        echo '<div class="info-box">کاربرانی که این پروژه را مشاهده کرده اند<br/>' . $user_visite . '</div>';
}

function showReviewRequests($prj) {
    global $user, $pager, $database, $persiandate;

    $list = $pager->getList('review_requests', '*', $database->whereId($prj->id, 'project_id'), ' ORDER BY dateline DESC', 'body');
    foreach ($list as $row) {
        if ($row['user_id'] == $user->id || $user->isAdmin()) {
            ?>
            <table width="100%" class="projects">
                <tr>
                    <th>مشخصات</th>
                    <th>متن و توضیح</th>
                    <th>تاریخ</th>
                </tr>
                <tr class="">
                    <td>
                        شاکی:
                        <?= $user->getNickname($row['user_id']) ?><hr/>
                        کارفرما:
                        <a target="_blank" href<?= '="user_' . $prj->user_id . '?refta=review_requests&refid=' . $row['id'] . '&com=بابت درخواست بازبینی پروژه ' . $prj->title . '"' ?>>
                            <?= $user->getNickname($prj->user_id) ?></a><hr/>
                        مجری:
                        <a target="_blank" href<?= '="user_' . $prj->typist_id . '?refta=review_requests&refid=' . $row['id'] . '&com=بابت درخواست بازبینی پروژه ' . $prj->title . '"' ?>>
                            <?= $user->getNickname($prj->typist_id) ?></a><hr/>
                    </td>
                    <td><?php echo nl2br($row['body']) ?></td>
                    <td width="105"><?php echo $persiandate->displayDate($row['dateline']) ?></td>
                </tr>
            </table>
        <? } ?>
    <? } ?>
<? } ?>

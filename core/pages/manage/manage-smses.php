<?php
if (isset($_REQUEST['setverified'])) {
    $id = (int) $_REQUEST['id'];
    $v = (int) $_REQUEST['v'];
//    if ($personalmessage->setVerified($id, $v)) {
//        $message->displayMessage("انجام شد");
//    } else {
//        $message->displayError("خطا");
//    }
    exit;
}

$where = "WHERE ";
if (isset($_REQUEST['new']))
    $where = 'WHERE verified=0 AND ';

$u = FALSE;
if (isset($_CONFIGS['Params'][1]) && is_numeric($_CONFIGS['Params'][1])) {
    $u = $pager->getComParamById('users');
    $list = $pager->getComList('sms', '*', $where . ' sender=' . $u['id'] . ' OR receiver=' . $u['id'], 'ORDER BY dateline DESC', 'message');
} else {
    $list = $pager->getComList('sms', '*', $where . ' sender<>' . User::$SMS, 'ORDER BY dateline DESC', 'message');
}
?>
<div id="content-wrapper">
    <div id="content">
        <? if (!$u) { ?>
            <h1>نمایش پیامک های کاربر : <?= $user->getNickname($u['id']); ?></h1>
        <? } else { ?>
            <h1>نمایش  پیامک های کاربران</h1>
        <? } ?>
        <br>
        <?= $pager->showSearchBox(); ?>
        <table width="100%" class="projects">
            <tr>
                <th>شناسه</th>
                <th>از طرف</th>
                <th>به</th>
                <th>متن پیام</th>
                <th>تاریخ</th>
                <th>عملیات</th>
            </tr>
            <?php
            $i = 0;
            foreach ($list as $row) {
                ?>
                <tr class="">
                    <td><?php echo $row['id'] ?></td>
                    <td><a href="user_<?php echo $row['sender'] ?>" target="_blank"><?= $user->getNickname($row['sender']) ?></a></td>
                    <td><a href="user_<?php echo $row['receiver'] ?>" target="_blank"><?= $user->getNickname($row['receiver']) ?></a></td>
                    <td><?php echo nl2br($row['message']) ?></td>
                    <td><?php echo $persiandate->displayDate($row['dateline']) ?></td>
                    <td width="60">
                        <? if ($row['verified'] != Event::$V_ACC) { ?>
                            <a class="popup inline" href="manage-smses?id=<?php echo $row['id'] ?>&v=1&setverified=1"><img src="medias/images/icons/tick.png" align="absmiddle" />تایید</a><br/>
                        <? } if ($row['verified'] != Event::$V_DELETE) { ?>
                            <a class="popup inline" href="manage-smses?id=<?php echo $row['id'] ?>&v=-1&setverified=1"><img src="medias/images/icons/cross.png" align="absmiddle" />حذف</a><br/>
                        <? } if ($row['verified'] != Event::$V_NONE) { ?>
                            <a class="popup inline" href="manage-smses?id=<?php echo $row['id'] ?>&v=0&setverified=1"><img src="medias/images/icons/support.png" align="absmiddle" />جاری</a><br/>
                            <? } ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <?= $pager->pageBreaker(); ?>
    </div>
</div>

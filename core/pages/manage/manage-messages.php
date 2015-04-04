<?php
if (isset($_REQUEST['setverified'])) {
    $id = (int) $_REQUEST['id'];
    $v = (int) $_REQUEST['v'];
    $message->conditionDisplay($personalmessage->setVerified($id, $v));
    exit;
}

//if(!$user->hasFeature(User::$F_SUPPORT))
if(!$user->isAdmin())
    return;

$where = "WHERE ";
if (isset($_REQUEST['new']))
    $where = 'WHERE verified=0 AND ';

$u = FALSE;
if (isset($_CONFIGS['Params'][1])) {
    $u = $pager->getComParamById('users');
    $list = $pager->getComList('messages', '*', $where . 'from_id=' . $u['id'] . ' OR to_id=' . $u['id'], 'ORDER BY dateline DESC', 'body');
} else {
    $list = $pager->getComList('messages', '*', $where . 'is_support =0 AND from_id<>' . User::$SUPORT, 'ORDER BY dateline DESC', 'body');
}
?>
<div id="content-wrapper">
    <div id="content">
        <? if ($u) { ?>
            <h1>نمایش پیامهای کاربر : <?= $user->getNickname($u['id']); ?></h1>
        <? } else { ?>
            <h1>نمایش  پیام های کاربران</h1>
        <? } ?>
        <br>
        <?= $pager->showSearchBox(); ?>
        <table width="100%" class="projects">
            <tr>
                <th>شناسه</th>
                <th>از طرف</th>
                <th>به</th>
                <th>عنوان</th>
                <th>متن پیام</th>
                <th>تاریخ</th>
                <th>ضمیمه</th>
                <th>عملیات</th>
            </tr>
            <?php
            $i = 0;
            foreach ($list as $row) {
                ?>
                <tr class="">
                    <td><?php echo $row['id'] ?></td>
                    <td><a href="user_<?php echo $row['from_id'] ?>" target="_blank"><?= $user->getNickname($row['from_id']) ?></a></td>
                    <td><a href="user_<?php echo $row['to_id'] ?>" target="_blank"><?= $user->getNickname($row['to_id']) ?></a></td>
                    <td><a class="popup" href="message_<?php
            echo $row['id'];
            if ($row['is_support'])
                echo '_S' . $row['is_support'];
                ?>"><?php if ($row['is_support']) { ?><img src="medias/images/icons/support.png" align="absmiddle" /> <?php } ?><?php if ($row['readed'] == 0) echo '<b>'; ?><?php echo $row['title'] ?><?php if ($row['readed'] == 0) echo '</b>'; ?></a></td>
                    <td><?php echo nl2br($row['body']) ?></td>
                    <td><?php echo $persiandate->displayDate($row['dateline']) ?></td>
                    <td>
                        <?php if ($row['attached_file'] != '') { ?>
                            <a href="uploads/message/<?php echo $row['attached_file'] ?>
                               ">دانلود</a> 
                               <?php
                           } else {
                               echo '-';
                           }
                           ?>
                    </td>
                    <td width="60">
                        <a class="popup" href="message_<?php echo $row['id'] ?>_S1"><img src="medias/images/icons/bid.png" align="absmiddle" />مشاهده</a><br/>
                        <? if ($row['verified'] != Event::$V_ACC) { ?>
                            <a class="popup inline" href="manage-messages?id=<?php echo $row['id'] ?>&v=1&setverified=1"><img src="medias/images/icons/tick.png" align="absmiddle" />تایید</a><br/>
                        <? } if ($row['verified'] != Event::$V_DELETE) { ?>
                            <a class="popup inline" href="manage-messages?id=<?php echo $row['id'] ?>&v=-1&setverified=1"><img src="medias/images/icons/cross.png" align="absmiddle" />حذف</a><br/>
                        <? } if ($row['verified'] != Event::$V_NONE) { ?>
                            <a class="popup inline" href="manage-messages?id=<?php echo $row['id'] ?>&v=0&setverified=1"><img src="medias/images/icons/support.png" align="absmiddle" />جاری</a><br/>
                            <? } ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <?= $pager->pageBreaker(); ?>
    </div>
</div>

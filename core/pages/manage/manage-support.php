<?php
if (!$user->isAdmin() && !$user->hasFeature(User::$F_SUPPORT))
    return;

$where = '';
if (isset($_REQUEST['new']))
    $where = ' AND verified=0 ';

//if (!$user->isAdmin())
//    $where = ' AND verified=-2 ';

$list = $pager->getComList('messages', '*', ' where is_support > 0 ' . $where, ' ORDER BY dateline DESC', 'title');

$fa[1] = 'سایر';
$fa[2] = 'راهنمایی';
$fa[3] = 'پروژه';
$fa[4] = 'فنی';
$fa[5] = 'مالی';
?>
<div id="content-wrapper">
    <div id="content">
        <h1>درخواستهای پشتیبانی</h1>
        <br>
        <?= $pager->showSearchBox(); ?>
        <table width="100%" class="projects">
            <tr>
                <th>شناسه</th>
                <th>توضیح</th>
                <th style="width: 80px">عملیات</th>
            </tr>
            <?php
            $i = 0;
            foreach ($list as $row) {
                ?>
                <tr class="">
                    <td style="background-color: <?= $_CONFIGS['Site'][($row['subsite'])]['bg_color'] ?>"><?php echo $row['id'] ?>
                        <br><?php echo $fa[$row['is_support']] ?>
                        <br><a href="user_<?php echo $row['from_id'] ?>" target="_blank"><?= $user->getNickname($row['from_id']) ?></a>
                        <br><a  target="_blank" class="" href<?= $row['subsite'] == $subSite ? "" : "2" ?>="message_<?php echo $row['id'] ?>"><?php if ($row['readed'] == 0) echo '<b>'; ?><?php echo $row['title'] ?><?php if ($row['readed'] == 0) echo '</b>'; ?></a></td>
                    <td><?php echo nl2br($row['body']) ?></td>

                    <td>
                        <?php echo $persiandate->displayDate($row['dateline']) ?><br/>
                        <a class="" target="_blank" href<?= $row['subsite'] == $subSite ? "" : "2" ?>="message_<?php echo $row['id'] ?>_S1"><img src="medias/images/icons/bid.png" align="absmiddle" />پاسخ</a><br/>
                        <? if ($row['verified'] != Event::$V_ACC) { ?>
                            <a class="popup inline" href="manage-messages?id=<?php echo $row['id'] ?>&v=1&setverified=1"><img src="medias/images/icons/tick.png" align="absmiddle" />برطرف شد</a><br/>
                        <? }if ($row['verified'] != Event::$V_DELETE) { ?>
                            <a class="popup inline" href="manage-messages?id=<?php echo $row['id'] ?>&v=-1&setverified=1"><img src="medias/images/icons/cross.png" align="absmiddle" />حذف</a><br/>
                        <? }if ($row['verified'] != Event::$V_NONE) { ?>
                            <a class="popup inline" href="manage-messages?id=<?php echo $row['id'] ?>&v=0&setverified=1"><img src="medias/images/icons/support.png" align="absmiddle" />جاری</a><br/>
                            <? }if ($row['verified'] != Event::$V_NEED_EDIT) { ?>
                            <!--<a class="popup inline" href="manage-messages?id=<?php echo $row['id'] ?>&v=0&setverified=2"><img src="medias/images/icons/support.png" align="absmiddle" />جاری</a><br/>-->
                        <? } ?>
                        <br>
                        <?php
                        if ($row['attached_file'] != '') {
                            ?>
                            <a href="uploads/message/<?php echo $row['attached_file'] ?>">دانلود</a> <?php
                } else {
                    echo '-';
                }
                        ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <?= $pager->pageBreaker(); ?>
    </div>
</div>

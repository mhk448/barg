<?php
$list = $pager->getComList('messages', '*', ' where (from_id=' . $user->id . ' OR to_id=' . $user->id . ') AND is_support >0 ', ' ORDER BY dateline DESC', 'title');
?>
<div id="content-wrapper">
    <div id="content">
        <h1>درخواستهای پشتیبانی [ <a href="send-message_1_S1">ارسال درخواست جدید</a> ]</h1>
        <br>
        <?= $pager->showSearchBox(); ?>
        <table width="100%" class="projects">
            <tr>
                <th>شناسه</th>
                <th>از طرف</th>
                <th>به</th>
                <th>عنوان</th>
                <th>تاریخ</th>
                <th>ضمیمه</th>
                <th width="200">عملیات</th>
            </tr>
            <?php
            $i = 0;
            foreach ($list as $row) {
                if ($row['is_support']) {
                    if ($row['from_id'] == $user->id)
                        $row['to_id'] = User::$SUPORT;
                    if ($row['to_id'] == $user->id)
                        $row['from_id'] = User::$SUPORT;
                }
                ?>
                <tr class="">
                    <td><?php echo $row['id'] ?></td>
                    <td><a href="user_<?php echo $row['from_id'] ?>" target="_blank"><?= $user->getNickname($row['from_id']) ?></a></td>
                    <td><a href="user_<?php echo $row['to_id'] ?>" target="_blank"><?= $user->getNickname($row['to_id']) ?></a></td>
                    <td><a href="message_<?php echo $row['id'] ?>"><?php if ($row['readed'] == 0) echo '<b>'; ?><?php echo $row['title'] ?><?php if ($row['readed'] == 0) echo '</b>'; ?></a></td>
                    <td><?php echo $persiandate->displayDate($row['dateline']) ?></td>
                    <td><?php if ($row['attached_file'] != '') { ?><a href="uploads/message/<?php echo $row['attached_file'] ?>">دانلود</a> <?php
            } else {
                echo '-';
            }
                ?></td>
                    <td width="120">
                        <a href="message_<?php echo $row['id'] ?>_S1"><img src="medias/images/icons/view.png" align="absmiddle" /> مشاهده / ارسال پاسخ</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <?= $pager->pageBreaker(); ?>
    </div>
</div>

<?php
$folder = '  to_id=' . (int) $user->id . ' ';
$title = "پیام های دریافتی";
$isInbox = TRUE;
if (isset($_CONFIGS['Params'][1])) {
    switch ($_CONFIGS['Params'][1]) {
        case 'inbox':
            $folder = '  to_id=' . (int) $user->id . ' ';
            $title = "پیام های دریافتی";
            break;
        case 'sent':
            $folder = ' from_id=' . (int) $user->id . ' ';
            $title = "پیام های ارسال شده";
            $isInbox = FALSE;
            break;
    }
}
$list = $pager->getComList('messages', '*', 'WHERE verified>=0 AND ' . $folder, ' ORDER BY dateline DESC', 'title');
?>
<div id="content-wrapper">
    <div id="content">
        <h1><?= $title ?></h1>
        <br>
        <table width="100%" class="projects">
            <thead>
                <tr>
                    <th>ردیف</th>
                    <? if ($isInbox) { ?>
                        <th>از طرف</th>
                    <? } else { ?>
                        <th>به</th>
                    <? } ?>
                    <th>عنوان</th>
                    <th width="120px">تاریخ</th>
                    <th>ضمیمه</th>
                    <th width="">عملیات</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($list as $row) {
                    ?>
                    <tr class="">
                        <td><?php echo $i++ ?></td>
                        <? if ($isInbox) { ?>
                            <td><a <?= 'href2="user_' . $row['from_id'] . '"' ?> target="_blank"><?= $user->getNickname($row['from_id']) ?></a></td>
                        <? } else { ?>
                            <td><a <?= 'href2="user_' . $row['to_id'] . '"' ?> target="_blank"><?= $user->getNickname($row['to_id']) ?></a></td>
                        <? } ?>
                        <td>
                            <a <?= 'href="message_' . $row['id'] . (($row['is_support']) ? ('_S' . $row['is_support']) : '') . '"' ?>>
                                <?php if ($row['is_support']) { ?><img src="medias/images/icons/support.png" align="absmiddle" /> <?php } ?><?php if ($row['readed'] == 0) echo '<b>'; ?><?php echo $row['title'] ?><?php if ($row['readed'] == 0) echo '</b>'; ?></a></td>
                        <td><?php echo $persiandate->displayDate($row['dateline']) ?></td>
                        <td><?php if ($row['attached_file'] != '') { ?>
                                <a <?= 'href="uploads/message/' . $row['attached_file'] . '"' ?>>
                                    دانلود
                                </a> 
                                <?
                            } else {
                                echo '-';
                            }
                            ?>
                        </td>
                        <td width="120">
                            <a <?= 'href="message_' . $row['id'] . (($row['is_support']) ? ('_S' . $row['is_support']) : '') . '"' ?>>
                                <img src="medias/images/icons/view.png" align="absmiddle" />
                                مشاهده / ارسال پاسخ
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?= $pager->pageBreaker(); ?>
    </div>
</div>

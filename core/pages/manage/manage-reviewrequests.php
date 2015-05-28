<?php
if (isset($_REQUEST['delete'])) {
    $id = (int) $_REQUEST['id'];
    if ($database->runQuery('UPDATE review_requests SET readed = -1 WHERE id = ' . $id)) {
        $message->displayMessage("انجام شد");
    } else {
        $message->displayError("خطا");
    }
    exit;
}

if (isset($_REQUEST['new'])) {
    $where = 'where readed<>-1';
} else {
    $where = '';
}

$list = $pager->getList('review_requests', '*', $where, ' ORDER BY dateline DESC', 'body');
?>
<div id="content-wrapper">
    <div id="content">
        <h1>مدیریت درخواستهای شکایت</h1>
        <br>
        <?= $pager->showSearchBox("جستجو در متن پیام"); ?>
        <table width="100%" class="projects">
            <tr>
                <th>شناسه</th>
                <th>مشخصات</th>
                <th>پروژه</th>
                <!--<th>فایل نهایی</th>-->
                <th>متن و توضیح</th>
                <th>تاریخ</th>
                <th>عملیات</th>
            </tr>
            <?php
            $i = 0;
            foreach ($list as $row) {
                ?>
                <?php $prj = new Project((int) $row['project_id']); ?>
                <tr class="">
                    <td><?php echo $row['id'] ?></td>
                    <td>
                        فرستنده:
                        <?= $user->getNickname($row['user_id']) ?><hr/>
                        کارفرما:
                        <a target="_blank" href<?= '="user_' . $prj->user_id . '?refta=review_requests&refid=' . $row['id'] . '&com=بابت درخواست بازبینی پروژه ' . $prj->title . '"' ?>>
                            <?= $user->getNickname($prj->user_id) ?></a><hr/>
                        مجری:
                        <a target="_blank" href<?= '="user_' . $prj->typist_id . '?refta=review_requests&refid=' . $row['id'] . '&com=بابت درخواست بازبینی پروژه ' . $prj->title . '"' ?>>
                            <?= $user->getNickname($prj->typist_id) ?></a><hr/>
                    </td>
                    <td>
                        <a href<?= '="project_' . $row['project_id'] . '"' ?> style="display:block"><?= $prj->title ?></a>
                    </td>
                    <!--<td>-->
                    <?php
//                        $ff = $prj->getFinalFile();
//                        if (isset($ff['pages']))
//                            echo '<a href="uploads/'.$subSite.'/final/' . $ff['final_file'] . '">دانلود</a><br> تعداد صفحات: ' . $ff['pages'];
                    ?>
                    <!--</td>-->
                    <td><?php echo nl2br($row['body']) ?></td>
                    <td width="105"><?php echo $persiandate->displayDate($row['dateline']) ?></td>
                    <td width="60px">
                        <a href<?= '="project_' . $row['project_id'] . '"'; ?> class="" target="_blank"><img src="medias/images/icons/view.png" align="absmiddle" /> پروژه</a>
                        <br/>
                        <a href<?= '="manage-reviewrequest_' . $row['id'] . '"'; ?> class="" target="_blank"><img src="medias/images/icons/bid.png" align="absmiddle" />بررسی</a>
                        <br/>
                        <? if ($row['readed'] == 0) { ?>
                            <a href<?= '="manage-reviewrequests?delete=1&id=' . $row['id'] . '"'; ?> class="popup remove"><img src="medias/images/icons/tick.png" align="absmiddle" />انجام شد</a>
                            <? } ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <?= $pager->pageBreaker(); ?>
    </div>
</div>

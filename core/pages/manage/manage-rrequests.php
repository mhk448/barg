<?php
if (isset($_REQUEST['delete'])) {
    $id = (int) $_REQUEST['id'];
    if ($database->runQuery('UPDATE representative_requests SET readed = -1 WHERE id = ' . $id)) {
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

$list = $pager->getList('representative_requests', '*', $where, ' ORDER BY dateline DESC', 'description');
?>
<div id="content-wrapper">
    <div id="content">
        <h1>مدیریت درخواستهای نمایندگی</h1>
        <br>
        <?= $pager->showSearchBox(); ?>
        <table width="100%" class="projects">
            <tr>
                <th>ش</th>
                <th>مشخصات</th>
                <th>متن و توضیح</th>
                <th>عملیات</th>
            </tr>
            <?php
            $i = 0;
            foreach ($list as $row) {
                ?>
                <tr class="">
                    <td><?php echo $row['id'] ?></td>
                    <td style="text-align: right">
                        نام:
                        <?php echo $row['fullname'] ?><br/>
                        موسسه:
                        <?php echo $row['company'] ?><br/>
                        تلفن:
                        <?php echo $row['phone'] ?><br/>
                        موبایل:
                        <?php echo $row['mobile'] ?><br/>
                        ایمیل:
                        <?php echo $row['email'] ?><br/>
                        زمینه همکاری:
                        <?php echo $row['scope'] ?><br/>
                        حجم سفارشات:
                        <?php echo $row['project_scale'] ?><br/>
                        تاریخ:
                        <?php echo $persiandate->date('d F Y', $row['dateline']) ?>

                    </td>
                    <td>
                        <?php echo nl2br($row['address']) ?><br/>
                        توضیح:
                        <?php echo nl2br($row['description']) ?>
                    </td>
                    <td width="120">
                        <? if ($row['readed'] == 0) { ?>
                            <a href<?= '="manage-rrequests?delete=1&id=' . $row['id'] . '"'; ?> class="popup remove"><img src="medias/images/icons/cross.png" align="absmiddle" />انجام شد</a>
                            <br/>
                        <? } ?>
                        <?
                        if ($row['files']) {
                            $a = json_decode($row['files'], TRUE);
                            foreach ($a as $v) {
                                ?>
                                <a href<?= '="uploads/'.$subSite.'/agency/' . $v . '"'; ?> >فایل ضمیمه</a><br/>
                            <? } ?>
                        <? } ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <?= $pager->pageBreaker(); ?>
    </div>
</div>

<?php
//$list = $pager->getComList('reports', '*', '', ' ORDER BY dateline DESC', 'body');
$list=array();
?>
<div id="content-wrapper">
    <div id="content">
        <h1>گزارشهای سیستمی و کاربری</h1>
        <br>
        <?= $pager->showSearchBox(); ?>
        <table width="100%" class="projects">
            <tr>
                <th>شناسه</th>
                <th>نوع</th>
                <th>تاریخ</th>
                <th>متن</th>
                <th>کاربر</th>
                <th>پروژه</th>
                <th>عملیات</th>
            </tr>
            <?php
            $i = 0;
            foreach ($list as $row) {
                ?>
                <tr class="">
                    <td><?php echo $row['id'] ?></td>
                    <td><?php echo $row['type'] ?></td>
                    <td width="110"><?php echo $persiandate->date('d F Y ساعت H:i:s', $row['dateline']) ?></td>
                    <td><?php echo $row['body'] ?></td>
                    <td><a href="user_<?php echo $row['user_id'] ?>"><?= $user->getUsername($row['user_id'])  ?></a></td>
                    <td><a href="project_<?php echo $row['project_id'] ?>" style="display:block"><?php echo $row['title'] ?></a></td>
                    <td width="120">
                        <a class="confirm"><img src="medias/images/icons/cross.png" align="absmiddle" /> حذف</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <?= $pager->pageBreaker(); ?>
         <div >
            <h1>خطای سیستم</h1>
            <?=  Report::getLogs() ?>
        </div>
    </div>
</div>

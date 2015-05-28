<?php
$list = $pager->getList('contents', '*', '', 'ORDER BY dateline DESC');
?>
<div id="content-wrapper">
    <div id="content">
      
        <h1>مدیریت مطالب</h1>
        <hr>
        <?php $message->display() ?>
        <table width="100%" class="projects">
            <tr>
                <th>شناسه</th>
                <th>عنوان</th>
                <th>تاریخ</th>
                <th>عملیات</th>
            </tr>
            <?php
            $i = 0;
            foreach ($list as $row) {
                ?>
                <tr class="">
                    <td><?php echo $row['id'] ?></td>
                    <td><a href="manage-content_<?php echo $row['id'] ?>"><?php echo $row['title'] ?></a></td>
                    <td width="110"><?php echo $persiandate->date('d F Y ساعت H:i:s', $row['dateline']) ?></td>
                    <td width="120">
                        <a  class="confirm"><img src="medias/images/icons/cross.png" align="absmiddle" /> حذف</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <?= $pager->pageBreaker(); ?>
    </div>
</div>

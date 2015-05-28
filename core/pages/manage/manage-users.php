<?php
$where = ' WHERE TRUE ';
$k = '';
if (isset($_GET['k'])) {
    $k = $_GET['k'];
    //nc? query in UI!!!!?!
    $where .= " AND username LIKE '%$k%' OR fullname LIKE '%$k%' OR nickname LIKE '%$k%' OR mobile LIKE '%$k%' OR email LIKE '%$k%'";
}
if (isset($_REQUEST['new']))
    $where .= " AND state<>'Active' ";

$where .= " ORDER BY id DESC ";
$list = $pager->getComList('users', '*', $where);
?>
<div id="content-wrapper">
    <div id="content">
        <h1>مدیریت کاربران</h1>
        <form method="get" class="form" action="manage-users">
            <label>کلمه کلیدی</label>
            <input type="text" name="k" value="<?php echo $k ?>" />
            <input type="submit" value="جستجو" name="submit" id="submit" style="margin-right:20px;" />
        </form>
        <div class="clear"></div>
        <br>
        <table  class="projects">
            <tr>
                <th>شناسه</th>
                <th>نام کاربری</th>
                <th>نوع</th>
                <th>وضعیت</th>
                <th>نام</th>
                <th>نام مستعار</th>
                <!--<th>تاریخ عضویت</th>-->
                <th>پست الکترونیک</th>
                <th>عملیات</th>
            </tr>
            <?php
            $i = 0;
            foreach ($list as $row) {
                ?>
                <tr class="">
                    <td><?php echo $row['id'] ?></td>
                    <td class="username"><a  target="_blank"  href<? echo '="user_' . $row['id'] . '"' ?> style="display:block"><?php echo $row['username'] ?></a></td>
                    <td><?php echo $_ENUM2FA['usergroup'][$row['usergroup_' . $_CONFIGS['subsite']]] ?></td>
                    <td><?php echo $_ENUM2FA['state'][$row['state']] ?></td>
                    <td><?php echo $row['fullname'] ?></td>
                    <td><?php echo $row['nickname'] ?></td>
                    <!--<td><?php // echo $persiandate->date('y/m/d', $row['']) ?></td>-->
                    <td class="username"><?php echo $row['email'] ?></td>
                    <td>
                        <? if ($row['state'] != 'Active') { ?>
                            <a href<?= '="user_' . $u->id . '?uid=' . $row['id'] . '&state=Active"'; ?> class="popup remove" ><img src="medias/images/icons/tick.png" align="absmiddle" /> تایید </a><br/>
                        <? }if ($row['state'] != 'Inactive') { ?>
                            <a href<?= '="user_' . $u->id . '?uid=' . $row['id'] . '&state=Inactive"'; ?> class="popup remove" ><img src="medias/images/icons/cross.png" align="absmiddle" /> غیر فعال </a><br/>
                            <?php } ?>
                        <a href<?= '="edit-profile_' . $row['id'] . '"'; ?> target="_blank"><img src="medias/images/icons/view.png" align="absmiddle" /> ویرایش</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <?= $pager->pageBreaker(); ?>
    </div>
</div>
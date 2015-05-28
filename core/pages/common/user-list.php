<?php
$group = 'user';
if (isset($_REQUEST['group'])) {
    $group = $_REQUEST['group'];
} elseif (isset($_CONFIGS['Params'][1])) {
    $group = $_CONFIGS['Params'][1];
}
$startRate = 0;

if (isset($_REQUEST['pager_s'])) {
    $_REQUEST['pager_s'] = substr($_REQUEST['pager_s'], 1);
    $_REQUEST['pager_s'] = "FULL" . intval($_REQUEST['pager_s']);
}
switch ($group) {
    case 'worker':
//        $list = $pager->getList('users_sub', '*', "WHERE usergroup = 'Worker' AND verified >0 ", 'ORDER BY rank/rankers DESC, rank DESC, rankers DESC', 'username');
//        if (isset($_REQUEST['boogh']))
//            $list = $pager->getList('users_sub', '*', "WHERE usergroup = 'Worker' AND verified >0 ", 'ORDER BY (rank / (rankers+0.2) + finished_projects /' . $_REQUEST['boogh'] . ' - rejected_projects) DESC', 'username');
//        else
        $list = $pager->getList('users_sub', '*', "WHERE usergroup = 'Worker' AND verified >0 ", 'ORDER BY (rank / (rankers+0.2) + finished_projects /50 - rejected_projects) DESC', 'id');
        $title = 'لیست ' . $_ENUM2FA['fa']['workers'] . ' (به ترتیب رتبه)';
        $startRate = ($pager->getCurPageNumber() - 1) * 20 + 1;
        break;
    case 'agency':
        $list = $pager->getList('users_sub', '*', "WHERE usergroup = 'Agency' AND verified >0 ", 'ORDER BY finished_projects DESC', 'id');
        $title = 'لیست نمایندگی ها';
        break;
    case 'admin':
        $list = $pager->getList('users_sub', '*', "WHERE (usergroup = 'Admin' OR usergroup = 'Administrator') AND verified >0 ", '', 'id');
        $title = 'لیست مدیران';
        break;
    case 'user':
    default :
        $list = $pager->getList('users_sub', '*', "WHERE usergroup = 'User' AND verified >0 ", 'ORDER BY finished_projects DESC', 'id');
        $title = 'لیست کاربران';
        break;
}

$_REQUEST['pager_s'] = '';
?>
<div id="content-wrapper">
    <div id="content">

        <h1><?= $title; ?></h1>

        <br>
        <? $pager->showSearchBox('کد کاربر: ', isset($_REQUEST['ajax'])); ?>

        <table  align="center" class="projects">
            <tr>
                <th>نام کاربری</th>
                <? if ($group == "worker") { ?>
                    <th style="text-align:center">امتیاز</th>
                    <th>رتبه</th>
                    <th>جام ها</th>
                <? } ?>
<!--<th>پروژه‌های در حال اجرا</th>-->
                <th style="font-size: 10px">تعداد پروژه ها</th>
                <th style="font-size: 10px">تاریخ شروع فعالیت</th>
                <th>عملیات</th>
            </tr>
            <?php
            foreach ($list as $typist) {
                $u = new User($typist['id']);
                ?>
                <tr>
                    <td class="username" style="cursor: pointer;text-align: right" onclick="return selectUser(<? echo $u->id . ',\'' . $u->getNickname() . '\''; ?>);" >
                        <img src="medias/images/icons/user.png" align="absmiddle"><?= $u->getNickname(); ?></td>
                    <? if ($group == "worker") { ?>
                        <td align="center">
                            <? $message->displayRank($u->rank, $u->rankers) ?> 
                        </td>
                        <td width=""><?= $startRate++ ?></td>
                        <td width=""><?= $u->displayCups($startRate - 1); ?></td>
                    <? } ?>
    <!--<td width=""><? // $typist['running_projects']         ?></td>-->
                    <td width="" align="center"><?= $u->finished_projects ?></td>
                    <td width=""><?php echo $persiandate->date('Y/m/d', $u->reg_date); ?></td>
                    <td>
                        <img src="medias/images/icons/bid.png" align="absmiddle">
                        <a href<?= '="user_' . $u->id . '"'; ?> target="_blank">
                            نمایش سابقه
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <?= $pager->pageBreaker(NULL, "", isset($_REQUEST['ajax']) ? null : "#ajax_content"); ?>
    </div>
</div>

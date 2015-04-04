<?php
$list = $pager->getList('groups', '*', "WHERE verified >0", 'ORDER BY (rank / (rankers+0.001)) DESC, rank DESC, rankers DESC', 'title');
?>
<div id="content-wrapper">
    <div id="content">

        <h1>لیست گروه‌های کاری</h1>

        <br>
        <? $pager->showSearchBox(); ?>

        <table  align="center" class="projects">
            <tr>
                <th>نام کاربری</th>
                <th style="text-align:center">امتیاز</th>
                <th>رتبه</th>
                <th>جام ها</th>
                <th>عملیات</th>
            </tr>
            <?php
            $rate = 0;
            foreach ($list as $g0) {
                $rate++;
                $g = new Group($g0['id']);
                ?>
                <tr>
                    <td class="username" style="text-align: right"  >
                        <a href<?= '="group_' . $g->id . '"'; ?> class="popup">
                            <img src="medias/images/icons/user.png" align="absmiddle"><?= $g->title; ?>
                        </a>
                    </td>
                    <td align="center">
                        <?= $g->displayRank() ?> 
                    </td>
                    <td width=""><?= $rate ?></td>
                    <td width=""><?= $g->displayCups($rate); ?></td>
                    <td>
                        <img src="medias/images/icons/bid.png" align="absmiddle">
                        <a href<?= '="group_' . $g->id . '"'; ?> class="popup">
                            نمایش جزئیات
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <?= $pager->pageBreaker(); ?>
    </div>
</div>

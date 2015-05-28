<?
if (isset($_CONFIGS['Params'][1]) && isset($_CONFIGS['Params'][2])) {
    if ($_CONFIGS['Params'][1] == 'u') {
        $u = $pager->getComParamById('users', TRUE, 2);
        $list = $pager->getList('level_a', '*', 'WHERE user_id=' . $u['id'], 'ORDER BY dateline DESC', 'answer_1');
    } elseif ($_CONFIGS['Params'][1] == 'q') {
        $lq = $pager->getParamById('level_q', TRUE, 2);
        $list = $pager->getList('level_a', '*', 'WHERE q_id=' . $lq['id'], 'ORDER BY dateline DESC', 'answer_1');
    }
} else {
    $list = $pager->getList('level_a', '*', '', 'ORDER BY dateline DESC', 'answer_1');
}
?>
<div id="content-wrapper">
    <div id="content">
        <? if ($u) { ?>
            <h1>نمایش نظرات کاربر: <?= $user->getNickname($u['id']); ?></h1>
        <? } else { ?>
            <h1>نمایش  نظرات</h1>
            <?= $lq['question'] ?>
        <? } ?>
        <br>
        <?= $pager->showSearchBox(); ?>
        <table width="100%" class="projects">
            <tr>
                <th>از طرف</th>
                <th>۰</th>
                <th>۱</th>
                <th>۲</th>
                <th>۳</th>
                <th>۴</th>
                <th>۵</th>
                <th>عملیات</th>
            </tr>
            <?php
            $i = 0;
            foreach ($list as $row) {
                ?>
                <tr class="">
                    <td><a href<?= '="user_' . $row['user_id'] . '"' ?> target="_blank"><?= $user->getNickname($row['user_id']) ?></a></td>
                    <td><?= $row['answer_0'] ?></td>
                    <td><?= $row['answer_1'] ?></td>
                    <td><?= $row['answer_2'] ?></td>
                    <td><?= $row['answer_3'] ?></td>
                    <td><?= $row['answer_4'] ?></td>
                    <td><?= $row['answer_5'] ?></td>
                    <td width="60">
                        شناسه:
                        <?= $row['id'] ?><br/>
                        سوال:
                        <?= $row['q_id'] ?><br/>
                        <?php echo $persiandate->displayDate($row['dateline']) ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <?= $pager->pageBreaker(); ?>
    </div>
</div>

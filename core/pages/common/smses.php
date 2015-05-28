<?php
$list = $pager->getComList('sms', '*', 'WHERE verified>=0 AND   receiver=' . (int) $user->id , ' ORDER BY dateline DESC', 'message');
?>
<div id="content-wrapper">
    <div id="content">
        <h1>پیامک های دریافتی</h1>
        <br>
        <table width="100%" class="projects">
            <thead>
                <tr>
                    <th>ردیف</th>
                    <th>از طرف</th>
                    <th>متن</th>
                    <th width="80px">تاریخ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($list as $row) {
                    ?>
                    <tr class="">
                        <td><?php echo $i++ ?></td>
                        <td><a <?= 'href2="user_' . $row['sender'] . '"' ?> target="_blank"><?= $user->getNickname($row['sender']) ?></a></td>
                        <td><?= nl2br($row['message']) ?></td>
                        <td><?php echo $persiandate->displayDate($row['dateline']) ?></td>

                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?= $pager->pageBreaker(); ?>
        <br/>
        <hr/>
        <?php
        $list = $pager->getComList('sms', '*', 'WHERE verified>=0 AND   sender=' . (int) $user->id , ' ORDER BY dateline DESC', 'message');
        ?>
        <h1>پیامک های ارسال شده</h1>
        <br>
        <table width="100%" class="projects">
            <thead>
                <tr>
                    <th>ردیف</th>
                    <th>به</th>
                    <th>متن</th>
                    <th width="80px">تاریخ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($list as $row) {
                    ?>
                    <tr class="">
                        <td><?php echo $i++ ?></td>
                        <td><a <?= 'href2="user_' . $row['receiver'] . '"' ?> target="_blank"><?= $user->getNickname($row['receiver']) ?></a></td>
                        <td><?= nl2br($row['message']) ?></td>
                        <td><?php echo $persiandate->displayDate($row['dateline']) ?></td>

                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?= $pager->pageBreaker(); ?>

    </div>
</div>

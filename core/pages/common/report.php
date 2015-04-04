<?php
if ($user->isAdmin() && isset($_CONFIGS['Params'][1])) {
    $u = new User($_CONFIGS['Params'][1]);
} else {
    $u = $user;
}

$payments = $report->getPayments($u);
$payouts = $report->getPayouts($u);
$lock_credits = $report->getListLockedCredit($u);
//$credits = $report->getCreditReport($u);
$credits = $pager->getComList('credits', '*', $cdatabase->whereId($u->id, "user_id"), ' ORDER BY dateline DESC', 'comment');

$index = 0;
?>
<div id="content-wrapper">
    <div id="content">
        <h1>گزارش مالی</h1>
        <div style="padding:10px;">
            <? if ($payments) { ?>
                <h2>لیست پرداخت ها (واریزی)</h2>
                <br>
                <table width="90%" align="center" class="projects">
                    <tr>
                        <th>ردیف</th>
                        <th>تاریخ ثبت</th>
                        <th>بانک</th>
                        <th>نوع واریز</th>
                        <th>شماره فیش</th>
                        <th>مبلغ</th>
                        <th>تاریخ واریز</th>
                        <th>شناسه</th>
                        <th>وضعیت</th>
                    </tr>
                    <?php
                    foreach ($payments as $payment) {
                        $index++;
                        ?>
                        <tr class="bg-verified<?= $payment['verified'] ?>">
                            <td><?php echo $index ?></td>
                            <td><?php echo $persiandate->displayDate($payment['dateline']) ?></td>
                            <td><?php echo $payment['bank_name'] ?></td>
                            <td><?php echo $_ENUM2FA['payment_type'][$payment['payment_type']] ?></td>
                            <td><?php echo $payment['transaction_id'] ?></td>
                            <td><span class="price"><?php echo $payment['price'] ?> </span> ریال</td>
                            <td><?php echo ((int) $payment['pay_date']) > 1300000000 ? $persiandate->date('d F Y', $payment['pay_date']) : $payment['pay_date'] ?></td>
                            <td class="english" style="text-align: right;">PM<?php echo $payment['id'] ?></td>
                            <td><?php echo $_ENUM2FA['verified'][$payment['verified']] ?></td>
                        </tr>
                    <? } ?>
                </table>
                <br><br>
            <? } ?>
            <? if ($payouts) { ?>
                <h2>لیست دریافتها (برداشت)</h2>
                <br>
                <table width="90%" align="center" class="projects">
                    <tr>
                        <th>ردیف</th>
                        <th>تاریخ ثبت</th>
                        <th>بانک</th>
                        <th>شماره فیش</th>
                        <th>مبلغ</th>
                        <th>تاریخ واریز</th>
                        <th>شناسه</th>
                        <th>وضعیت</th>
                    </tr>
                    <?php
                    $index = 0;
                    foreach ($payouts as $payout) {
                        $index++;
                        ?>
                        <tr>
                            <td><?php echo $index ?></td>
                            <td><?php echo $persiandate->displayDate($payout['dateline']) ?></td>
                            <td><?php echo $payout['bank_name'] ?></td>
                            <td><?php echo $payout['transaction_id'] ?></td>
                            <td><span class="price"><?php echo $payout['price'] ?></span> ریال</td>
                            <td><?php echo $payout['pay_date'] ?></td>
                            <td class="english" style="text-align: right;">PO<?php echo $payout['id'] ?></td>
                            <td><?php echo $_ENUM2FA['verified'][$payout['verified']] ?></td>
                        </tr>
                    <?php } ?>
                </table>
                <br><br>
            <? } ?>
            <h2>لیست گروگذاری های جاری</h2>
            <br>
            <table width="90%" align="center" class="projects">
                <tr>
                    <th>ردیف</th>
                    <th>مبلغ</th>
                    <th>پروژه</th>
                    <th style="width: 80px">شناسه</th>
                    <th>تاریخ</th>
                </tr>
                <?php
                $index = 0;
                foreach ($lock_credits as $lock_credit) {
                    $index++;
                    ?>
                    <tr>
                        <td><?php echo $index ?></td>
                        <td><span class="price"><?php echo $lock_credit['price'] ?></span>ریال</td>
                        <td>
                            <a class="ajax" target="_blank" <?= 'href="project_' . $lock_credit['prj_id'] . '"' ?> >
                                <?= $project->getTitle($lock_credit['prj_id']) ?>
                            </a>
                        </td>
                        <td class="english" style="text-align: right;">LC<?php echo $lock_credit['id'] ?></td>
                        <td><?php echo $persiandate->displayDate($lock_credit['date']) ?></td>
                    </tr>
                <?php } ?>
            </table>

            <br><br>
            <h2>لیست تراکنش های داخلی</h2>
            <br>
            <table width="90%" align="center" class="projects">
                <tr>
                    <th>ردیف</th>
                    <th>مبلغ</th>
                    <th>تاریخ</th>
                    <th>توضیحات</th>
                    <th>جزییات</th>
                    <th style="">شناسه</th>
                </tr>
                <?php
                $index = 0;
                foreach ($credits as $credit) {
                    $index++;
                    $base_path = "";
                    if ($subSite != $credit['subsite']) {
                        $base_path = $_CONFIGS['Site'][$credit['subsite']]['Path'];
                    }
                    if ($credit['ref_table'] == 'users') {
                        $ref = '<a href="user_' . $credit['ref_id'] . '" >' . $u->getNickname($credit['ref_id']) . '</a>';
                    } elseif ($credit['ref_table'] == 'projects') {
                        $ref = '<a href="' . $base_path . 'project_' . $credit['ref_id'] . '" >' . getProjectTitle($credit['ref_id'],$credit['subsite']) . '</a>';
                    } elseif ($credit['ref_table'] == 'payments') {
                        $ref = '<a href="#" class="english" >' . 'PM' . $credit['ref_id'] . '</a>';
                    } elseif ($credit['ref_table'] == 'payouts') {
                        $ref = '<a href="#" class="english" >' . 'PO' . $credit['ref_id'] . '</a>';
                    } elseif ($credit['ref_table'] == 'review_requests') {
                        $ref = $credit['comment'];
                    } elseif ($credit['ref_table'] == 'refers') {
                        $ref = '<a href="' . $base_path . 'project_' . $credit['ref_id'] . '" >' . getProjectTitle($credit['ref_id'],$credit['subsite']) . '</a>';
                    } elseif ($credit['ref_table'] == 'groups') {
                        $ref = '<a href="' . $base_path . 'project_' . $credit['ref_id'] . '" >' . getProjectTitle($credit['ref_id'],$credit['subsite']) . '</a>';
                    } else {
                        $ref = "";
                    }
                    ?>
                    <tr>
                        <td><?php echo $index ?></td>
                        <td><span class="price"><?php echo $credit['price'] ?></span> ریال </td>
                        <td><?php echo $persiandate->displayDate($credit['dateline']) ?></td>
                        <td><span><?php echo $credit['ref_table'] != 'users' ? $_ENUM2FA['ref_table'][$credit['ref_table']] : $credit['comment'] ?></span></td>
                        <td><?= $ref ?></td>
                        <td class="english" style="text-align: right;">IC<?php echo $credit['id'] ?></td>
                    </tr>
                <?php } ?>
            </table>
            <?= $pager->pageBreaker(); ?>
        </div>
    </div>
</div>
<?

function getProjectTitle($pid, $sub_site) {
    global $subSite, $project, $_ENUM2FA;
    if ($subSite == $sub_site)
        return $project->getTitle($pid);
    return $_ENUM2FA['sub'][$sub_site]['work'];
}
<?php
//$list = $database->fetchAll($database->select('payments', '*', 'ORDER BY dateline DESC'));

if (isset($_POST['mindate'])) {
    $datefild = spliti("/", $_POST['mindate']);
    $mindate = $persiandate->persianToTimestamp($datefild[0], $datefild[1], $datefild[2]);
} else {
    $mindate = $persiandate->persianToTimestamp(1390, 1, 1);
//    $mindate =0;
}

if (isset($_POST['maxdate'])) {
    $datefild = spliti("/", $_POST['maxdate']);
    $maxdate = $persiandate->persianToTimestamp($datefild[0], $datefild[1], $datefild[2]);
} else {
    $maxdate = time();
}

$peyAll = $cdatabase->fetchArray($cdatabase->select('payments', ' sum(`price`) AS `prices` ,count(`price`) AS `counts` ', "WHERE dateline >= '$mindate' AND dateline <= '$maxdate' AND verified='1' "));
$outAll = $cdatabase->fetchArray($cdatabase->select('payouts', ' sum(price) AS prices ,count(price) AS counts', "WHERE dateline >= '$mindate' AND dateline <= '$maxdate' AND verified='1' "));
$smsAll = $cdatabase->fetchArray($cdatabase->select('credits', ' sum(price) AS prices ,count(price) AS counts', "WHERE dateline >= '$mindate' AND dateline <= '$maxdate' AND user_id='" . User::$SMS . "'"));
$subAll['prices'] = $peyAll['prices'] - $outAll['prices'];
//internal credit
$CreAll = $cdatabase->fetchArray($cdatabase->select('credits', ' sum(price) AS prices ,count(price) AS counts', "WHERE dateline >= '$mindate' AND dateline <= '$maxdate' "));


$prjState0 = $database->fetchAll($database->runQuery("SELECT count( `id` ) AS counts,sum(accepted_price) AS `prices`,sum(elmend_price) AS `elmend_prices` ,sum(earnest) AS earnests,`state` FROM `projects` WHERE `submit_date` >='$mindate'  AND `submit_date` <= '$maxdate' AND verified<>'0' GROUP BY state"));
$prjType0 = $database->fetchAll($database->runQuery(" SELECT count( `id` ) AS counts,sum(accepted_price) AS `prices`,sum(elmend_price) AS `elmend_prices` , `type` FROM `projects` WHERE `submit_date` >='$mindate'  AND `submit_date` <= '$maxdate' AND verified<>'0' GROUP BY type "));

$prjState['sum']['prices'] = 0;
$prjState['sum']['counts'] = 0;
$prjState['sum']['elmend_prices'] = 0;
$prjState['sum']['earnests'] = 0;
foreach ($prjState0 as $value) {
    $prjState[($value['state'])] = $value;
    $prjState['sum']['prices'] = $prjState['sum']['prices'] + $value['prices'];
    $prjState['sum']['counts'] = $prjState['sum']['counts'] + $value['counts'];
    $prjState['sum']['elmend_prices'] = $prjState['sum']['elmend_prices'] + $value['elmend_prices'];
    $prjState['sum']['earnests'] = $prjState['sum']['earnests'] + $value['earnests'];
}
$prjType['sum']['prices'] = 0;
$prjType['sum']['counts'] = 0;
$prjType['sum']['elmend_prices'] = 0;
foreach ($prjType0 as $value) {
    $prjType[($value['type'])] = $value;
    $prjType['sum']['prices'] = $prjType['sum']['prices'] + $value['prices'];
    $prjType['sum']['counts'] = $prjType['sum']['counts'] + $value['counts'];
    $prjType['sum']['elmend_prices'] = $prjType['sum']['elmend_prices'] + $value['elmend_prices'];
}

//$u_typeiran = new User(User::$TYPEIRAN);
//$u_typeiran_p = $u_typeiran->getCredit(TRUE) * -1;
$u_elmend = new User(User::$ELMEND);
$u_elmend_p = $u_elmend->getCredit(TRUE);
$u_50 = new User(50);
$u_50_p = $u_50->getCredit(TRUE) * -1;
$u_51 = new User(51);
$u_51_p = $u_51->getCredit(TRUE) * -1;
//print_r($prjType);
?>

<div id="content-wrapper">
    <div id="content">
        <h1>مدیریت حسابهای مالی</h1>
        <br>

        <form action="manage-accounting" method="POST">
            نمایش گزارش از تاریخ
            <?
//            $persiandate=new PersianDate();

            echo jCalendarFild('mindate', 'value="' . $persiandate->date('Y/m/d', $mindate) . '" placeholder="' . 'تاریخ شمسی' . '" ');
            echo ' تا ';
            echo jCalendarFild('maxdate', 'value="' . $persiandate->date('Y/m/d', $maxdate) . '" placeholder="' . 'تاریخ شمسی' . '" ');
            ?>
            <input type="submit" value="نمایش"/>
        </form>
        <br/>
        <br/>
        <br>
        <? if (!isset($_POST['report']) && $_POST['report'] != 'all') { ?>
            <table width="50%" class="projects">
                <tr>
                    <th></th>
                    <th>تعداد</th>
                    <th style="text-align: center">مبلغ</th>
                    <th></th>
                </tr>
                <tr>
                    <td>کل واریزی ها به مرکز</td>
                    <td class="" ><?= $peyAll['counts'] ?></td>
                    <td class="price number" ><?= $peyAll['prices'] ?></td>
                    <td>ریال</td>
                </tr>
                <tr>
                    <td>کل پرداخت های مرکز</td>
                    <td class="" ><?= $outAll['counts'] ?></td>
                    <td class="price number" ><?= $outAll['prices'] ?></td>
                    <td>ریال</td>
                </tr>
                <tr>
                    <td>مانده حساب بانک</td>
                    <td>---</td>
                    <td class="price number" ><?= $subAll['prices'] ?></td>
                    <td>ریال</td>
                </tr>
                <tr>
                    <td>اختلاف تراکنش داخلی</td>
                    <td>---</td>
                    <td class="price number" ><?= $CreAll['prices'] ?></td>
                    <td>ریال</td>
                </tr>
                <tr>
                    <td>اختلاف</td>
                    <td>---</td>
                    <td class="price number" ><?= $subAll['prices'] - $CreAll['prices'] ?></td>
                    <td>ریال</td>
                </tr>
            </table>
            <hr/>
            <hr/>
            مبالغ کاربران
            <table width="50%" class="projects">
                <tr>
                    <th></th>
                    <th>تعداد</th>
                    <th style="text-align: center">مبلغ</th>
                    <th></th>
                </tr>
<!--                <tr>
                    <td>نسخه قدیم</td>
                    <td>---</td>
                    <td class="price number" ><?= $u_typeiran_p ?></td>
                    <td>ریال</td>
                </tr>-->
                <tr>
                    <td>کاربر Admin</td>
                    <td class="" >---</td>
                    <td class="price number" ><?= $u_51_p ?></td>
                    <td>ریال</td>
                </tr>
                <tr>
                    <td> کاربر mhk448</td>
                    <td>---</td>
                    <td class="price number" ><?= $u_50_p ?></td>
                    <td>ریال</td>
                </tr>
                <tr>
                    <td>اختلاف تراکنش داخلی</td>
                    <td>---</td>
                    <td class="price number" ><?= $CreAll['prices'] ?></td>
                    <td>ریال</td>
                </tr>
                <tr>
                    <td>جمع کل</td>
                    <td>---</td>
                    <td class="price number" ><?= $u_50_p + $u_51_p + $CreAll['prices'] ?></td>
                    <td>ریال</td>
                </tr>
                <tr>
                    <td>سود پروژه ها</td>
                    <td class="" > --- </td>
                    <td class="price number" ><?= $u_elmend_p ?></td>
                    <td>ریال</td>
                </tr>
                <tr>
                    <td> سود پیامک</td>
                    <td class="" ><?= $smsAll['counts'] ?></td>
                    <td class="price number" ><?= $smsAll['prices'] / 4 ?></td>
                    <td>ریال</td>
                </tr>
                <tr>
                    <td> جمع کل به همراه سود</td>
                    <td>---</td>
                    <td class="price number" ><?=  $u_50_p + $u_51_p + $CreAll['prices'] - $u_elmend_p + ($smsAll['prices'] / 4) ?></td>
                    <td>ریال</td>
                </tr>

            </table>
            <hr/>
            <hr/>
            <table width="70%" class="projects">
                <tr>
                    <th></th>
                    <th>تعداد</th>
                    <th>مبلغ</th>
                    <th>سهم مرکز</th>
                </tr>
                <tr>
                    <td>پروژه های باز</td>
                    <td><?= $prjState['Open']['counts'] ?></td>
                    <td class="price number" ><?= $prjState['Open']['prices'] ?></td>
                    <td class="price number" ><?= $prjState['Open']['elmend_prices'] ?></td>
                </tr>
                <tr>
                    <td>پروژه های درحال اجرا</td>
                    <td><?= $prjState['Run']['counts'] ?></td>
                    <td class="price number" ><?= $prjState['Run']['prices'] ?></td>
                    <td class="price number" ><?= $prjState['Run']['elmend_prices'] ?></td>
                </tr>
                <tr>
                    <td>پروژه های تمام شده</td>
                    <td><?= $prjState['Finish']['counts'] ?></td>
                    <td class="price number" ><?= $prjState['Finish']['prices'] ?></td>
                    <td class="price number" ><?= $prjState['Finish']['elmend_prices'] ?></td>
                </tr>
                <tr>
                    <td>پروژه های رد شده</td>
                    <td><?= $prjState['Close']['counts'] ?></td>
                    <td class="price number" ><?= $prjState['Close']['prices'] ?></td>
                    <td class="price number" ><?= $prjState['Close']['elmend_prices'] ?></td>
                </tr>
                <tr>
                    <td>جمع کل</td>
                    <td><?= $prjState['sum']['counts'] ?></td>
                    <td class="price number" ><?= $prjState['sum']['prices'] ?></td>
                    <td class="price number" ><?= $prjState['sum']['elmend_prices'] ?></td>
                </tr>
                <tr>
                    <th></th>
                    <th>تعداد</th>
                    <th>مبلغ</th>
                    <th>سهم مرکز</th>
                </tr>
                <tr>
                    <td>پروژه های نمایندگی</td>
                    <td><?= $prjType['Agency']['counts'] ?></td>
                    <td class="price number" ><?= $prjType['Agency']['prices'] ?></td>
                    <td class="price number" ><?= $prjType['Agency']['elmend_prices'] ?></td>
                </tr>
                <tr>
                    <td>پروژه های مناقصه</td>
                    <td><?= $prjType['Public']['counts'] ?></td>
                    <td class="price number" ><?= $prjType['Public']['prices'] ?></td>
                    <td class="price number" ><?= $prjType['Public']['elmend_prices'] ?></td>
                </tr>
                <tr>
                    <td>پروژه های خصوصی</td>
                    <td><?= $prjType['Private']['counts'] ?></td>
                    <td class="price number" ><?= $prjType['Private']['prices'] ?></td>
                    <td class="price number" ><?= $prjType['Private']['elmend_prices'] ?></td>
                </tr>
                <tr>
                    <td>پروژه های تضمین شده</td>
                    <td><?= $prjType['Protected']['counts'] ?></td>
                    <td class="price number" ><?= $prjType['Protected']['prices'] ?></td>
                    <td class="price number" ><?= $prjType['Protected']['elmend_prices'] ?></td>
                </tr>
                <tr>
                    <td>جمع کل</td>
                    <td><?= $prjType['sum']['counts'] ?></td>
                    <td class="price number" ><?= $prjType['sum']['prices'] ?></td>
                    <td class="price number" ><?= $prjType['sum']['elmend_prices'] ?></td>
                </tr>
                <tr>
                    <th>جمع</th>
                    <th>تعداد</th>
                    <th>مبلغ</th>
                    <th>سهم مرکز</th>
                </tr>
                <tr>
                    <td>جمع تمام شده ها</td>
                    <td><?= $prjState['Finish']['counts'] ?></td>
                    <td class="price number" ><?= $prjState['Finish']['prices'] ?></td>
                    <td class="price number" ><?= $prjState['Finish']['elmend_prices'] ?></td>
                </tr>
                <tr>
                    <td>جمع کل بیعانه ها</td>
                    <td><?= $prjState['Run']['counts'] + $prjState['Open']['counts'] ?></td>
                    <td class="price number" ><?= $prjState['Run']['earnests'] + $prjState['Open']['earnests'] ?></td>
                    <td class="price number" >---</td>
                </tr>
                <tr>
                    <td>جمع کل </td>
                    <td><?= $prjState['sum']['counts'] - $prjState['Close']['counts'] ?></td>
                    <td class="price number" ><?= $prjState['Run']['earnests'] + $prjState['Open']['earnests'] + $prjState['Finish']['prices'] ?></td>
                    <td class="price number" >---</td>
                </tr>
            </table>
            <br/>
            <hr/>
        <? } else { ?>
            <table width="100%" class="projects">
                <tr>
                    <th>ماه</th>
                    <th>تعداد پروژه</th>
                    <th>مبلغ واریزی</th>
                    <th>مبلغ پرداختی</th>
                    <th>سهم مرکز</th>
                    <th>تعداد کاربران</th>
                    <th>تعداد مجری ها</th>
                    <th>تعداد نمایندگی ها</th>
                    <th></th>
                </tr>
                <?php
                $i = 0;
                foreach ($list as $row) {
                    ?>
                    <tr>
                        <td><?= $persiandate->date('F', $row['dateline']) ?></td>

                        <td><?= $row['id'] ?></td>
                        <td><?php echo $row['transaction_id'] ?></td>
                    </tr>
                <?php } ?>
            </table>
        <? } ?>
    </div>
</div>

<?php
if (isset($_REQUEST['pay_id']) && isset($_REQUEST['price'])) {
    $message->conditionDisplay($creditlog->addPayments($_REQUEST['pay_id'], '-1', time(), $_REQUEST['com'], $_REQUEST['ver']));
} else {

    $where = "WHERE 1 ";
    $filter = '';
    if (isset($_REQUEST['ptype']) && $_REQUEST['ptype'] != 'all') {
        $where .= " AND payment_type='" . $_REQUEST['ptype'] . "' ";
        $filter.=$_REQUEST['ptype'] == 'Bank' ? 'فیش های ثبت شده' : 'پرداخت های آنلاین';
    }
    if (isset($_REQUEST['new']) && $_REQUEST['new'] != 'all') {
        $where .= ' AND verified=' . intval($_REQUEST['new']);
        $filter.=' - '.$_ENUM2FA['verified'][$_REQUEST['new']];
    }
    if (isset($_REQUEST['bank']) && $_REQUEST['bank'] != 'all') {
        $where .= " AND bank_name='" . $_REQUEST['bank'] . "' ";
        $filter.=' بانک ' . $_REQUEST['bank'];
    }
    $list = $pager->getComList('payments', '*', $where, ' ORDER BY dateline DESC', 'bank_name');
    ?>
    <div id="content-wrapper">
        <div id="content">
            <h1>واریزی ها به مرکز</h1>
            <br/>
            <form action="manage-payments" method="GET">
                <select name="ptype">
                    <option value="all">
                        همه
                    </option>
                    <option value="Online">
                        پرداخت آنلاین
                    </option>
                    <option value="Bank">
                        فیش های ثبت شده
                    </option>
                </select>
                <select name="bank">
                    <option value="all">
                        همه
                    </option>
                    <option value="پاسارگاد">
                        بانک پاسارگاد
                    </option>
                    <option value="تجارت">
                        بانک تجارت
                    </option>
                    <option value="پارس پال">
                        پارس پال
                    </option>
                    <option value="ملی">
                        ملی
                    </option>
                </select>
                <select name="new">
                    <option value="all">
                        همه
                    </option>
                    <option value="1">
                        تایید شده
                    </option>
                    <option value="-1">
                        رد شده
                    </option>
                    <option value="0">
                        نامشخص
                    </option>
                </select>
                <input type="submit" value="اعمال"/>
            </form>


            <hr/>
            <?= $filter ?>
            <hr/>
            <br/>
            <script type="text/javascript">
                function setPayment(cur,payid,price,uid,ver){
                    if(ver!=-1||window.confirm("آیا مطمئن هستید؟")){
                        mhkform.ajax('manage-payments?ajax=1&pay_id='+payid+'&price='+price+'&user_id='+uid+'&ver='+ver+'&com='+<?= $user->id ?>+'_changed_this'); 
                        $(cur).parent().parent().remove();
                    }
                }
            </script>
            <? // echo $pager->showSearchBox(); ?>
            <table width="100%" class="projects">
                <tr>
                    <th>شناسه</th>
                    <th>کاربر</th>
                    <th>نام بانک</th>
                    <th>نوع پرداخت</th>
                    <th>شناسه پرداخت</th>
                    <th>مبلغ</th>
                    <th>تاریخ واریز</th>
                    <th>تاریخ ثبت</th>
                    <th>عملیات</th>
                </tr>
                <?php
                $i = 0;
                foreach ($list as $row) {
                    ?>
                    <tr class="">
                        <td><?php echo $row['id'] ?></td>
                        <td><a target="_blank" href="user_<?php echo $row['user_id'] ?>"><?php echo $user->getNickname($row['user_id']) ?></a></td>
                        <td><?php echo $row['bank_name'] ?></td>
                        <td><?php echo $row['payment_type'] ?> : <?php echo $row['bank_pay_type'] ?></td>
                        <td><?php echo $row['transaction_id'] ?></td>
                        <td><?php echo $row['price'] ?> ریال</td>
                        <td><?php echo $row['pay_date'] ?></td>
                        <td width="110"><?php echo $persiandate->displayDate($row['dateline']) ?></td>
                        <td width="120">
                            <? if ($row['verified'] != Event::$V_ACC) { ?>
                                <a href<?= '="manage-payments?ajax=1&pay_id=' . $row['id'] . '&price=' . $row['price'] . '&user_id=' . $row['user_id'] . '&ver=1&com=' . $user->id . '_changed_this"' ?> class="popup inline">
                                    <img src="medias/images/icons/tick.png" align="absmiddle" />

                                    تایید
                                </a><br/>
                            <? }if ($row['verified'] != Event::$V_REJECT) { ?>
                                <a href<?= '="manage-payments?ajax=1&pay_id=' . $row['id'] . '&price=' . $row['price'] . '&user_id=' . $row['user_id'] . '&ver=-1&com=' . $user->id . '_changed_this"' ?> class="popup inline">
                                    <img src="medias/images/icons/cross.png" align="absmiddle" />

                                    رد 
                                </a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
            <?= $pager->pageBreaker(); ?>
        </div>
    </div>
<? } ?>

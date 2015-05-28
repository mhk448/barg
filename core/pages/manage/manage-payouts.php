<?php
if (isset($_REQUEST['submit']) && isset($_REQUEST['id']) && isset($_REQUEST['uid'])) {
    $creditlog->addPayouts($_REQUEST['id'], $_REQUEST['tid'], $_REQUEST['date'], $_REQUEST['com'], $_REQUEST['ver']);
} elseif (isset($_REQUEST['accform'])) {
    ?>
    تایید پرداخت
    <form class="form">
        <input type="hidden" name="payid" value="<?php echo $_REQUEST['id'] ?>" />
        <input type="hidden" name="price" value="<?php echo $_REQUEST['price'] ?>" />
        <input type="hidden" name="ver"  value="1"/>
        <label>

            تاریخ: 
        </label>
        <?= jCalendarFild('date', ' id="time_select"   required="required"  placeholder="' . 'تاریخ شمسی' . '" value="' . $persiandate->date("Y/m/d") . '"'); ?>
        <br/>
        <label>
            شناسه (پیگیری): 
        </label>
        <input type="text" name="tid" style="" />
        <br/>
        <label>
            توضیح: 
        </label>
        <input type="text" name="com" style="" />
        <label></label>
        <input type="button" name="submit" value="ثبت و تایید" style="" onclick="accPayout(this)" />
    </form>
    <?
} else {
    $where = "";
    if (isset($_REQUEST['new']))
        $where = 'WHERE verified=0';
    $list = $pager->getComList('payouts', '*', $where, ' ORDER BY dateline DESC', 'bank_name', 100);
    ?>
    <div id="content-wrapper">
        <div id="content">
            <h1>مدیریت پرداختها</h1>
            <br>
            <script type="text/javascript">
                function setPayout(cur,payid,date,uid,ver,tid,com){
                    if(ver==-1){
                        com=window.prompt("علت:");
                        if(com==null)
                            return;
                    }
                    $(cur).remove();
                    mhkform.ajax('manage-payouts?ajax=1&submit=1&id='+payid+'&date='+date+'&uid='+uid+'&ver='+ver+'&tid='+tid+'&com='+com); 
                    $(cur).parent().parent().remove();
                }
                function accPayout(cur){
                    setPayout(cur
                    ,$("[name='payid']").val()
                    ,$("[name='date']").val()
                    ,$("[name='uid']").val()
                    ,1
                    ,$("[name='tid']").val()
                    ,$("[name='com']").val());
                }
                                                
            </script>
            <?= $pager->showSearchBox(); ?>
            <table width="100%" class="projects">
                <tr>
                    <th>شناسه</th>
                    <th>کاربر</th>
                    <th>نام بانک</th>
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
                        <td><a target="_blank" <?= 'href="user_' . $row['user_id'] . '"' ?>><?php echo $user->getNickname($row['user_id']) ?></a></td>
                        <td><?php echo $row['bank_name'] ?></td>
                        <td><?php echo $row['transaction_id'] ?></td>
                        <td><?php echo $row['price'] ?> ریال</td>
                        <td><?php echo $row['pay_date'] ?></td>
                        <td width="110"><?php echo $persiandate->displayDate($row['dateline']) ?></td>
                        <td>

                            <? if ($row['verified'] != 1) { ?>
                                <a 
                                    onclick="mhkform.ajax(<?=
                    "'manage-payouts?id=" . $row['id']
                    . '&uid=' . $row['user_id']
                    . '&price=' . $row['price']
                    . '&accform=1'
                    . '&ajax=1'
                    . "'"
                                ?>);$(this).remove();">
                                    <img src="medias/images/icons/tick.png" align="absmiddle" />
                                    تایید
                                </a><br/>
                            <?php } ?>
                            <? if ($row['verified'] != -1) { ?>

                                <a onclick="setPayout(this,<?= $row['id'] . ',' . time() . ',' . $row['user_id']; ?>,-1,'','')" class="">
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
<?php } ?>


<?php
if (isset($_REQUEST['detail'])) {
    $bid = new Bid($_REQUEST['bid']);
    echo $bid->displayBid();
} else {
    if ($user->isAdmin())
        $uid = $_CONFIGS['Params'][1];
    else
        $uid = $user->id;


    $list = $pager->getList('bids', '*', $database->whereId($uid, 'user_id'), ' ORDER BY id DESC');
    ?>
    <div id="content-wrapper">
        <div id="content">
            <h1>لیست پیشنهادهای شما</h1>
            <br>
            <table width="90%" align="center" class="projects">
                <tr>
                    <th>ردیف</th>
                    <th>پروژه</th>
                    <th>نوع</th>
                    <th width="105">تاریخ ارسال</th>
                    <th>مبلغ پیشنهادی</th>
                    <th>توضیحات/پیام</th>
                    <th>عملیات</th>
                </tr>
                <?php
                $index = 1;
                foreach ($list as $bid0) {
                    $p = new Project($bid0['project_id']);
                    ?>
                    <tr>
                        <td><?= $index++; ?></td>
                        <td><a href="project_<?= $bid0['project_id'] ?>" target="_blank"><?= $p->title; ?></a></td>
                        <td><?= $_ENUM2FA['type'][$p->type]; ?></td>
                        <td><?php echo $persiandate->displayDate($bid0['dateline']) ?></td>

                        <td><?php echo $p->type != 'Agency' ? ($bid0['price'] . 'ریال') : ' - - - ' ?></td>
                        <td><?php echo nl2br($bid0['message']) ?></td>
                        <td><a class="popup" href="bids?detail=1&bid=<?php echo $bid0['id'] ?>"><img src="medias/images/icons/view.png" align="absmiddle" />  نمایش </a></td>

                    </tr>
                <?php } ?>
            </table>
            <?= $pager->pageBreaker(); ?>
        </div>
    </div>
<? } ?>
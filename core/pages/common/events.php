<?php
if ($user->isAdmin() AND isset($_CONFIGS['Params'][1]))
    $uid = $_CONFIGS['Params'][1];
else
    $uid = $user->id;

if(isset($_REQUEST['readall']))
    $event->setReadAll($uid);

$list = $pager->getList('events', '*', $database->whereId($uid, 'user_id') , ' ORDER BY dateline DESC');
?>
<div id="content-wrapper">
    <div id="content">
        <h1>رخدادها</h1>
        <br>
        <a href="events?readall=1" class="active_btn">تایید همه</a>
        <br>
        <br>
        <hr>
        <br>
        <?php if (count($list) == 0) { ?>رخداد جدیدی وجود ندارد.<?php } else { ?>
            <table width="100%" class="projects">
                <tr>
                    <th>ردیف</th>
                    <th>وضعیت</th>
                    <th>عنوان</th>
                    <th>تاریخ</th>
                    <th>عملیات</th>
                </tr>
                <?php $index=1;
                foreach ($list as $ev) { ?>
                    <tr>
                        <!--<td><?php // echo $ev['id'] ?></td>-->
                        <td><?php echo $index++; ?></td>
                        <td><img src="medias/images/icons/bell.gif" width="20" height="20" style="opacity: <?= $ev['readed']?'0.3':'1'; ?>"/></td>
                        <td><a class="popup" onclick="$(this).parent().parent().hide()" href="event_<?php echo $ev['id'] ?>"><?php echo $ev['title'] ?></a></td>
                        <td><?php echo $persiandate->date('d F Y ساعت H:i:s', $ev['dateline']) ?></td>
                        <td><a class="popup" onclick="$(this).parent().parent().hide()" href="event_<?php echo $ev['id'] ?>"><img src="medias/images/icons/view.png" align="absmiddle" />  نمایش </a></td>
                    </tr>
                <?php } ?>
            </table>
        <?= $pager->pageBreaker(); ?>
        <?php } ?>
    </div>
</div>

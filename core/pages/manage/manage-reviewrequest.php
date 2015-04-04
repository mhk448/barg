<?php
if (isset($_POST['submit'])) {
    $_CONFIGS['Params'][1] = $personalmessage->send($user->id, $_POST['toid'], $_POST['t'], $_POST['m'], $_POST['replyto'], $_POST['pid'], $_POST['is_support']);
}
$row = $pager->getParamById('review_requests');
$prj = new Project((int) $row['project_id']);
?>
<div id="content-wrapper">
    <div id="content">
        <h1>مدیریت درخواستهای شکایت</h1>
        <br>
        <table width="100%" class="projects">
            <tr>
                <th>مشخصات</th>
                <th>متن و توضیح</th>
                <th>تاریخ</th>
            </tr>
            <tr class="">
                <td>
                    شاکی:
                    <?= $user->getNickname($row['user_id']) ?><hr/>
                    کارفرما:
                    <a target="_blank" href<?= '="user_' . $prj->user_id . '?refta=review_requests&refid=' . $row['id'] . '&com=بابت درخواست بازبینی پروژه ' . $prj->title . '"' ?>>
                        <?= $user->getNickname($prj->user_id) ?></a><hr/>
                    مجری:
                    <a target="_blank" href<?= '="user_' . $prj->typist_id . '?refta=review_requests&refid=' . $row['id'] . '&com=بابت درخواست بازبینی پروژه ' . $prj->title . '"' ?>>
                        <?= $user->getNickname($prj->typist_id) ?></a><hr/>
                </td>
                <td><?php echo nl2br($row['body']) ?></td>
                <td width="105"><?php echo $persiandate->displayDate($row['dateline']) ?></td>
            </tr>
        </table>

        <form method="post" class="form" action<?= '="manage-reviewrequests_' . $row['id'] . '"' ?> >
            <hr/>
            <label>ارسال پیام به مجری</label>
            <input type="text" readonly="readonly" value="<?= $user->getNickname($prj->typist_id) ?>"/>

            <label>موضوع / عنوان</label>
            <input type="text" name="t" />
            <label>توضیح / پیام</label>
            <textarea name="m" style="width:300px; height:120px;"></textarea>




            <div class="clear"></div>
            <hr/>

            <label>ارسال پیام به کارفرما</label>
            <input type="text" readonly="readonly" value="<?= $user->getNickname($prj->user_id) ?>"/>

            <label>موضوع / عنوان</label>
            <input type="text" name="t" />
            <label>توضیح / پیام</label>
            <textarea name="m" style="width:300px; height:120px;"></textarea>

            <div class="clear"></div>
            <hr/>

            <label>
                جریمه نقدی مجری
            </label>
            <input type="checkbox"/><br/>
            <label>
                درج نشان پروژه ناموفق برای مجری
            </label>
            <input type="checkbox"/><br/>
            <label>
بستن پروژه و آزاد سازی گروگذاری
            </label>
            <input type="checkbox"/>
            <label>
اتمام پروژه و پرداخت دستمزد مجری
            </label>
            <input type="checkbox"/>

            <div class="clear"></div>
            <hr/>
            <input type="hidden" value="ارسال " name="submit" id="submit" />
        </form>



    </div>
</div>

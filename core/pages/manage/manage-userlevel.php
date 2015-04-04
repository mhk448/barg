<?php
$lq = $pager->getParamById('level_q', FALSE);
if ($lq) {
    $a = $userlevel->getAnswer($lq['id']);
    if (isset($_REQUEST['reset'])) {
        $message->conditionDisplay($userlevel->reset($lq['id']));
    } else if (!$a) {
        $message->displayError('نظر دیگری وجود ندارد');
    } else {
        $userlevel->setRead($a['aid']);
        ?>
        <div id="content-wrapper">
            <div id="content">
                <!--<div style="width: 300px;display: inline-block;">-->
                <? // $lq['question']  ?>
                <!--</div>-->
                <div style="width: 500px;display: inline-block;">
                    <a href<?='="user_'.$a['user_id'].'"'?> target="_blank"><?= $user->getNickname($a['user_id']); ?></a>
                    <hr>
                    <p><?= $a['answer_0'] ?></p>
                    <p><?= $a['answer_1'] ?></p>
                    <p><?= $a['answer_2'] ?></p>
                    <p><?= $a['answer_3'] ?></p>
                    <p><?= $a['answer_4'] ?></p>
                    <p><?= $a['answer_5'] ?></p>
                </div>
                <hr>
                <a class="popup active_btn" href<?= '="manage-userlevel_' . $lq['id'] . '"' ?>>
                    بعدی
                </a>
            </div>
        </div>  
        <?
    }
} else {
    $list = $pager->getList('level_q', '*', $where, ' ORDER BY id');
    ?>
    <div id="content-wrapper">
        <div id="content">
            <h1>مدیریت نظرسنجی و اطلاع رسانی</h1>
            <hr>
            <br>
            <table width="100%" class="projects">
                <tr>
                    <th>سوال</th>
                    <th>تعداد کل</th>
                    <th>عملیات</th>
                </tr>
                <?php
                $i = 0;
                foreach ($list as $row) {
                    ?>
                    <tr class="">
                        <td><?php echo $row['question'] ?></td>
                        <td>
                            <?php echo $userlevel->countAllAnswer($row['id']) ?>
                            کل
                            <br/>
                            <?php echo $userlevel->countNewAnswer($row['id']) ?>
                            جدید
                        </td>
                        <td>
                            شناسه
                            <?= $row['id'] ?>
                            <br/>
                            گروه
                            <?= $row['user_type'] ?>
                            <br/>
                            زمان
                            <?= $row['interval'] ?>
                            <br/>
                            سپس
                            <?= $row['next_level'] ?>
                            <br/>

                            <a class="ajax" href<?= '="manage-userlevel-answer_q_' . $row['id'] . '"' ?>>
                                <img src="medias/images/icons/bid.png" align="absmiddle" /> 
                                لیست
                            </a>
                            <br/>
                            <a class="popup" href<?= '="manage-userlevel_' . $row['id'] . '"' ?>>
                                <img src="medias/images/icons/bid.png" align="absmiddle" /> 
                                نمایش
                            </a>
                            <br/>
                            <a class="popup" href<?= '="manage-userlevel_' . $row['id'] . '?reset=1"' ?>>
                                <img src="medias/images/icons/cross.png" align="absmiddle" /> 
                                ریست
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
            <?= $pager->pageBreaker(); ?>
        </div>
    </div>
<?php } ?>


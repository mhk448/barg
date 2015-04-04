<?php

/* @var $database Database */
/* @var $cdatabase Database */
/* @var $user User */
/* @var $message Message */

if (isset($_POST['submit'])) {
    $_CONFIGS['Params'][1] = $personalmessage->send($user->id, $_POST['toid'], $_POST['t'], $_POST['m'], $_POST['replyto'], $_POST['pid'], $_POST['is_support'], $_POST['attach']);
}

$m = $pager->getComParamById('messages');

if (!($m['from_id'] == $user->id || $m['to_id'] == $user->id || $user->isAdmin() || ($user->hasFeature(User::$F_SUPPORT) AND $m['is_support']))) {
    Report::addLog("Error page ");
    header('Location: error');
    exit;
}
if ($m['to_id'] == $user->id) {
    $personalmessage->setRead($m['id']);
}
?>
<div id="content-wrapper">
    <div id="content">

        <h1>پیام ها</h1>
        <br>
        <?php $message->display() ?>
        <?
        do {
            $m0 = $pager->getComParamById('messages');
            $_CONFIGS['Params'][1] = $m0['reply_id'];
            if ($m['from_id'] == $user->id) {
                $m = $m0;
            }
            if ($m['is_support'] && !$user->hasFeature(User::$F_SUPPORT))
                $m['from_id'] = User::$SUPORT;
            if ($m0['is_support'] && !$user->isAdmin()) {
                if ($m0['from_id'] == $user->id)
                    $m0['to_id'] = User::$SUPORT;
                if ($m0['to_id'] == $user->id)
                    $m0['from_id'] = User::$SUPORT;
            }

            if ($m0['verified'] < 0) {
                continue;
            }
            ?>
            <div class="" style="display:inline-block;width: 80%;border: 1px dotted #000;padding: 10px;margin: 5px;">
                <div class="bg-theme" style="padding: 3px;margin: -5px">


                    <div style="float: left;"> 
                        <?php echo $persiandate->displayDate($m0['dateline']) ?>
                    </div>

                    <? if ($m0['from_id'] != $user->id) { ?>
                        <img class="user-avator" style="float: right;margin: 5px;" src<?= '="' . $_CONFIGS['Site']['Path'] . 'user/avatar/UA_' . $m0['from_id'] . '.png"' ?> width="40" height="40" >
                        <div style="float: right;"> 
                            از طرف: 
                            <br>
                            <a href="user_<?= $m0['from_id'] ?>" style="color: green;" class="popup" target="_blank">
                                <?php echo $user->getNickname($m0['from_id']) ?>    
                            </a>
                        </div>
                    <? } ?>
                    <? if ($m0['to_id'] != $user->id) { ?>
                        <img class="user-avator" style="float: right;margin: 5px;" src<?= '="' . $_CONFIGS['Site']['Path'] . 'user/avatar/UA_' . $m0['to_id'] . '.png"' ?> width="40" height="40" >
                        <div style="float: right;"> 
                            به: 
                            <br>
                            <a href="user_<?= $m0['to_id'] ?>" style="color: green;" class="popup" target="_blank">
                                <?php echo $user->getNickname($m0['to_id']) ?>    
                            </a>
                        </div>
                    <? } ?>
                    <h1>
                        <a href<?= '="message_' . $m0['id'] . '"'; ?>>
                            <?php echo $m0['title'] ?>
                        </a>
                    </h1>
                    <div class="clear"></div>
                </div>
                <!--<hr/>-->

                <p style="text-align: justify;padding: 20px;min-height: 100px;">
                    <?php echo nl2br($m0['body']) ?>
                </p>

                <div class="bg-theme" style="padding: 3px;margin: -5px;text-align: right">
                    <?php if ($m0['attached_file'] != '') { ?>
                        <b>فایل ضمیمه :‌ </b> 
                        <a href="uploads/message/<?php echo $m0['attached_file'] ?>">دانلود</a> 
                        <?php
                    }
                    ?>

                </div>

                <div class="bg-theme" style="padding: 3px;margin: -5px;text-align: left">
                    <?php if ($m0['project_id'] > 0) { ?>
                        <b> پروژه ی پیوست :‌ </b> 
                        <a href="project_<?php echo $m0['project_id'] ?>" class="">
                            <?= $project->getTitle($m0['project_id']) ?>
                        </a> 
                    <?php } ?>
                </div>

                <div class="clear"></div>
            </div>
            <br>
            <br>
            <hr>
            <br>

            <?
        } while ($m0['reply_id']);
        ?>

        <div class="clear"></div>

        <? if ($m['from_id'] != $user->id) { ?>

            <div style="padding: 10px 20px;">
                <? if (!$m['is_support']) { ?>
                    <b>نکات:‌</b>
                    <ul class="disc">
                        <li>توجه نمایید که ارسال هرگونه
                            <span style="color: red">
                                شماره تماس، تلفن، آدرس، ایمیل و سایر راههای ارتباطی
                            </span>
                            بر طبق قوانین 
                            <?= $_CONFIGS['Site']['Sub']['NickName']; ?>
                            <span style="color: red">
                                ممنوع
                            </span>
                            بوده و با متخلفین به شدت برخورد خواهد شد.</li>
                    </ul>
                <? } ?>
            </div>		
            <form method="post" class="form" action="message" >

                <h1>ارسال پاسخ <?php echo ((isset($_CONFIGS['Params'][2]) && $_CONFIGS['Params'][2] == 'S1') ? '[ درخواست پشتیبانی ]' : '') ?></h1>
                <input type="hidden" name="toid" value="<?php echo $m['from_id'] ?>" />
                <input type="hidden" name="pid" value="<?= $m['project_id'] ?>" />
                <input type="hidden" name="is_support" value="<?= $m['is_support'] ?>" />
                <input type="hidden" name="replyto" value="<?php echo $m['id'] ?>" />
                <label>به کاربر</label>
                <input type="text" value="<?php echo $user->getNickname($m['from_id']); ?>" readonly="readonly" disabled="disabled" />
                <label>موضوع / عنوان</label>
                <?
                $a = 'پاسخ به:';
                $t = mb_strpos($m['title'], $a, 0, "UTF-8");
                if ($t === FALSE) {
                    $t = $a . $m['title'];
                } else {
                    $t = $m['title'];
                }
                ?>
                <input type="text" name="t" value="<?php echo $t ?>" />
                <label>توضیح / پیام</label>
                <textarea name="m" style="width:300px; height:120px;"></textarea>
                <label>فایل ضمیمه (ZIP)</label>
                <?= uploadFild('attach', '', 'message', 1024 * 1024 * 20, 'x-zip|x-office|x-pic') ?>
                <label> </label>
                <input type="submit" value="ارسال پیام" name="submit" id="submit" />
            </form>
            <div class="clear"></div>
        <? } ?>
    </div>
</div>

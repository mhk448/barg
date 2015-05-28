<?php
$pid = -1;
if (!isset($_CONFIGS['Params'][1]) || !$_CONFIGS['Params'][1]) {
    $u = NULL;
    $support = FALSE;
} else {
    $u = $pager->getComParamById('users');
    if (isset($_CONFIGS['Params'][2])) {
        if ($_CONFIGS['Params'][2] == 'S1') {
            $title = 'در خواست پشتیبانی';
            $support = isset($_POST['support']) ? $_POST['support'] : '1';
        } else if ($_CONFIGS['Params'][2] == 'S2') {
            $title = 'ارسال نظرات';
            $support = '2';
        } else {
            $pid = intval($_CONFIGS['Params'][2]);
            $support = FALSE;
        }
    }
}
if ($support) {
    $u['id'] = User::$SUPORT;
}
if (isset($_POST['submit'])) {
    $personalmessage->send($user->id, (int) ($u ? $u['id'] : $_POST['to']), $_POST['t'], $_POST['m'], 0, $_POST['pid'], $support, $_POST['attach']);
}

if (isset($_POST['submit']) && $pid != -1) {
    $_CONFIGS['Params'][1] = $_CONFIGS['Params'][2];
    include 'core/pages/common/project.php';
} else {
    ?>
    <div id="content-wrapper">
        <div id="content">
            <h1>  <?php echo ( $support ? $title : 'ارسال پیام') ?></h1><hr/>
            <script type="text/javascript">
                function showTypist(){
                    mhkform.ajax('user-list_worker&ajax=1');
                }
                function showUsers(){
                    mhkform.ajax('user-list_user&ajax=1');
                }
                function showAdmins(){
                    mhkform.ajax('user-list_admin&ajax=1');
                }
                function selectUser(id,username){
                    $('[name="to"]').val(id);
                    $('#tousername').val(username);
                    $('#tousername').show();
                                                                                        
                    //                $('#selectUser').hide();
                    //                $('#selectTypist').hide();
                    mhkform.close();
                }
                                                                                    
            </script>

            <?php $message->display() ?>
            <div style="">
                <ul class="disc">
                    <b>نکات:‌</b>
                    <? if (!$support) { ?>
                        <li>توجه نمایید که ارسال هرگونه
                            <span style="color: red">
                                شماره تماس، تلفن، آدرس، ایمیل و سایر راههای ارتباطی
                            </span>
                            بر طبق قوانین این مرکز 
                            <span style="color: red">
                                ممنوع
                            </span>
                            بوده و با متخلفین به شدت برخورد خواهد شد.</li>
                    <? } elseif ($support == '1') { ?>
                        <li>
                            قبل از ارسال درخواست، با سایر کاربران در 
                            <a href="twitts">
                                توئیت
                            </a>
                            به صورت آنلاین مشورت نمایید
                        </li>
                    </ul>
                <? } ?>
            </div>   

            <form method="post" class="form" action<?= '="' . getCurPageName() . '"'; ?> >
                <input type="hidden" name="toid" value="<?php echo $u['id'] ?>" />
                <input type="hidden" name="pid" value="<?= $pid ?>" />
                <? if (!$u) { ?>
                    <input  type="hidden"  name="to" >
                    <label></label>
                    <input type="button" id="selectTypist" onclick="showTypist()" value="انتخاب <?= $_ENUM2FA['fa']['worker']; ?> "/>
                    <label></label>
                    <input type="button" id="selectUser" onclick="showUsers()" value="انتخاب کارفرما"/>
                    <? if ($user->isAdmin()) { ?>
                        <label></label>
                        <input type="button" id="selectAdmin" onclick="showAdmins()" value="انتخاب مدیر"/>
                    <? } ?>
                    <label>به کاربر:</label>
                    <input type="button" style="display: none" id="tousername" onclick="" />
                <? } else if (!$support) { ?>
                    <label>به کاربر:</label>
                    <input  type="hidden"  name="to" value="<?= $u['id'] ?>" >
                    <input type="text" value="<?= $user->getNickname($u['id']) ?>" disabled="disabled" readonly="readonly" />
                <? } else { ?>
                    <input  type="hidden"  name="to" value="<?= $u['id'] ?>" >
                    <input type="hidden" value="<?= $user->getNickname($u['id']) ?>"  />
                    <? if ($support == 1) { ?>
                        <label>موضوع:</label>
                        <select name="support">
                            <option value="3">
                                پشتیبانی در زمینه پروژه‌ها
                            </option>
                            <option value="4">
                                پشتیبانی فنی مرکز
                            </option>
                            <option value="5">
                                پشتیبانی مالی مرکز
                            </option>
                            <option value="1">
                                سایر
                            </option>
                        </select>
                    <? } ?>
                <? } ?>
                <label>عنوان:</label>
                <input type="text" name="t" required="required"/>
                <label>توضیح / پیام:</label>
                <textarea name="m" style="width:300px; height:120px;"></textarea>
                <? if (!$support) { ?>
                    <label>فایل ضمیمه (ZIP):</label>
                    <?= uploadFild('attach', '', 'message', 1024 * 1024 * 20, 'x-zip|x-office|x-pic', 1) ?>
                <? } ?>
                <label> </label>
                <input class="wait_fl" type="submit" value="ارسال پیام" name="submit" id="submit" />
            </form>
            <div class="clear"></div>
        </div>
    </div>
    <?
}?>
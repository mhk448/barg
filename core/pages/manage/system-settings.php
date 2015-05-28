<?php
//if (!$user->isSuperAdmin())
if (!$user->isAdmin())
    return;


if (isset($_REQUEST['submit'])) {
    if (isset($_POST['qCom'])) {
        if ($_POST['pass'] == '8813176035') {
            $res = $database->fetchAll($cdatabase->runQuery($_POST['qqCom']));
            $message->addMessage('کوئری مشترک انجام شد');
        }
    } elseif (isset($_POST['qCur'])) {
        if ($_POST['pass'] == '8813176035') {
            $res = $database->fetchAll($database->runQuery($_POST['qqCur']));
            $message->addMessage('کوئری زیربخش انجام شد');
        }
    } elseif (isset($_POST['qOld'])) {
        if ($_POST['pass'] == '8813176035') {
            $oldDatabase = new Database($_CONFIGS['Database']['Server'], $_CONFIGS['Database']['User'], $_CONFIGS['Database']['Password'], 'mhk_elmend_old');
            $res = $database->fetchAll($oldDatabase->runQuery($_POST['qqOld']));
            $message->addMessage('کوئری قدیمی انجام شد');
        }
    } elseif (isset($_POST['update'])) {
        $user->checkAll();
        $project->checkAll();
        // nc? other
    } elseif (isset($_REQUEST['code'])) {
//        include 'system-settings-code.php';
    } elseif (isset($_REQUEST['setting'])) {
        $message->conditionDisplay($system->update($_REQUEST['n'], $_REQUEST['v'], $_REQUEST['c']));
    }
}
$settings = $system->getAll();
?>
<div id="content-wrapper">
    <div id="content">
        <h1>تنظیمات سیستم</h1>
        <?php $message->display() ?>
        <? if (!isset($_CONFIGS['Params'][1])) { ?>
            <table  class="projects">
                <tr>
                    <th>محل</th>
                    <th>نام</th>
                    <th>مقدار</th>
                    <th>توضیح</th>
                    <th>عملیات</th>
                </tr>
                <? foreach ($settings as $setting) { ?>
                    <form method="post" class="form"  action="system-settings">
                        <tr>
                            <td><?= $setting['sub']; ?></td>
                            <td><?= $setting['name']; ?></td>
                            <td>
                                <input type="text" name="v" value="<?= $setting['value'] ?>" />
                            </td>
                            <td>
                                <input type="text" name="c" value="<?= $setting['comment'] ?>" />
                            </td>
                            <td>
                                <input type="hidden" name="n" value="<?= $setting['name'] ?>" />
                                <input type="hidden" name="setting" value="setting" />
                                <input type="submit" name="submit" value="save" />
                            </td>
                        </tr>
                    </form>
                    <?php
                }
                ?>
            </table>

        <? } else { ?>
            <div>
                <h1>نتایج</h1>
                <?
                print_r($res);
                ?>
            </div>

            <form method="post" class="form"  action="system-settings_db">
                <label>عمومی</label>
                <input type="hidden" name="qCom" value="1"/>
                <input type="password" name="pass" value="8813176035"/>
                <label></label>
                <textarea name="qqCom" style="width: 600px;direction: ltr;" rows="8"><?= $_POST['qqCom'] ?></textarea><br/>
                <label></label>
                <input type="submit" value="ارسال" name="submit" id="submit" />
            </form>

            <form method="post" class="form"  action="system-settings_db">
                <label>زیر بخش</label>
                <input type="hidden" name="qCur" value="1"/>
                <input type="password" name="pass" value="8813176035"/>
                <label></label>
                <textarea name="qqCur" style="width: 600px;direction: ltr;" rows="8"><?= $_POST['qqCur'] ?></textarea><br/>
                <label></label>
                <input type="submit" value="ارسال" name="submit" id="submit" />
            </form>
            <div class="clear"></div>

            <form method="post" class="form"  action="system-settings_db">
                <label>وب سایت قدیم</label>
                <input type="hidden" name="qOld" value="1"/>
                <input type="password" name="pass" value="8813176035"/>
                <label></label>
                <textarea name="qqOld" style="width: 600px;direction: ltr;" rows="8"><?= $_POST['qqOld'] ?></textarea><br/>
                <label></label>
                <input type="submit" value="ارسال" name="submit" id="submit" />
            </form>
            <div class="clear"></div>

            <form method="post" class="form"  action="system-settings">
                <input type="hidden" name="update" value="1"/>
                <label></label>
                <input type="submit" value="به روز رسانی و پاکسازی" name="submit" id="submit" />
            </form>
            <div class="clear"></div>

            <form method="post" class="form"  action="system-settings">
                <input type="hidden" name="code" value="adduser"/>
                <label></label>
                <input type="submit" value="اجرای کرکتور" name="submit" />
            </form>
            <div class="clear"></div>
        <? } ?>
    </div>
</div>

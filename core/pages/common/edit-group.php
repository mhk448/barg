<?php
/* @var $group Group */
/* @var $user User */
/* @var $message Message */



if ($user->isAdmin() && isset($_CONFIGS['Params'][1])) {
    $u = new User($_CONFIGS['Params'][1]);
} else {
    $u = $user;
}
if ($_REQUEST['invitemember']) {
    if ($_REQUEST['gid'] > 0 AND $_REQUEST['uid'] > 0) {
        $g = new Group(intval($_REQUEST['gid']));
        $g->inviteUser(intval($_REQUEST['uid']));
    }
} elseif ($_REQUEST['removemember']) {
    if ($_REQUEST['gid'] > 0 AND $_REQUEST['uid'] > 0) {
        $g = new Group(intval($_REQUEST['gid']));
        $g->removeUser(intval($_REQUEST['uid']));
    }
} elseif ($_REQUEST['acceptmember']) {
    if ($_REQUEST['gid'] > 0 AND $_REQUEST['uid'] > 0) {
        $g = new Group(intval($_REQUEST['gid']));
        $g->acceptUser(intval($_REQUEST['uid']));
    }
}

if ($auth->validate('AddGroupForm', array(
            array('gt', 'Required', 'یک عنوان مناسب برای گروه انتخاب نمایید')))) {
    $group->add($u->id, $_POST['gt'], 'gi');
} else if ($auth->validate('EditGroupForm', array(
            array('gt', 'Required', 'یک عنوان مناسب برای گروه انتخاب نمایید')))) {
    $ge = new Group($_POST['gid']);
    $ge->update($_POST['gt'], 'gi');
}
$groups = $u->getGroups(TRUE);
?>
<div id="content-wrapper">
    <div id="content">
        <h1>گروه های کاری</h1>
        <hr/>
        <div style="text-align: right">
            <b>نکات:‌</b>
            <ul class="disc">
                <li>هر کاربر می تواند عضو یک گروه باشد و یا یک گروه جدید ایجاد نماید</li>
                <li>هر گروه حداقل سه عضو و حداکثر پنج عضو می تواند داشته باشد</li>
                <li>پس از عضویت در یک گروه می توانید پروژه های  درحال اجرای خودتان را با اعضای گروه به اشتراک بگذارید</li>
                <li>هر گروه دارای توئیت اختصاصی می باشد</li>
                <li>قبل از ایجاد گروه به <u> <a href="http://blog.bargardoon.com/type/type-learn/%D8%B1%D8%A7%D9%87%D9%86%D9%85%D8%A7%DB%8C-%DA%AF%D8%B1%D9%88%D9%87-%D9%87%D8%A7%DB%8C-%DA%A9%D8%A7%D8%B1%DB%8C/">صفحه راهنما</a> </u>مراجعه نمایید.</li>
                <li> لیست سایر گروه‌ها را می توانید  <u> <a href="group-list"> اینجا</a> </u>مشاهده نمایید.</li>
            </ul>
        </div>
        <br/>
        <br/>
        <hr/>
        <br/>
        <?= $message->display() ?>
        <? if ($groups) { ?>
            <script type="text/javascript">
                function selectUser(id,username){
                    $('#typist_id').val(id);
                    $('#typistusername').val("دعوت از "+username);
                    mhkform.close();
                    $('#inviteBtn').show();
                }    
            </script>

            <?
            foreach ($groups as $ga) {
                $g = new Group($ga['id']);
                $countActieMem=count($g->getMembers());
                $isCreator = (($u->id == $g->creator) || $user->isAdmin());
                ?>
                <br>
                <div class="group_info_<?= $g->id ?>">
                    <h2>
                        <? if ($u->id == $g->creator) { ?>
                       گروه‌ی که من ایجاد کرده‌ام
                        <? } else { ?>
                            گروه هایی که به عضویت در آن دعوت شده‌اید
                        <? } ?>
                    </h2>
                    <div style="display: inline-block;">
                        <h2>
                            گروه 
                            <?= $g->title ?></h2>
                        <img src<?= '="uploads/' . $subSite . '/group/GL_' . $g->id . '.png?v=' . rand(0, 9) . '"' ?> width="100" height="100">
                    </div>
                    <div style="display: inline-block">
                        <table align="center" class="projects">
                            <tr>
                                <th style="width: 100px">ردیف</th>
                                <th style="width: 150px">کاربر</th>
                                <th style="width: 90px">وضعیت</th>
                                <th style="width: 180px">عملیات</th>
                            </tr>
                            <tr style="color: blue;font-weight: bold">
                                <td>1</td>
                                <td><?= $user->getNickname($g->creator); ?></td>
                                <td>سازنده گروه</td>
                                <td>
                                    <? if ($isCreator) { ?>
                                        <? if ($countActieMem) { ?>
                                            <a class="active_btn" onclick="$('.group_info_<?= $g->id ?>').slideToggle();">
                                                ویرایش
                                            </a>
                                            <a class="delete_btn" href<?= '="edit-group?removemember=1&gid=' . $g->id . '&uid=' . $g->creator . '"' ?>>
                                                حذف
                                            </a> 
                                        <? } else { ?>
                                            <a class="active_btn" href<?= '="edit-group?acceptmember=1&gid=' . $g->id . '&uid=' . $g->creator . '"' ?>>
                                            فعال سازی 
                                            </a> 
                                        <? } ?>
                                    <? } else { ?>
                                    <? } ?>
                                </td>
                            </tr>
                            <?php
                            $members = $g->getMembers(TRUE);
                            $index = 2;
                            foreach ($members as $mem_a) {

                                $mem = new User($mem_a['user_id']);
                                if ($mem->id != $g->creator) {
                                    ?>
                                    <tr>
                                        <td><?= $index++; ?></td>
                                        <td><?= $mem->getNickname(); ?></td>
                                        <td><?= $_ENUM2FA['verified'][$mem_a['verified']] ?></td>
                                        <td>
                                            <? if ($user->id == $mem->id OR $user->isAdmin()) { //$user->id == $g->creator OR?>
                                                <? if ($mem_a['verified'] != Event::$V_DELETE) { ?>
                                                    <a class="delete_btn" href<?= '="edit-group?removemember=1&gid=' . $g->id . '&uid=' . $mem->id . '"' ?>>
                                                        حذف
                                                    </a> 
                                                <? } ?>
                                            <? } ?>
                                            <? if ($user->id == $mem->id OR $user->isAdmin()) { ?>
                                                <? if ($mem_a['verified'] != Event::$V_ACC) { ?>
                                                    <a class="active_btn" href<?= '="edit-group?acceptmember=1&gid=' . $g->id . '&uid=' . $mem->id . '"' ?>>
                                                        تایید
                                                    </a>
                                                <? } ?>
                                            <? } ?>
                                        </td>
                                    </tr>
                                <? } ?>
                            <? } ?>
                            <? if ($countActieMem>0 && $user->id == $g->creator OR $user->isAdmin()) { ?>
                                <tr>
                                    <td><?= $index++; ?></td>
                                    <td>
                                        <input  type="hidden"  name="typist_id" id="typist_id" value="" >
                                        <input class="help" id="typistusername" style="width: 200px" type="button" value="دعوت از <?= $_ENUM2FA['fa']['worker'];?> " onclick="mhkform.ajax('user-list_worker&ajax=1')">
                                        <div class="help_comment">
                                          <?= $_ENUM2FA['fa']['worker'];?>   
                                            مورد نظر خود را از لیست انتخاب کنید
                                        </div>
                                    </td>
                                    <td></td>
                                    <td>
                                        <a class="active_btn" id="inviteBtn" onclick="mhkform.redirect('edit-group?invitemember=1&gid=<?= $g->id; ?>&uid=' + $('#typist_id').val(), false);" style="display: none;">
                                            ارسال دعوتنامه
                                        </a>
                                    </td>
                                </tr>     
                            <? } ?>
                        </table>
                    </div>
                    <div class="clear"></div>
                </div>
                <? if ($isCreator) { ?>
                    <div class="group_info_<?= $g->id ?>" style="padding-right: 30px;display: none">
                        <form method="post" class="form" action="edit-group" enctype="multipart/form-data">
                            <input type="hidden" name="formName" value="EditGroupForm" />
                            <label class="help" >
                                عنوان گروه:
                            </label>
                            <input class="help" type="text" name="gt" value="<?= $g->title; ?>" />
                            <div class="help_comment" >
                                برای گروه خود یک عنوان مناسب انتخاب نمایید
                            </div>
                            <label class="help" >
                                تصویر گروه:
                            </label>
                            <input type="file" name="gi" class="help"/>
                            <div class="help_comment" >
                                برای گروه خود یک لوگو مناسب انتخاب نمایید
                            </div>
                            <input type="hidden" name="gid" value="<?= $g->id ?>"/>
                            <label></label>
                            <input type="submit" name="submit" value="ثبت"/>
                            <input type="button" onclick="$('.group_info_<?= $g->id ?>').slideToggle();" value="لغو"/>

                        </form>
                    </div>
                    <div class="clear"></div>
                <? } ?>
                <br/>
                <hr/>
            <? } ?>
        <? } ?>
        <? if (count($u->getGroups()) < Group::$maxGroup) { ?>
            <h2>ساخت گروه جدید</h2>
            <form method="post" class="form" action="edit-group" enctype="multipart/form-data">
                <input type="hidden" name="formName" value="AddGroupForm" />
                <label class="help" >
                    عنوان گروه:
                </label>
                <input class="help" type="text" name="gt" value="" />
                <div class="help_comment" >
                    برای گروه خود یک عنوان مناسب انتخاب نمایید
                </div>
                <label class="help" >
                    تصویر گروه:
                </label>
                <input type="file" name="gi" class="help"/>
                <div class="help_comment" >
                    برای گروه خود یک لوگو مناسب انتخاب نمایید
                </div>
                <label></label>
                <input type="submit" name="submit" value="ساخت گروه جدید"/>
            </form>
            <div class="clear"></div>
            <br/>
            <br/>
        <? } ?>

    </div>
</div>

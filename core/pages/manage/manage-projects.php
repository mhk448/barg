<?php
if (isset($_REQUEST['change'])) {
    if (isset($_REQUEST['verified'])) {
        $p = new Project($_REQUEST['prj_id']);
        $p->setVerifiedAndSendEvent($_REQUEST['verified']);
        echo 'عمیات انجام شد';
    }
    if (isset($_REQUEST['state'])) {
        $p = new Project($_REQUEST['prj_id']);
        $p->setStateAndSendEvent($_REQUEST['state']);
        echo 'عمیات انجام شد';
    }
} else {

    $where = 'WHERE TRUE ';
    $k = '';
    if (isset($_GET['k'])) {
        $k = $_GET['k'];
        $where .= " AND (title LIKE '%$k%' OR description LIKE '%$k%') ";
    }

    if (isset($_REQUEST['new']))
        $where .= ' AND verified= ' . (int) $_REQUEST['new'];

    if (isset($_CONFIGS['Params'][1]))
        $where .= " AND state='" . ucfirst($_CONFIGS['Params'][1]) . "' ";


    $where .= " ORDER BY id DESC ";
//nc? query in ui!!!!!!!!!!! 
    $list = $pager->getList('projects', '*', $where,"",NULL,70);
    ?>
    <div id="content-wrapper">
        <div id="content">
            <script type="text/javascript">
                function changeVerified(cur,pid,v){
                    if(v!=-1||window.confirm("آیا مطمئن هستید؟")){
                        mhkform.ajax('manage-projects?ajax=1&change=1&verified='+v+'&prj_id='+pid); 
                        $(cur).parent().parent().css("background-color",'yellow');
                        $(cur).remove();
                    }
                }
                function changeState(cur,pid,s){
                                            
                    mhkform.ajax('manage-projects?ajax=1&change=1&state='+s+'&prj_id='+pid); 
                    $(cur).parent().parent().css("background-color",'yellow');
                    $(cur).remove();
                }
            </script>
            <h1>مدیریت پروژه ها</h1><br/>
            <a class="active_btn" href="manage-projects" >همه</a>
            <a class="active_btn" href="manage-projects_open" >باز</a>
            <a class="active_btn" href="manage-projects_close">بسته</a>
            <a class="active_btn" href="manage-projects_run">در حال اجرا</a>
            <a class="active_btn" href="manage-projects_finish">پایان یافته</a>
            <a class="active_btn" href="manage-projects?new=-1">حذف شده</a>
            <a class="active_btn" href="manage-projects?new=-2">ویرایش</a>
            <? // echo $pager->showSearchBox();  ?>
            <form method="get" class="form" action="manage-projects">
                <label>کلمه کلیدی</label>
                <input type="text" name="k" value="<?php echo $k ?>" />
                <input type="submit" value="جستجو" name="submit" id="submit" style="margin-right:20px;" />
            </form>
            <div class="clear"></div>
            <br>
            <table width="100%" class="projects">
                <tr>
                    <th>شناسه</th>
                    <th>عنوان</th>
                    <th>فرستنده</th>
                    <th>وضعیت</th>
                    <th>مجری</th>
                    <th>قیمت تایید شده</th>
                    <th width="110px">تاریخ ارسال</th>
                    <th width="110px">عملیات</th>
                </tr>
                <?php
                $i = 0;
                foreach ($list as $row) {
                    ?>
                    <tr class="">
                        <td><?php echo $row['id'] ?></td>
                        <td><a href="project_<?php echo $row['id'] ?>" style="display:block"><?php echo $row['title'] ?></a></td>
                        <td><a target="_blank" href="user_<?php echo $row['user_id'] ?>"><?= $user->getNickname($row['user_id']) ?></a></td>
                        <td><?php echo $row['state'] ?></td>
                        <td><a target="_blank" href="user_<?php echo $row['typist_id'] ?>"><?= $user->getNickname($row['typist_id']) ?></a></td>
                        <td><?= $row['accepted_price'] ?></td>
                        <td><?php echo $persiandate->date('d F Y ساعت H:i:s', $row['submit_date']) ?></td>
                        <td class="admin_action">
                            <? if ($row['verified'] != 1) { ?>
                                <a  onclick="changeVerified(this,<?= $row['id'] ?>,1)" >
                                    <img src="medias/images/icons/tick.png" align="absmiddle" /> تایید</a>
                                <br/>
                            <? } ?>
                            <? if (false && $row['verified'] != -1) { ?>
                                <a  onclick="changeVerified(this,<?= $row['id'] ?>,-1)" >
                                    <img src="medias/images/icons/cross.png" align="absmiddle" /> حذف</a>
                                <br/>
                            <? } ?>
                            <? if ($row['verified'] != -2) { ?>
                                <a  onclick="changeVerified(this,<?= $row['id'] ?>,-2)" >
                                    <img src="medias/images/icons/edit.png" align="absmiddle" /> نیاز به ویرایش</a>
                                <br/>
                            <? } ?>
                            <? if ($row['state'] != 'Close') { ?>
                                <a  onclick="changeState(this,<?= $row['id'] ?>,'Close')">
                                    <img src="medias/images/icons/close.png" align="absmiddle" /> بستن</a>
                                <br/>
                            <? } ?>
        <!--                            <a href="#" onclick="changeState(this,<? // echo $row['id']     ?>,'Open')">
                    <img src="medias/images/icons/open.png" align="absmiddle" /> باز کردن</a>-->


                        </td>
                    </tr>
                <?php } ?>
            </table>
            <?= $pager->pageBreaker(); ?>
        </div>
    </div>
<? } ?>
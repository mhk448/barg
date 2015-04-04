<?php
if (isset($_CONFIGS['Params'][1])) {
    $u = $pager->getComParamById('users');
    $list = $pager->getList('user_visit', '*', ' where user_id=' . $u['id'], ' ORDER BY date DESC');
    ?>
    <div id="content-wrapper">
        <div id="content">
            <h1>مسیر</h1>
            <div class="clear"></div>
            <br>
            <table  class="projects">
                <tr>
                    <th>n</th>
                    <th>صفحه ی </th>
                    <th>آی پی</th>
                    <th>زمان</th>
                </tr>
                <?php
                $i = 1;
                foreach ($list as $row) {
                    $u = new User($row['user_id']);
                    ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td class="english"><a href<?= '="' . $row['page'] . '"' ?> class="popup"><?php echo $row['page'] ?></a></td>
                        <td><?= $row['ip'] ?></td>
                        <td><?php echo $persiandate->displayDate($row['date']) ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <?= $pager->pageBreaker(); ?>
        </div>
    </div>
    <?
} else {
    $list = $pager->getList('user_visit', '*', ' where date > ' . (time() - (30 * 60)) . ' ', ' ORDER BY date DESC', '', 1000);
    ?>
    <style>
        .bg_Worker {background-color: #ffcccc !important;}
        .bg_Agency {background-color: #ffff99 !important;}
        .bg_User {background-color: #99ff99 !important;}
    </style>
    <script type="text/javascript">
        function autoRef(){
            mhkform.ajax('manage-users-online?ajax=1','#ajax_content');
        }
        setTimeout(autoRef,40000);
    </script>
    <div id="content-wrapper">
        <div id="content">
            <h1> کاربران آنلاین</h1>
            <div class="clear"></div>
            <br>
            <table  class="projects">
                <tr>
                    <th>n</th>
                    <th>شناسه</th>
                    <th>نام کاربری</th>
                    <th>نوع</th>
                    <!--<th>وضعیت</th>-->
                    <th>نام</th>
                    <th>نام مستعار</th>
                    <!--<th>پست الکترونیک</th>-->
                    <th>صفحه ی در حال مشاهده</th>
                    <th>زمان</th>
                </tr>
                <?php
                $i = 1;
                $v = array();
                foreach ($list as $row) {
                    if (!isset($v['u' . $row['user_id']])) {
                        $v['u' . $row['user_id']] = 1;
                        $u = new User($row['user_id']);
                        ?>
                        <tr class="bg_<?= $u->usergroup ?>">
                            <td><?= $i++; ?></td>
                            <td><?php echo $u->id ?></td>
                            <td class="username"><a target="_blank" class="" href<? echo '="user_' . $u->id . '"' ?> style="display:block"><?php echo $u->username ?></a></td>
                            <td><?php echo $_ENUM2FA['usergroup'][$u->usergroup] ?></td>
                            <!--<td><?php // echo $_ENUM2FA['state'][$u->state]      ?></td>-->
                            <td><?php echo $u->fullname ?></td>
                            <td><?php echo $u->nickname ?></td>
                            <!--<td class="username"><?php // echo $u->email      ?></td>-->
                            <td class="username"><a href<?= '="' . $row['page'] . '"' ?> class="popup"><?php echo $row['page'] ?></a></td>
                            <td><?php echo $persiandate->date('H:i:s', $row['date']) ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </table>
        </div>
    </div>
<?php } ?>

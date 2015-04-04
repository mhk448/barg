<?php
//$projects_list_1 = $project->getList(" AND type ='Agency'");
//$projects_list_2 = $project->getList(" AND type <>'Agency'");
//if($_CONFIGS['Params'][1]=='open') {


if (isset($_CONFIGS['Params'][1]) && $_CONFIGS['Params'][1] == "open" && !$my_prj) {
    $ulist = $pager->getList('user_visit', '*', ' where date > ' . (time() - (30 * 60)) . ' ', ' ORDER BY date DESC', '', 2000);

    $v = array();
    $user_online = '';
    foreach ($ulist as $row) {
        if (!isset($v['u' . $row['user_id']]) && $row['user_id'] > 100) {
            $v['u' . $row['user_id']] = 1;
            $u0 = new User($row['user_id']);
            $user_online.=$u0->displayAvator();
//        $user_online.=' <a style="" title="' . $user->getNickname($row['user_id']) . '"><img class="user-avator" style="border: 4px solid #FFF;"  src="http://bargardon.ir/user/avatar/UA_' . $row['user_id'] . '.png" width="40" height="40" />' . '</a> ';
        }
    }
}

$list = $project->getList(20);
$my_prj = ($project->E_user_id > 0); // boolean

//}
//$online = $project->E_online;
?>
<div id="content-wrapper">
    <div id="content">
        <br>
        <h1><img src="medias/images/icons/bullet.png" align="absmiddle" />
            <?php echo $project->getListName() ?></h1>
        <hr/>

        <?= $pager->showSearchBox(); ?>
        <table width="100%" class="projects">
            <thead>
                <tr>
                    <th style="font-size: 11px;font-weight: normal;">کد پروژه</th>
                    <th>عنوان</th>
                    <th>نوع</th>
                    <th>وضعیت</th>
                    <th width="88px" >تاریخ ارسال</th>
                    <th>کارفرما</th>
                    <th width="20px" style="font-size: 10px;padding: 0px;font-weight: normal;">تعداد صفحات </th>
                    <? if ($project->E_state == "Open") { ?>
                        <th>تخمین قیمت</th>
                    <? } else { ?>
                        <th>هزینه پروژه</th>
                        <? if ($my_prj) { ?>
                            <th>امتیاز کارفرما</th>
                        <? } ?>
                    <? } ?>
                    <th width="16px" style="font-size: 10px;padding: 0;font-weight: normal;">تعداد پیشنهاد</th>
                    <th width="100px">عملیات </th>
                </tr>
            </thead>
            <tbody id="typeonline_projects_tbody">
                <?php
                $i = 0;
                foreach ($list as $p) {
                    $prj = new Project($p['id']);
                    $u = new User($p['user_id']);
                    $class = ($user->id == $p['user_id'] && !$my_prj) ? 'my-project' : '';
                    ?>
                    <tr class="<?= $class ?>" style="cursor: pointer" onclick="mhkform.ajax('project_'+<?= $p['id'] ?>+'?ajax=1','#ajax_content')">
                        <td><br/><p class="number" style="text-align: right;"><?= $prj->getCode() ?></p><br/></td>
                        <td><a class="ajax" <?= 'href="project_' . $p['id'] . '"' ?> style="display:block">
                                <?= $p['title']; ?>
                            </a>
                        </td>
                        <td><?= $_ENUM2FA['type'][$p['type']]; ?>
                            <p style="font-size: 10px;"><?= $_ENUM2FA['output'][$p['output']]; ?></p>
                        </td>
                        <td>
                            <?= $p['verified'] >= 1 ? $_ENUM2FA['state'][$p['state']] : ( $_ENUM2FA['verified'][$p['verified']] ); ?>
                            <? if ($project->E_state == "Run" && time() < $p['expire_time']) { ?>
                                <br/>
                                <span style="font-size: 10px;">
                                    <nobr>
                                        (<?= $persiandate->counterDown('interval_T' . $p['id'], $p['expire_time']); ?>)
                                    </nobr>
                                </span>
                            <? } ?>
                        </td>
                        <td><?php echo $persiandate->displayDate($p['submit_date']) ?></td>
                        <td style="text-align: center" class="mini-cup">
                            <?= $u->getNickname(); ?>
                            <br/>
                            <?= $u->displayCups(); ?>
                        </td>
                        <td><?= $p['guess_page_num'] ?></td>

                        <? if ($project->E_state == "Open") { ?>
                            <td>
                                <span class="price"><?php echo $p['max_price'] ?></span>
                                ریال    
                            </td>
                        <? } else { ?>
                            <td>
                                <?
                                $price = 0;
                                if ($user->isWorker()) {
                                    if ($p['type'] == 'Agency') {
                                        $price = ($prj->getFinalPageCount() * $_PRICES['worker'][$p['lang']]);
                                    } else {
                                        $bid = $prj->getAcceptedBid();
                                        $price = ($bid->getFullPrice() * $_PRICES['P_TYPIST']);
                                    }
                                } else {
                                    if ($p['type'] == 'Agency') {
                                        $price = ($prj->getFinalPageCount() * $_PRICES['agency'][$p['lang']]);
                                    } else {
                                        $bid = $prj->getAcceptedBid();
                                        $price = ($bid->getFullPrice());
                                    }
                                }

                                if (!$price) {
                                    echo 'مشخص نشده';
                                } else
                                    echo '<span class="price" >' . $price . '</span>' . ' ریال ';
                                ?>
                            </td>
                            <? if ($my_prj) { ?>
                                <td>
                                    <?= $p['ranked_typist'] == -1 ? 'ثبت نشده' : $message->displayRank($p['ranked_typist']); ?>
                                </td>
                            <? } ?>
                        <? } ?>
                        <td>
                            <?= $prj->getBidsCount() ?>
                        </td>
                        <td>
                            <a class="ajax" <?= 'href="project_' . $p['id'] . '"'; ?>>
                                <img src="medias/images/icons/bid.png" align="absmiddle" />
                                نمایش جزئیات
                            </a><br/>
                            <?php if ($user->isWorker() && $p['state'] == 'Open' AND !$my_prj) { ?>
                                <a class="popup" <?= 'href="project_' . $p['id'] . '?showBidForm=1"'; ?>>
                                    <img src="medias/images/icons/bid.png" align="absmiddle" />
                                    ارسال پیشنهاد
                                </a><br/>
                            <?php } ?>
                            <?php if ($my_prj AND ($p['state'] == 'Run' OR $p['state'] == 'Finish')) { ?>
                                <? if ($p['user_id'] == $user->id || $user->isAdmin()) { ?>
                                    <a class="" onclick="mhkform.ajax('sendsms_<?= $p['typist_id']; ?>?ajax=1')">
                                        <img src="medias/images/icons/sms.png" align="absmiddle" />
                                        ارسال پیامک
                                    </a><br/>
                                    <a class="" onclick="mhkform.ajax('send-message_<?= $p['typist_id']; ?>?ajax=1')">
                                        <img src="medias/images/icons/message.png" align="absmiddle" />
                                        ارسال پیام
                                    </a><br/>
                                <? } if ($p['typist_id'] == $user->id || $user->isAdmin()) { ?>
                                    <a class="" onclick="mhkform.ajax('sendsms_<?= $p['user_id']; ?>?ajax=1')">
                                        <img src="medias/images/icons/sms.png" align="absmiddle" />
                                        ارسال پیامک
                                    </a><br/>
                                    <a class="" onclick="mhkform.ajax('send-message_<?= $p['user_id']; ?>?ajax=1')">
                                        <img src="medias/images/icons/message.png" align="absmiddle" />
                                        ارسال پیام
                                    </a><br/>
                                <? } ?>
                            <?php } ?>
                            <?php if ($user->isAdmin() AND ($my_prj AND ($p['verified'] == Event::$V_NONE OR $p['verified'] == Event::$V_NEED_EDIT))) { ?>
        <!--                                <a class="ajax" href<?= '="submit-project_' . $p['id'] . '"'; ?> >
                    <img src="medias/images/icons/edit.png" align="absmiddle" />
                    ویرایش
                </a><br/>-->
                                <a class="confirm" href<?= '="project_' . $p['id'] . '?mode=delete"'; ?> >
                                    <img src="medias/images/icons/cross.png" align="absmiddle" />
                                    حذف
                                </a><br/>
                            <?php } ?>


                        </td>
                    </tr>
                <?php } ?>
                <!--            </tbody>
                        </table>-->
                <? if ($project->E_state == "Open" && !$my_prj) { ?>
                                                                                                                                                                                                                                                    <!--            <table width="100%" class="projects">
                                                                                                                                                                                                                                                    <tbody>-->
                    <tr>
                        <td colspan="10" style="">
                            <img src="medias/images/icons/loading2.gif" style="float: right" width="32" height="32" />
                            <p style="float: right;width: 90%;padding-right: 8px;">
                                کاربر گرامی:
                                این صفحه به صورت زنده است! 
                                <br/>
                                به محض تایید پروژه ی جدید، در این صفحه نمایش داده می شود و نیازی به رفرش ندارد.
                            </p>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="10" style="cursor: pointer" onclick="mhkevent.playSound('event')">
                            <img src="medias/images/icons/music.png" style="float: right" width="32" height="32"/>
                            <p style="float: right;width: 90%;padding-right: 8px;">
                                کاربر گرامی:
                                این صفحه دارای آگاهی دهنده ی صوتی است!
                                <br/>
                                به محض دریافت پروژه ی جدید آلارم صوتی پخش خواهد شد                                .
                                جهت تست صدا
                                اینجا
                                کلیک کنید.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="10" style="cursor: pointer" onclick="mhkform.ajax('/send-message_1_S2?ajax=1');">
                            <img src="medias/images/icons/comment.png" style="float: right" width="32" height="32"/>
                            <p style="float: right;width: 90%;padding-right: 8px;">
                                کاربر گرامی:
                                منتظر نظرات، انتقادات و پیشنهادات سازنده ی شما در مورد امکانات سایت هستیم.
                                <br/>
                                به منظور ارسال نظرات اینجا کلیک کنید.            
                            </p>
                        </td>
                    </tr>
                    <? if (FALSE) {//$user->isWorker() || $user->isAdmin()) {  ?>
                        <tr>
                            <td colspan="10" style="" onclick="">
                                <!--<img src="medias/images/icons/repair.jpg" style="float: right" width="40" height="40"/>-->
                                <img src="uploads/type/twitt/F1398199312135U50I0.png" style="float: right" width="40" height="40"/>
                                <p style="float: right;width: 90%;padding-right: 8px;color: red">

                                    تولد
                                    <br/>
                                    به مناسبت تولد ۲ سالگی تایپایران ،
                                    امروز از تاپیست ها کارمزد کسر نخواهد شد
                                </p>
                            </td>
                        </tr>
                    <?php } ?>
                    <?= Content::BODY(Content::$NOTE_PROJECTS_OPEN_ALL); ?>
                    <? if ($user->isWorker()) { ?>
                        <?= Content::BODY(Content::$NOTE_PROJECTS_OPEN_WORKER); ?>
                    <? } ?>
                    <tr>
                        <td colspan="10" style="" onclick="">
                            <img src="medias/images/icons/laughing.png" style="float: right" width="32" height="32"/>
                            <span style="float: right;width: 90%;padding-right: 8px;">
                                <!--کاربران آنلاین-->
                                <!--<br/>-->
                                <?= $user_online ?>
                            </span>
                        </td>
                    </tr>
                    <!--                </tbody>
                                </table>-->
        <!--                    <tr>
                        <td colspan="10" style="" onclick="">
                            <img src="medias/images/icons/tasliyat.png" style="float: right" width="32" height="32"/>
                            <div style="float: right;width: 90%;padding-right: 8px;">
                                <div onclick="$('#poem').toggle()" style="cursor: pointer">
                                </div>
                                <div id="poem" style="display: none">
                                </div>
                            </div>
                        </td>
                    </tr>-->

                <?php } ?>
            </tbody>
        </table>
        <?= $pager->pageBreaker(); ?>
        <? if ($project->E_state == "Open" && !$my_prj && $user->isWorker()) { ?>
            <div style="width: 70%">
                <br/>
                <br/>
                <? $userlevel->displayLevelQuestion($user); ?>
            </div>
        <? } ?>
    </div>
</div>
<? if ($project->E_state == "Open" && !$my_prj) { ?>
    <script type="text/javascript">
        function afterCompose(){
            curVer['typeonline_projects']=<?= time(); ?>;
            updateData('typeonline_projects', 50,5);
        }
        afterCompose();
    </script>
<?php } ?>

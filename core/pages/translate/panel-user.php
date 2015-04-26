<div id="content-wrapper">
    <div id="content">
        <?php $message->display() ?>

        <? include 'submit-project-body.php'; ?>
        <!-- End Success Box -->	
        <br/>
        <br/>
        <br/>
        <div>
            <div class="col-md-6">
                <div style="padding: 10px"></div>

                <div style="width: 100%;">
                    <?php
                    if (count($last_msg) != 0) {
                        $row = $last_msg[0];
                        ?>
                        <div style="width: 20%; padding-right:20px; float:right; text-align:center;" >
                            <br/>
                            <br/>
                            از طرف:
                            <br/>
                            <a <?= 'href="user_' . $row['from_id'] . '"' ?> target="_blank"><?= $user->getNickname($row['from_id']) ?></a>
                        </div>
                        <div style="padding: 10px;border-radius: 10px;text-align: right; width: 65%;float: right;background-color: #fff" >
                            <div style="min-height: 80px;max-height: 200px;overflow-y: auto" >
                                <a <?= 'href="message_' . $row['id'] . (($row['is_support']) ? ( '_S' . $row['is_support']) : '') . '"' ?>>
                                    <?php echo $row['title'] ?>
                                </a>
                                <br>
                                <?php echo nl2br($row['body']) ?>
                            </div>
                            <?php echo $persiandate->date('d F Y ساعت H:i:s', $row['dateline']) ?>
                            <a style="float: left;" <?= 'href="message_' . $row['id'] . (($row['is_support']) ? ('_S' . $row['is_support']) : '') . '"' ?>>
                                ادامه مطلب
                            </a>
                        </div>
                    <?php } ?>
                </div>
                <img  src="medias/images/theme/panel_msg.png"
                      style="width: 70%; float:left; padding-left:25px;"/>
            </div>
            <div class="col-md-6">
                <?
                $default = ' <p style="font-size:14pt">به ' . $_CONFIGS['Site']['Sub']['NickName'] . ' خوش آمدید!</p>
                <p style="font-size:12pt;line-height: 2;">وب سایت برگردون  با امکانات فراوان راه اندازی شد. برای دیدن لیست امکانات جدید 
                    <a href="' . $_CONFIGS['Pathes']['Blog'] . '" target="_blank">
                        اینجا</a>
                    کلیک نمایید.در حال حاضر امکانات سایت رایگان میباشد</p><br/>
                ';
                ?>
                <?= $default; // $userlevel->displayLevelQuestion($user, $default); ?>

                <div class="clear"></div>
            </div>
            <hr/>
            <div class="clear"></div>
        </div>
        <!--        <div style="width: 100%;float: left">
                    <div style="width: 48%;float: right; margin-top:20px;">
                        <div>
                            <ul>
                                <li>
                                    <a href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "/type-help/submit-project" . '"'; ?> target="_blank">
                                        چگونه یک پروژه رو ثبت کنیم؟
                                    </a>
                                </li>
                                <li>
                                    <a href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "/type-help/select-typist" . '"'; ?> target="_blank">
                                        چگونه یک مجری خوب را انتخاب کنیم؟
                                    </a>
                                </li>
                                <li>
                                    <a href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "/type-help/type-pay" . '"'; ?> target="_blank">
                                        چه زمانی وجه پروژه رو به مجری میدهم؟
                                    </a>
                                </li>
                                <li>
                                    <a href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "/type-help/type-many-page" . '"'; ?> target="_blank">
                                        چگونه می تونم حجم زیادی از صفحات رو در مدت زمان کمی ترجمه کنم ؟
                                    </a>
                                </li>
                                <li>
                                    <a href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "/type-help/type-req-rev" . '"'; ?> target="_blank">
                                        اگر پس از دریافت فایل نواقص و یا اشکالی بود چه کار باید بکنم؟
                                    </a>
                                </li>
                            </ul>
                            <p>&nbsp;</p>
                        </div>
                    </div>
                    <div class="panel_link" style="width: 48%;float: left; margin-top:20px;">
                        <div style="width:50%;float:left;">
                        <a class="active_btn" style="width:125px;background-color: #ff7f27"
                           href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "/type-help/agency" . '"'; ?> target="_blank">
                            دریافت نمایندگی
                        </a>
                        <a class="active_btn" style="width:125px;background-color: #ed1c24"
                           href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "/type-help/type-employ" . '"'; ?> target="_blank">
                            <nobr>
                                استخدام مترجم ثابت
                            </nobr>
                        </a>
                        <a class="active_btn" style="width:125px;background-color: #fd7edb"
                           href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "/type-help/type-discount" . '"'; ?> target="_blank">
                            دریافت کارت تخفیف
                        </a>
                        </div>
                        <div style="width:50%;float:right;">
                        <a class="active_btn" style="width:125px;background-color: #a349a4"
                           href<?= '="user-list_agency"'; ?> target="_blank">
                            لیست نمایندگی ها
                        </a>
                        <a class="active_btn" style="width:125px;background-color: #00a2e8"
                           href<?= '="user-list_worker"'; ?> target="_blank">
                            لیست مترجم ها
                        </a>
                        <a class="active_btn" style="width:125px;background-color: #3f48cc"
                           href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "/type-help/type-work" . '"'; ?> target="_blank">
                            کسب درآمد
                        </a>
                        </div>
        
                        <p>&nbsp;</p>
                    </div>
                </div>-->

        <div class="col-md-6">
            <div id="topmenu-panel">
                آخرین رخدادها</div>
            <table class="projects" style="width:100%;">
                <thead>
                    <tr>
                        <th>شناسه</th>
                        <th>عنوان</th>
                        <th>تاریخ</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody id="panel_events_tbody">
                    <?php foreach ($last_event as $ev) { ?>
                        <tr>
                            <td><?php echo $ev['id'] ?></td>
                            <td>
                                <a href="event_<?php echo $ev['id'] ?>">
                                    <?php
                                    echo $ev['title'];
                                    ?>
                                </a>
                            </td>
                            <td><?php echo $persiandate->date('d F Y ساعت H:i', $ev['dateline']) ?></td>
                            <td><a href="event_<?php echo $ev['id'] ?>"><img src="medias/images/icons/view.png" align="absmiddle" /> نمایش </a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="clear"></div>
        </div>

        <!--                <div style="width: 100%;padding: 10px" class="clear">
                        </div>-->
        <!--            <div style="width: 25%;float: right">
                        234
                    </div>
                </div>
                <div style="width: 100%;float: left">
                    <div style="width: 25%;float: right">
                        234
                    </div>-->
        <div class="col-md-6">
            <div id="topmenu-panel">
                آخرین پروژه ها
            </div>
            <table  class="projects" style="width:100%;">
                <thead>
                    <tr>
                        <!--<th>کد پروژه</th>-->
                        <th>عنوان</th>
                        <th>نوع</th>
                        <th>وضعیت</th>
                        <th width="100">تاریخ ارسال</th>
                        <!--<th width="20px" style="font-size: 10px;">تعداد صفحات </th>-->
                        <!--<th>حداکثر قیمت</th>-->
                        <!--<th>هزینه پروژه</th>-->
                        <th style="font-size: 8px;">پیشنهاد</th>
                    </tr>
                </thead>
                <tbody id="panel_projects_tbody">

                    <?php
                    $i = 0;
                    foreach ($last_prj as $p) {
                        ?>
                        <tr class="">
                            <!--<td><br/><p class="number" style="text-align: right;">T<?php echo $p['id'] ?></p><br/></td>-->
                            <td><a class="ajax" <?= 'href="project_' . $p['id'] . '"' ?> style="display:block">
                                    <?= $p['title']; ?>
                                </a>
                            </td>
                            <td><?= $_ENUM2FA['type'][$p['type']]; ?>
                                <p style="font-size: 10px;"><?= $_ENUM2FA['output'][$p['output']]; ?></p>
                            </td>
                            <td><?= $p['verified'] == 1 ? $_ENUM2FA['state'][$p['state']] : ( $_ENUM2FA['verified'][$p['verified']] ); ?>
                            </td>
                            <td><?php echo $persiandate->date('d F', $p['submit_date']) ?></td>
                            <!--<td><? // echo $p['guess_page_num']                             ?></td>-->
    <!--                                    <td>
                                <span class="price"><?php // echo $p['max_price']                             ?></span>
                                ریال    
                            </td>-->
    <!--                                    <td>
                            </td>-->
                            <td>
                                <?= $project->getBidsCount($p['id']) ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="clear"></div>
        </div>






        <div class="clear"> </div>
    </div>
</div>
<script type="text/javascript">
    function afterCompose() {
        curVer['panel_projects'] = 0;
        curVer['panel_events'] = 0;
        updateData('panel_projects', 10 * 60 * 1 + 5, 5);
        updateData('panel_events', 5 * 60 * 1 + 5, 5, 0);
    }
    afterCompose();
</script>

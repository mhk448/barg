<div id="content-wrapper">
    <div id="content">
        <?php $message->display() ?>

        <!-- End Success Box -->	
        <div>
            <div class="col-md-6">
                <?
                $default = ' <p style="font-size:14pt">به ' . $_CONFIGS['Site']['Sub']['NickName'] . ' خوش آمدید!</p>
                <p style="font-size:12pt;line-height: 2;">نسخه جدید این مرکز با امکانات فراوان راه اندازی شد. برای دیدن لیست امکانات جدید 
                    <a href="' . $_CONFIGS['Pathes']['Blog'] . '" target="_blank">
                        اینجا</a>
                    کلیک نمایید.در حال حاضر امکانات سایت رایگان میباشد</p><br/>
                ';
                ?>
                <? $userlevel->displayLevelQuestion($user, $default); ?>



                <hr/>

                <div class="bg-green-active topmenu-panel">
                    <i class="fa fa-briefcase"></i>
                    پروژه های باز
                </div>
                <table  class="projects" style="width:100%;">
                    <thead>
                        <tr>
                            <!--<th>کد پروژه</th>-->
                            <th>عنوان</th>
                            <th>نوع</th>
                            <th>وضعیت</th>
                            <th>زمان ارسال</th>
                            <!--<th width="20px" style="font-size: 10px;">تعداد صفحات </th>-->
                            <!--<th>حداکثر قیمت</th>-->
                            <!--<th>هزینه پروژه</th>-->
                            <th style="font-size: 8px;">پیشنهاد</th>
                        </tr>
                    </thead>
                    <tbody id="panel_projects_open_tbody">

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
                                <!--<td><? // echo $p['guess_page_num']                  ?></td>-->
    <!--                                    <td>
                                    <span class="price"><?php // echo $p['max_price']                  ?></span>
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

            </div>
            <div  class="col-md-6">
                <? echo $twitt->display("twitt", 0, 10); ?>
                <a class="active_btn" href="/twitts">بیشتر ...</a>
            </div>
            <div class="clear"> </div>
            <hr/>
        </div>





        <?
        $dayLength = 32;
        $lastDay = time();
        $firstDay = intval((($lastDay + 24 * 60 * 60) - $dayLength * 24 * 60 * 60) / (24 * 60 * 60)) * 24 * 60 * 60 - 3.5 * 60 * 60;
        $credits = $pager->getComList('credits', '*', $cdatabase->whereId($u->id, "user_id") . ' AND dateline > ' . $firstDay . ' AND dateline < ' . $lastDay, ' ORDER BY dateline ASC', 'comment', 8000);
        $credit_ = $creditlog->getCredit($u->id, 0, $firstDay);
        $cash_ = $creditlog->getCash($u->id, 0, $firstDay);
        $expense_ = $creditlog->getExpense($u->id, 0, $firstDay);
        $cashArray = array();
        $creditsArray = array();
        $expensesArray = array();
//$fullCredit = array();

        for ($index2 = 0; $index2 < $dayLength; $index2++) {
            $cashArray[$index2] = 0;
            $creditsArray[$index2] = 0;
            $expensesArray[$index2] = 0;
        }

        $sum_credit = 0;
        $sum_cash = 0;
        $sum_expense = 0;
        foreach ($credits as $c) {
            $i = intval(($c['dateline'] - $firstDay) / (24 * 60 * 60));
            if ($c['price'] > 0) {
                $cashArray[$i] += $c['price'];
                $sum_cash += $c['price'];
//    echo $persiandate->displayDate($c['dateline']).' ll:'.$i.": ll<br>";
            } else {
                $expensesArray[$i] += $c['price'];
                $sum_expense += $c['price'];
            }
            $creditsArray[$i] += $c['price'];
            $sum_credit += $c['price'];
        }


        $gt = array();
        $cash = $cash_; // - $sum_cash;
        $credit = $credit_; // - $sum_credit;
        $expense = $expense_;
        for ($index1 = 0; $index1 < $dayLength; $index1++) {
//    $gt[$index1]['x'] = $dayLength - $index1 - 1;
            $gt[$index1]['x'] = $persiandate->date('d', $firstDay + $index1 * 60 * 60 * 24);

            $cash += $cashArray[$index1];
            $credit += $creditsArray[$index1];
            $expense += $expensesArray[$index1];

            $gt[$index1]['cash'] = $cash;
            $gt[$index1]['credit'] = $credit;
            $gt[$index1]['dateline'] = $persiandate->date('Y/m/d', $firstDay + $index1 * 60 * 60 * 24);
            $gt[$index1]['expense'] = -1 * $expense;
        }

//echo json_encode($incriseCredit);
//exit();
        $index = 0;
        ?>
        <br/>



        <div>
            <div  class="col-md-6">
                <div class="bg-green-active topmenu-panel">
                    <i class="fa fa-bell"></i>
                    آخرین رخدادها</div>
                <table class="projects" style="width:100%;">
                    <thead>
                        <tr>
                            <th>شناسه</th>
                            <th>عنوان</th>
                            <th>زمان</th>
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

            <div  class="col-md-6">
                <div class="bg-green-active topmenu-panel">
                    <i class="fa fa-briefcase fa-"></i>
                    آخرین پروژه ها
                </div>
                <table  class="projects" style="width:100%;">
                    <thead>
                        <tr>
                            <!--<th>کد پروژه</th>-->
                            <th>عنوان</th>
                            <th>نوع</th>
                            <th>وضعیت</th>
                            <th>زمان ارسال</th>
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
                                <!--<td><? // echo $p['guess_page_num']                  ?></td>-->
    <!--                                    <td>
                                    <span class="price"><?php // echo $p['max_price']                  ?></span>
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

        </div>



        <div class="clear"> </div>
    </div>
</div>
<script type="text/javascript">
    function afterCompose() {
        curVer['panel_projects'] = 0;
        curVer['panel_projects_open'] = 0;
        curVer['panel_events'] = 0;
        updateData('panel_projects', 10 * 60 * 1 + 5, 5);
        updateData('panel_events', 5 * 60 * 1 + 5, 5);
        updateData('panel_projects_open', 5 * 60 * 1 + 5, 5);

    }
    afterCompose();
</script>

<div id="content-wrapper">
    <div id="content">
        <?php $message->display() ?>

        <!-- End Success Box -->	
        <div style="width: 100%;float: left;text-align:justify;">
            <div style="width: 48%;float: right">

                <p style="font-size:14pt">تایپیست گرامی</p>
                <p style="font-size:12pt;line-height: 2;">
                    شما در تایپایران می توانید به کسب درآمد بپردازید، برای این کار قبل از شروع کار بخش  
                    <a href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "/type-help" . '"'; ?> target="_blank">
                        راهنما
                    </a>
                    را به دقت مطالعه نمایید و به لیست پروژه ها بروید تا در پروژه ها پیشنهادتان را برای انجام کار ارسال کنید. همچنین در سیستم جدید بخش تایپ آنلاین راه اندازی شده که در آن مراحل انجام کار و تایپ، آنلاین می باشد. برای راهنمای بخش 
                    <a href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "/type-help/submit-typeonline" . '"'; ?> target="_blank">
                        اینجا
                    </a>
                    را کلیک کنید و جهت عضویت در این بخش بر روی لینک زیر کلیک نمایید . همچنین شما می توانید از سایر مجریان متمایز تر باشید  برای مشاهده امتیازات ویژه شدن 
                    <a href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "/type-rols/type-special" . '"'; ?> target="_blank">
                        اینجا
                    </a>
                    را کلیک کنید و برای ویژه شدن بر روی لینک زیر کلیک نمایید.
                </p>
                <hr/>
                <div style="text-align: center">
                    <div class="button-panel active_btn" >
                        <a href="projects_open" class="ajax">
                            <h2>
                                تایپ آنلاین
                            </h2>
                            <p>
                                ورود به بخش آنلاین
                            </p>
                        </a>
                    </div>
                    <div class="button-panel active_btn" >
                        <a href="projects_open" class="ajax">
                            <h2>
                                لیست پروژه های باز
                            </h2>
                            <p>
                                مناقصه ای
                            </p>
                        </a>
                    </div>
                    <div class="button-panel active_btn" >
                        <a href=""  class="" onclick="mhkform.info('به زودی  ...')">
                            <h2>
                                مجری ویژه
                            </h2>
                            <p>
                                تایپیست ویژه شوید
                            </p>
                        </a>
                    </div>
                </div>
                <hr/>
                <p>&nbsp;</p>
            </div>

            <div style="width: 48%;float: left">
                <?
                $default = ' <p style="font-size:14pt">به تایپایران خوش آمدید!</p>
                <p style="font-size:12pt;line-height: 2;">نسخه جدید تایپایران با امکانات فراوان راه اندازی شد. برای دیدن لیست امکانات جدید 
                    <a href="' . $_CONFIGS['Pathes']['Blog'] . '" target="_blank">
                        اینجا</a>
                    کلیک نمایید.در حال حاضر امکانات سایت رایگان میباشد</p><br/>
                ';
                ?>
                <? $userlevel->displayLevelQuestion($user, $default); ?>
                <hr/>
                <div style="width: 100%;">
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
                            <div style="padding: 10px;border-radius: 10px;text-align: right; width: 65%;float: right;background-color: #f0f0f0" >
                                <div style="min-height: 80px;max-height: 200px;overflow-y: auto" >
                                    <a <?= 'href="message_' . $row['id'] . (($row['is_support']) ? ('_S' . $row['is_support']) : '') . '"' ?>>
                                        <?php echo $row['title'] ?>
                                    </a>
                                    <br>
                                    <?php echo nl2br($row['body']) ?>
                                </div>
                                <?php echo $persiandate->date('d F Y ساعت H:i:s', $row['dateline']) ?>
                                <a style="float: left;" <?= 'href="message_' . $row['id'] . (($row['is_support']) ? ( '_S' . $row['is_support']) : '') . '"' ?>>
                                    ادامه مطلب
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                    <img  src="medias/images/theme/panel_msg.png"
                          style="width: 70%; float:left; padding-left:25px;"/>
                </div>
            </div>
        </div>
        <div style="width: 100%;float: left">
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
                                چگونه می تونم حجم زیادی از صفحات رو در مدت زمان کمی تایپ کنم ؟
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
                <!--<div style="width:50%;float:left;">-->
                <a class="active_btn" style="width:125px;background-color: #ff7f27"
                   href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "/type-help/agency" . '"'; ?> target="_blank">
                    دریافت نمایندگی
                </a>
                <a class="active_btn" style="width:125px;background-color: #ed1c24"
                   href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "/type-help/type-employ" . '"'; ?> target="_blank">
                    <nobr>
                        استخدام تایپیست ثابت
                    </nobr>
                </a>
                <a class="active_btn" style="width:125px;background-color: #fd7edb"
                   href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "/type-help/type-discount" . '"'; ?> target="_blank">
                    دریافت کارت تخفیف
                </a>
                <!--</div>-->
                <!--<div style="width:50%;float:right;">-->
                <a class="active_btn" style="width:125px;background-color: #a349a4"
                   href<?= '="user-list_agency"'; ?> target="_blank">
                    لیست نمایندگی ها
                </a>
                <a class="active_btn" style="width:125px;background-color: #00a2e8"
                   href<?= '="user-list_worker"'; ?> target="_blank">
                    لیست تایپیست ها
                </a>
                <a class="active_btn" style="width:125px;background-color: #3f48cc"
                   href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "/type-help/type-work" . '"'; ?> target="_blank">
                    کسب درآمد
                </a>
                <!--</div>-->

                <p>&nbsp;</p>
            </div>
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
        <div style="width: 100%;float: left">
            <br/>
            <br/>
            <h2>
                نمودار گردش مالی از تاریخ
                <?= $persiandate->date('d F Y', $firstDay); ?>
                تا
                <?= $persiandate->date('d F Y', $lastDay); ?>
            </h2>
            <br/>
            <script src="/plugin/amcharts/amcharts.js" type="text/javascript"></script>
            <script src="/plugin/amcharts/serial.js" type="text/javascript"></script>
            <script type="text/javascript">
                var chart;
                var chartData = [];
                var chartCursor;



                AmCharts.ready(function () {
                    // generate some data first
                    //                generateChartData();
                    chartData = <?= json_encode($gt); ?>;
                    // SERIAL CHART
                    chart = new AmCharts.AmSerialChart();
                    chart.pathToImages = "plugin/amcharts/images/";
                    chart.dataProvider = chartData;
                    chart.categoryField = "x";
                    chart.balloon.bulletSize = 5;
                    // listen for "dataUpdated" event (fired when chart is rendered) and call zoomChart method when it happens
                    chart.addListener("dataUpdated", zoomChart);

                    // AXES
                    // category
                    var categoryAxis = chart.categoryAxis;
                    categoryAxis.parseDates = false; // as our data is date-based, we set parseDates to true
                    categoryAxis.minPeriod = "DD"; // our data is daily, so we set minPeriod to DD
                    categoryAxis.dashLength = 1;
                    categoryAxis.minorGridEnabled = true;
                    categoryAxis.twoLineMode = false;
                
				
                    categoryAxis.axisColor = "#DADADA";

                    // value
                    var valueAxis = new AmCharts.ValueAxis();
                    //                valueAxis.axisAlpha = 0;
                    //                valueAxis.dashLength = 2;
                    valueAxis.axisColor = "#FC0202";
                    valueAxis.gridAlpha = 0;
                    valueAxis.axisThickness = 2;
                    chart.addValueAxis(valueAxis);
                
                    // GRAPH
                    var graph = new AmCharts.AmGraph();
                    graph.valueAxis = valueAxis;
                    graph.title = "درآمدها";
                    graph.valueField = "cash";
                    graph.bullet = "round";
                    graph.bulletBorderColor = "#FFFFFF";
                    graph.bulletBorderThickness = 2;
                    graph.bulletBorderAlpha = 1;
                    graph.lineThickness = 2;
                    graph.lineColor = "#5fb503";
                    graph.negativeLineColor = "#5fb503";
                    graph.hideBulletsCount = 50; // this makes the chart to hide bullets when there are more than 50 series in selection
                    graph.balloonText ="<span style='font-family:BYekan;direction:rtl' >"+ "[[cash]]<span style='float:left'>ریال</span>"+"<br/>[[dateline]]"+"</span>";
                    chart.addGraph(graph);
                
                    // GRAPH2
                    var graph = new AmCharts.AmGraph();
                    graph.valueAxis = valueAxis;
                    graph.title = "موجودی";
                    graph.valueField = "credit";
                    graph.bullet = "round";
                    graph.bulletBorderColor = "#FFFFFF";
                    graph.bulletBorderThickness = 2;
                    graph.bulletBorderAlpha = 1;
                    graph.lineThickness = 2;
                    graph.lineColor = "#51A1C9";
                    graph.negativeLineColor = "#51A1C9";
                    graph.hideBulletsCount = 50; // this makes the chart to hide bullets when there are more than 50 series in selection
                    graph.balloonText ="<span style='font-family:BYekan;direction:rtl' >"+ "[[credit]]<span style='float:left'>ریال</span>"+"<br/>[[dateline]]"+"</span>";
                    chart.addGraph(graph);
                
                    // GRAPH3
                    var graph = new AmCharts.AmGraph();
                    graph.valueAxis = valueAxis;
                    graph.title = "دریافت‌ها";
                    graph.valueField = "expense";
                    graph.bullet = "round";
                    graph.bulletBorderColor = "#FFFFFF";
                    graph.bulletBorderThickness = 2;
                    graph.bulletBorderAlpha = 1;
                    graph.lineThickness = 2;
                    graph.lineColor = "#5100C9";
                    graph.negativeLineColor = "#5100C9";
                    graph.hideBulletsCount = 50; // this makes the chart to hide bullets when there are more than 50 series in selection
                    graph.balloonText ="<span style='font-family:BYekan;direction:rtl' >"+ "[[expense]]<span style='float:left'>ریال</span>"+"<br/>[[dateline]]"+"</span>";
                    chart.addGraph(graph);

                    // CURSOR
                    chartCursor = new AmCharts.ChartCursor();
                    chartCursor.cursorPosition = "mouse";
                    chartCursor.pan = false; // set it to fals if you want the cursor to work in "select" mode
                    chartCursor.zoomable = true;
                    chart.addChartCursor(chartCursor);

                    // LEGEND
                    var legend = new AmCharts.AmLegend();
                    legend.useGraphSettings = true;
                    legend.align='right';
                    legend.valueText = "";
                    chart.addLegend(legend);
                
                    // SCROLLBAR
                    var chartScrollbar = new AmCharts.ChartScrollbar();
                    chart.addChartScrollbar(chartScrollbar);

                    chart.creditsPosition = "bottom-right";

                    // WRITE
                    chart.write("chartdiv");
                });

                // generate some random data, quite different range
                function generateChartData() {
               
                    for (var i = 0; i < 500; i++) {
                        var visits = Math.round(Math.random() * 4000) - 200;
                        var visits2 = Math.round(Math.random() * 4) - 2;

                        chartData.push({
                            x: visits2+i,
                            cash : visits+i
                        });
                    }
                }

                // this method is called when chart is first inited as we listen for "dataUpdated" event
                function zoomChart() {
                    // different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
                    chart.zoomToIndexes(chartData.length - 33, chartData.length - 1);
                }

          

            </script>
            <div id="chartdiv"  style="direction: ltr;width: 95%; height: 350px;"></div>
            <div class="clear"></div>
            <br/>
            <hr/>
            <br/>
        </div>
        
        
        
        
        
        
        
        <div style="width: 100%;float: left">
            <div style="width: 48%;background: #f0f0f0;float: right">
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

            <div style="width: 48%;background: #f0f0f0;float: right;margin-right: 20px">
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
                                <!--<td><? // echo $p['guess_page_num']                 ?></td>-->
    <!--                                    <td>
                                    <span class="price"><?php // echo $p['max_price']                 ?></span>
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




        <div style="width: 100%;float: left">
            <div style="width: 48%;background: #f0f0f0;float: right; margin-top:20px;">
                <div id="topmenu-panel">
                    اخبار و اطلاعیه ها</div>
                <div>
                    <marquee scrollamount="2" direction="up" height="140px" onMouseOver="stop();" onMouseOut="start();">
                        <ul style="padding-right:30px; line-height:3;">
                            <li><a href="#">افتتاح سیستم جدید سایت</a></li>
                            <li><a href="#">امکانات و ویژگی های نسخه جدید</a></li>
                            <li><a href="#">چگونه از تایپایران کسب درآمد کنیم</a></li>
                            <li><a href="#">پذیرش مدیران تالار گفتمان تخصصی تایپایران</a></li>
                            <li><a href="#">افتتاح سیستم جدید سایت</a></li>
                            <li><a href="#">امکانات و ویژگی های نسخه جدید</a></li>
                            <li><a href="#">چگونه از تایپایران کسب درآمد کنیم</a></li>
                            <li><a href="#">پذیرش مدیران تالار گفتمان تخصصی تایپایران</a></li>

                        </ul></marquee>
                </div>


                <div class="clear"></div>
            </div>

            <!--                <div style="width: 100%;padding: 10px" class="clear">
                            </div>-->

            <div style="width: 48%;background: #f0f0f0;float: right; margin-top: 20px; margin-right:20px;">
                <div id="topmenu-panel">
                    مطالب آموزشی
                </div>
                <div>
                    <marquee scrollamount="2"  direction="up" height="140px" onMouseOver="stop();" onMouseOut="start();">
                        <ul style="padding-right:30px; line-height:3;">
                            <li><a href="#">آموزش تایپ اصولی نقته و کاما</a></li>
                            <li><a href="#">آموزش تایپ استاندارد یک پاراگراف</a></li>
                            <li><a href="#">چگونه یک جدول رو تنظیم کنیم در صفحه</a></li>
                            <li><a href="#">آموزش قرار دادن شماره صفحه در ورد 2007</a></li>
                            <li><a href="#">آموزش تایپ استاندارد یک پاراگراف</a></li>
                            <li><a href="#">چگونه یک جدول رو تنظیم کنیم در صفحه</a></li>
                            <li><a href="#">آموزش قرار دادن شماره صفحه در ورد 2007</a></li>

                        </ul></marquee>
                </div>
                <div class="clear"></div>
            </div>

        </div>




        <div class="clear"> </div>
    </div>
</div>
<script type="text/javascript">
    function afterCompose(){
        curVer['panel_projects']=0;
        curVer['panel_events']=0;
        updateData('panel_projects', 10*60*1+5,5);
        updateData('panel_events', 5*60*1+5,5);
    }
    afterCompose();
</script>

<?php
/* @var $database Database */
/* @var $cdatabase Database */
/* @var $user User */
/* @var $message Message */
/* @var $creditlog Creditlog */


if ($user->isAdmin() && isset($_CONFIGS['Params'][1])) {
    $u = new User($_CONFIGS['Params'][1]);
} else {
    $u = $user;
}

$dayLength = 32;
$lastDay = time();



$firstDay = intval((($lastDay + 24*60*60) - $dayLength * 24 * 60 * 60) / (24 * 60 * 60)) * 24 * 60 * 60 - 3.5 * 60 * 60;

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
        $cashArray[$i ] += $c['price'];
        $sum_cash += $c['price'];
//    echo $persiandate->displayDate($c['dateline']).' ll:'.$i.": ll<br>";
    } else {
        $expensesArray[$i ] += $c['price'];
        $sum_expense += $c['price'];
    }
    $creditsArray[$i ] += $c['price'];
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
<div id="content-wrapper">
    <div id="content">
        <br/>
        <h2>
            نمودار گردش مالی از تاریخ
            <?= $persiandate->date('d F Y', $firstDay); ?>
            تا
            <?= $persiandate->date('d F Y', $lastDay); ?>
            
            <?if($user->isAdmin()){echo $u->getNickname();}; ?>
        </h2>
        <br/>
        <hr/>
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
        <br/>
        <div style="text-align: right">
            <b>
                توضیحات:
            </b>
            <ul>
                <li>
                    <span style="color: #5fb503">
                        درآمدها: 
                    </span>
                    شامل درآمد حاصل از پروژه ها و درآمد حاصل از دعوت کاربران و... می باشد
                </li>
                <li>
                    <span style="color: #51A1C9">
                        موجودی:
                    </span>
                    شامل اعتبار مالی شما در این سایت می باشد
                </li>
                <li>
                    <span style="color: #5100C9">
                        دریافت ها:
                    </span>
                    شامل تمام دریافت ها همچون دریافت از طریق حساب بانکی، هزینه های ارسال پیامک و... می باشد
                </li>
            </ul>
        </div>
        <br/>
        <br/>
        <div>
            <table class="projects">
                <tr>
                    <td colspan="2" style="text-align: center">
                        گزارش کلی
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>موجودی فعلی:</label>
                    </td>
                    <td>
                        <label class="price"><?= $u->getCredit(TRUE); ?></label>
                        <label>ریال</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>
                            مجموع درآمدها:
                        </label>
                    </td>
                    <td>
                        <label class="price"><?= $sum_cash + $cash_; ?></label>
                        <label>ریال</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>
                            مجموع دریافت ها:
                        </label>
                    </td>
                    <td>
                        <label class="price"><?= ($sum_expense + $expense_)*-1; ?></label>
                        <label>ریال</label>
                    </td>
                </tr>
<!--                <tr>
                    <td>
                        <label>متوسط درآمد ماهیانه :</label>
                    </td>
                    <td>
                        <label class="price"><?= intval(($sum_cash ) / $dayLength * 30); ?></label>
                        <label>ریال</label>
                    </td>
                </tr>-->
            </table>
            <br/>
            <br/>
            <a class="active_btn" onclick="mhkform.ajax('/send-message_1_S2?ajax=1');" >
                ارسال نظرات، انتقادات و پیشنهادات
                <a/>  
        </div>
    </div>
</div>

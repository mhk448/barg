<?php
$p = $project->getOfGui();


$subj[] = 'عمومی';
$subj[] = 'اسناد تجاری';
$subj[] = 'اقتصاد و حسابداری';
$subj[] = 'سینما و زیرنویس فیلم';
$subj[] = 'مدیریت و بازرگانی';
$subj[] = 'فیزیک';
$subj[] = 'ریاضی';
$subj[] = 'زمین شناسی، معدن و جغرافیا';
$subj[] = 'شیمی';
$subj[] = 'زیست شناسی';
$subj[] = 'برق و الکترونیک';
$subj[] = 'عمران و سازه';
$subj[] = 'روان شناسی و علوم تربیتی';
$subj[] = 'تاریخ';
$subj[] = 'سیاسی و علوم اجتماعی';
$subj[] = 'فقه و علوم اسلامی';
$subj[] = 'فلسفه';
$subj[] = 'پتروشیمی و نفت';
$subj[] = 'کشاورزی و زراعت';
$subj[] = 'معماری';
$subj[] = 'صنایع غذایی';
$subj[] = 'پزشکی ';
$subj[] = 'پرستاری و علوم آزمایشگاهی';
$subj[] = 'هنر';
$subj[] = 'مکانیک';
$subj[] = 'کامپیوتر و آی تی';
$subj[] = 'سایر';


$v = $auth->validate('SubmitProjectForm', array(
        ));
if ($v) {
    $pid = $project->submit();

    if ($pid) {
        $_CONFIGS['Params'][1] = $pid;
        include 'core/pages/common/earnest.php';
        exit;
    }
}
?>

<script  type="text/javascript" >
<?
global $_PRICES;
if ($user->isAgency()) {
    echo 'var prices=' . json_encode($_PRICES['agency']) . ';';
} else {
    echo 'var prices=' . json_encode($_PRICES['user']) . ';';
}
echo 'percent=' . $_PRICES['P_USER'] . ';';
echo 'var agencyForm=' . ($user->isAgency() ? 'true' : 'false') . ';';
?>
</script>
<script  type="text/javascript" src="/medias/scripts/translate/submit_project.js?v=2">
</script>
<style>
    .submit_project .advance{
        display: none;
    }
    input.advance,
    select.advance,
    textarea.advance{
        background-color: #babaff;
    }
</style>

<section class="submit">
    <!--<link rel="stylesheet" type="text/css" href="/medias/home/css/style.css" />-->
    <style>
        .main-content, 
        .description {
            max-width: 1044px;
            position: relative;
        }

        .main-content {
            border-radius: 5px;
            border: 1px solid #999;
            background-color: rgba(255, 255, 255, 0.7);
            color: #333;
            box-shadow: 0 0 5px 1px #555;
        }

        .main-content .col-xs-3 {
            padding-left: 0;
            padding-right: 0;
            border-right: 1px solid #DDD;
        }

        .main-content .first-child {
            border-radius: 5px 0 0 0;
        }

        .main-content .last-child {
            border-radius: 0 5px 0 0;
        }

        .main-content .col-xs-3:last-child {
            border-right: 0;
        }

        .trans-body {
            padding: 15px;
            height: 287px;
            background-color: #BBE7D9;
        }

        .text4tran {
            margin-top: 42px;
        }

        .to-flash {
            padding: 20px;
            font-size: 30px;
        }

        .expert {
            height: 179px;
            overflow: scroll;
            overflow-x: hidden;
        }

        .clock-remain {
            font-size: 86px;
        }

        .checkbox label, .radio label {
            margin-right: 40px;
        }


        .trans-title {
            background-color: #FFF;
            padding: 15px 10px;
        }

        .trans-title h3 {
            margin: 0;
        }

        .number, .number-com, .number-end {
            background-color: #333;
            border-radius: 100%;
            width: 32px;
            height: 32px;
            color: #FFF;
            position: relative;
            padding-right: 2px;
            padding-top: 5px;
            font-size: 16px;
            margin: 0 auto;
            margin-bottom: 15px;
            position: relative;
        }

        .number:after, .number-com:after {
            content: "";
            position: absolute;
            width: 115px;
            height: 3px;
            background: #333;
            top: 16px;
            right: -115px;
        }

        .number-com:before, .number-end:before {
            content: "";
            position: absolute;
            width: 115px;
            height: 3px;
            background: #333;
            top: 16px;
            right: 31px;	
        }

        .number:after {
            background-color: #3ab94e;
        }
/*        .check-icon {
            padding-right: 7px;
        }*/
        .translate-area {
            position: relative;
            background-color: rgb(255,255,255);
            background-color: rgba(255,255,255,0.9);
            padding: 23px;
            margin-bottom: 26px;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
            -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,0.15);
            -moz-box-shadow: inset 0 1px 2px rgba(0,0,0,0.15);
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.15);
        }

        .btn-green {
            background-color: #27AC7F;
            box-shadow: inset 0 -1px 2px rgba(0,0,0,.3), 0 4px 10px rgba(0,0,0,0.2);
            border-color: #6AD1B1;
            color: #FFF;
            border-style: solid none none;
            background-image: linear-gradient(top, #33B58B, #1ba478);
            background-image: -o-linear-gradient(top, #33B58B, #1ba478);
            background-image: -moz-linear-gradient(top, #33B58B, #1ba478);
            background-image: -webkit-linear-gradient(top, #33B58B, #1ba478);
            background-image: -ms-linear-gradient(top, #33B58B, #1ba478);

            -webkit-transition: all .5s ease;
            -moz-transition: all .5s ease;
            -ms-transition: all .5s ease;
            -o-transition: all .5s ease;
            transition: all .5s ease;
        }

        .btn.btn-green:hover {
            background-color: #16966c;
            background-image: linear-gradient(top, #23a379, #16966c);
            background-image: -o-linear-gradient(top, #27b184, #16966c);
            background-image: -moz-linear-gradient(top, #27b184, #16966c);
            background-image: -webkit-linear-gradient(top, #27b184, #16966c);
            background-image: -ms-linear-gradient(top, #27b184, #16966c);
            color: #FFF;

            -webkit-transition: all .5s ease;
            -moz-transition: all .5s ease;
            -ms-transition: all .5s ease;
            -o-transition: all .5s ease;
            transition: all .5s ease;
        }

        .translate {
            margin-top: 135px;
        }

        .translate-area {
            padding-bottom: 34px;
        }

        .translate-link {
            color: #FFF;
        }

        .translate-link button {
            padding: 10px 35px;
            font-weight: bold;
        }

        .translate-desc {
            margin-right: 15px;
            font-size: 20px;
        }

        .translate-desc a {
            color: rgba(76,70,67,0.5);
            cursor: pointer;
        }

        .subtitle p {
            color: #FFF;
            line-height: 1;
        }

        /**
         * 3.0 data
         */
        .data {
            background: #1CAD7E;
            padding: 150px 0;
        }

        .data-content {
            max-width: 1044px;
            color: #FFF;
            font-size: 20px;

        }
        .btn-file {
            position: relative;
            overflow: hidden;
            cursor: pointer;
            margin-top: 29px;

        }
        .btn-file input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            font-size: 100px;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            background: white;
            cursor: inherit;
            display: block;
            cursor: pointer;

        }
        .btn-file:hover, .btn-file:focus {
            cursor: pointer;
        }
        .form select,#desc{
            width: 100%;
        }
        .green-bg {
            background-color: rgb(58, 185, 78) !important;
            color: rgb(255, 255, 255) !important;
        }
    </style>
    <form method="post" action="submit-project" style="" id="sform" class="form" >
        <input type="hidden" name="formName" value="SubmitProjectForm" />
        <input type="hidden" name="" id="subject" value="" />
        <input type="hidden" name="" id="demo" value="" />
        <input type="hidden" name="" id="output" value="" />
        <input type="hidden" name="" id="price" value="" />
        <input type="hidden" name="" id="level" value="" />
        <input type="hidden" name="" id="links" value="" />
        <input type="hidden" name="" id="content_count" value="" />
        
        <div class="main-content row center-block">
            <div class="col-xs-3">
                <div class="trans-title first-child">
                    <div class="number check-icon green-bg"><i class="fa fa-check"></i></div>
                    <h3 class="text-center green">ثبت سفارش</h3>
                </div>

                <div class="trans-body">
                    <p class="text-center clock-remain"><i class="fa fa-calendar"></i></p>
                    <div class="form-group">
                        <label class="help" >
                            حد اکثر مدت تحویل کار:
                        </label>
                        <input id="time_day" class="help numberfild" value="1"
                               style="background: url('medias/images/theme/tdays.gif') no-repeat scroll left center white;width: 45%;text-align: right;"/>
                        <div class="help" 
                             style="float: right;width: 9%;margin-top: 15px">
                            و
                        </div>
                        <input id="time_hour" class="help numberfild" value="0"
                               style="background: url('medias/images/theme/thours.gif') no-repeat scroll left center white;width: 45%;text-align: right;"/>

                    </div>
                      <!--<input  type="button" value="پیشرفته" onclick="$('.advance').slideToggle()" style="width: 70px;margin-left: 10px">-->
                    <input  type="button" class="wait_files btn btn-block btn-lg btn-info margin-top-20" value="تایید" onclick="createFactor();
                            sendForm();" style="width: 100%;color: green">

                </div>
            </div>

            <div class="col-xs-3">
                <div class="trans-title">
                    <div class="number-com">3</div>
                    <h3 class="text-center">روش انجام</h3>
                </div>
                <div class="trans-body">
                    <!-- Button trigger modal -->
                    توضیحات
                    <!--                    <button type="button" class="btn btn-default btn-block text4tran" data-toggle="modal" data-target="#myModal">
                                            ارسال متن
                                        </button>-->
                    <textarea id="desc" style="height:120px;" class="help" ></textarea>

                </div>
            </div>
            <div class="col-xs-3">
                <div class="trans-title">
                    <div class="number-com">2</div>
                    <h3 class="text-center">بارگذاری</h3>
                </div>
                <div class="trans-body">
                    <?= uploadFild('files', '', $subSite . '/project', 1024 * 1024 * 20, 'x-zip|x-office|x-pic', 4) ?>
                    <br/><br/>
                    <div>فرمت های پشتیبانی:</div>
                    <a href="#"><i class="fa fa-file-word-o"></i> <i class="fa fa-file-pdf-o"></i> <i class="fa fa-file-excel-o"></i> <i class="fa fa-file-powerpoint-o"></i> <i class="fa fa-file-text-o"></i> لیست همه</a>
                    <hr />

                    <select class="help" id="type" onchange="changeMethod();" style="">
                        <!--<option value="Protected" selected="selected">پروژه توسط مرکز ترجمهایران انجام شود</option>-->
                        <? if ($user->isAgency()) { ?>
                            <option value="Agency" id="agency_type">پروژهای نمایندگی</option>
                        <? } ?>
                        <option  value="Public">پروژه به مناقصه گذاشته شود</option>
                        <option  value="Private">واگذاری به مترجم مشخص</option>
                    </select>
                    <div id="specific" style="display: none" >
                        <input  type="hidden"  id="worker" >
                        <input class="help" id="typistusername" value="انتخاب مترجم" style="width: 173px" type="button" onclick="showTypist()">
                        <div class="help_comment">
                            مترجم مورد نظر خود را از لیست انتخاب کنید
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="trans-title .last-child">
                    <div class="number-end">1</div>
                    <h3 class="text-center">انتخاب زبان</h3>
                </div>

                <div class="trans-body">
                    <p>از:</p>
                    <select class="help" id="flan"  style="" onchange="changedLang()"  >
                        <?
                        $l['EN'] = 'selected="selected"';
                        foreach ($_ENUM2FA['lang'] as $key => $value) {
                            echo '<option value="' . $key . '" ' . $l[$key] . '>' . $value . '</option>';
                        }
                        ?>
                    </select>

                    <p class="text-center to-flash"><i class="fa fa-arrow-down"></i></p>

                    <p>به:</p>
                    <select class="help" id="tlan" style="" onchange="changedLang()" >
                        <?
                        $l['FA'] = 'selected="selected"';
                        foreach ($_ENUM2FA['lang'] as $key => $value) {
                            echo '<option value="' . $key . '" ' . $l[$key] . '>' . $value . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </form>
</section>
<script type="text/javascript">
    changeMethod();
</script>
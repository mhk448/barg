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

<div id="content-wrapper">
    <div id="content" class="submit_project" >
        <h1>ارسال پروژه جدید</h1>
        <br/>
        <hr/>
        <br/>
        <?php $message->display() ?>
        <div style="float:left;">
            <a id="aForm1" onclick="" style="display: block;opacity: 1;">
                <img src="medias/images/theme/submit_1.png" width="130" />
            </a>
            <img src="medias/images/icons/submit_down.png" style="display: block;opacity: 0.5;"/>
            <a id="aForm3" onclick=""   style="display: block;opacity: 0.5;">
                <img src="medias/images/theme/submit_2_3.png" width="130"/>
            </a>
        </div>

        <form method="post" action="submit-project" style="padding-right: 8%" id="sform" class="form" >
            <input type="hidden" name="formName" value="SubmitProjectForm" />
            <div id="form1" style="">
                <label class="help" >عنوان :</label>
                <input class="help" type="text" id="title" maxlength="25" />
                <div class="help_comment" >
                    برای پروژه ی خود یک نام انتخاب نمایید
                </div>
                <label  class="help">زبان :</label>
                <div class="help" 
                     style="float: right;width: 23px;margin-top: 15px;margin-right: -23px">
                    از
                </div>
                <select class="help" id="flan"  style="width: 87px" onchange="changedLang()"  >
                    <?
                    $l['EN'] = 'selected="selected"';
                    foreach ($_ENUM2FA['lang'] as $key => $value) {
                        echo '<option value="' . $key . '" ' . $l[$key] . '>' . $value . '</option>';
                    }
                    ?>
                </select>
                <div class="help" 
                     style="float: right;width: 23px;margin-top: 15px">
                    به
                </div>
                <select class="help" id="tlan" style="width: 87px" onchange="changedLang()" >
                    <?
                    $l['FA'] = 'selected="selected"';
                    foreach ($_ENUM2FA['lang'] as $key => $value) {
                        echo '<option value="' . $key . '" ' . $l[$key] . '>' . $value . '</option>';
                    }
                    ?>
                </select>
                <div class="help_comment" >
                    زبان مبدا و مقصد ترجمه خود را انتخاب نمایید
                </div>



                <label class=" help" >نوع ترجمه: </label>
                <select class=" help" id="output">
                    <option value="TEXT" >
                        ترجمه متن
                    </option>
                    <option value="MDIA" >
                        ترجمه صوتی و تصویری
                    </option>
                    <option value="SITE" >
                        ترجمه وب سایت
                    </option>
                    <option value="BOOK" >
                        ترجمه کتاب
                    </option>
                    <option value="FAST" >
                        ترجمه فوری
                    </option>
                    <!--                    <option value="" >
                                            ترجمه شفاهی
                                        </option>-->
                </select>

                <div class="help_comment" >
                    پروژه را مایلید در چه قالبی تحویل بگیرید
                </div>


                <label class=" help" >موضوع:</label>
                <select class=" help" id="subject" >
                    <?
                    foreach ($subj as $key => $value) {
                        echo '<option value="' . $value . '" ' . '>' . $value . '</option>';
                    }
                    ?>
                </select>
                <div class="help_comment"  >
                    موضوع متن خود را مشخص کنید                  
                </div>

                <label class=" help" >سطح ترجمه:</label>
                <select class=" help" id="level" >
                    <option value="student" >دانشجویی</option>
                    <!--<option value="normal" selected="selected" > معمولی</option>-->
                    <option value="advance" >حرفه ای</option>
                </select>
                <div class="help_comment"  >
                    کیفیت ترجمه خود را مشخص کنید                  
                </div>

                <label class="help" >تعداد صفحات</label>
                <input type="text" id="pagecount" max="10000" class="help numberfild" />
                <div class="help_comment"  >
                    تعداد صفحات پروژه ی خود را حدودا وارد نمایید
                    <br/>
                    (تعداد صفحات در
                    word
                    )
                </div>



                <label class="help">
                    فایل پروژه: 
                </label>
                <div class="help_comment" >
                    فایل تصویری مربوط به پروژه ی خود را انتخاب نمایید
                    <br/>
                    در صورت وجود چند فایل، آنها  را با پسوند
                    zip
                    فشرده نموده و انتخاب نمایید
                    <br/>
                    همچنین می توانید فایل
                    pdf
                    مربوط به پروژه ی خود را نیز  انتخاب نمایید
                </div>
                <?= uploadFild('files', '', $subSite . '/project', 1024 * 1024 * 20, 'x-zip|x-office|x-pic', 4) ?>

                <label class="advance help" ></label>
                <input type="text" id="links"  class="advance help english" maxlength="25" placeholder="لینک فایل پروژه" />
                <div class="help_comment" >
                    در صورت داشتن لینک دانلود می توانید در این قسمت قرار دهید
                </div>

                <label class="help" >شرح و توضیح :
                </label>
                <textarea id="desc" style="height:120px;" class="help" onmouseover="ShowHelpCover(this)" onmouseout="$('#help_cover').hide();"></textarea>
                <div class="help_comment" >
                    توضیح مختصری از مواردی که به نظرتان باید رعایت شود را بنویسید
                </div>

                <label class="advance help" >
                    نمونه کار مترجم:
                </label>
                <textarea id="demo" style="height:120px;" maxlength="300" class="advance help" onmouseover="ShowHelpCover(this)" onmouseout="$('#help_cover').hide();"></textarea>
                <div class="help_comment" >
                    قسمت کوتاهی از متن خود را وارد نمایید تا نمونه ترجمه ی مترجمان سایت را ببینید
                </div>

                <label class="help" >
                    حد اکثر مدت تحویل کار:
                </label>
                <input id="time_day" class="help numberfild" value="1"
                       style="background: url('medias/images/theme/tdays.gif') no-repeat scroll left center white;width: 65px;text-align: right;"/>
                <div class="help" 
                     style="float: right;width: 23px;margin-top: 15px">
                    و
                </div>
                <input id="time_hour" class="help numberfild" value="0"
                       style="background: url('medias/images/theme/thours.gif') no-repeat scroll left center white;width: 65px;text-align: right;"/>
                <div class="help_comment" >
                    زمانی را که مایلید ترجمه خود را تحویل بگیرید،
                    مشخص کنید
                </div>




                <label class="help">روش انجام پروژه :</label>
                <select class="help" id="type" onchange="changeMethod();">
                    <!--<option value="Protected" selected="selected">پروژه توسط مرکز ترجمهایران انجام شود</option>-->
                    <? if ($user->isAgency()) { ?>
                        <option value="Agency" id="agency_type">پروژهای نمایندگی</option>
                    <? } ?>
                    <option  value="Public">پروژه به مناقصه گذاشته شود</option>
                    <option  value="Private">واگذاری به مترجم مشخص</option>
                </select>

                <div class="help_comment" >
                    <ol>
                        <? if ($user->isAgency()) { ?>
                            <li>
                                پروژه های نمایندگی بر اساس نرخ استاندارد محاسبه می شود
                            </li>
                        <? } ?>
                        <li>
                            پروژه ی ترجمه خود را به مناقصه بگذارید
                            و به بهترین مترجم واگذار کنید
                        </li>
                        <li>
                            پروژه را می توانید به مترجم های آشنا واگذار کنید
                        </li>
                    </ol>
                </div>

                <span style="display: none" class="agency_m">
                    <label class="help" >
                        تعداد کلمات:
                    </label>
                    <input type="text" id="content_count" max="10000000" class="help numberfild" />
                    <div class="help_comment">
                        تعداد کلمات را به طور دقیق وارد نمایید
                    </div>
                </span>

                <label class="help" >
                    <? if ($user->isAgency()) { ?>
                        مبلغ ضمانت مترجم:
                    <? } else { ?>
                        تخمین قیمت:
                    <? } ?>
                </label>
                <input type="text" id="price" max="10000000" class="help numberfild pricefild" />
                <div class="help_comment">
                    این مبلغ به عنوان ضمانت حسن انجام کار از مترجم دریافت می شود
                </div>
                <div id="specific" style="display: none" >
                    <label class="help" >مترجم: </label>
                    <input  type="hidden"  id="worker" >
                    <input class="help" id="typistusername" value="انتخاب مترجم" style="width: 200px" type="button" onclick="showTypist()">
                    <div class="help_comment">
                        مترجم مورد نظر خود را از لیست انتخاب کنید
                    </div>
                </div>

                <label></label>
                <label></label>
                <input  type="button" value="پیشرفته" onclick="$('.advance').slideToggle()" style="width: 70px;margin-left: 10px">
                <input  type="button" class="wait_files" value="تایید" onclick="createFactor();" style="width: 120px;">

            </div>
            <? include 'submit-project-factor.php'; ?>
        </form>
        <div class="clear"></div>
        <script type="text/javascript">
            changeMethod();
        </script>
    </div>
</div>
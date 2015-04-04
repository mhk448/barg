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
<script  type="text/javascript" src="/medias/scripts/type/submit_project.js?v=2">
</script>
<style>
    .submit_project .advance{
        display: none;
    }
    input.advance,
    .input.advance,
    select.advance,
    textarea.advance{
        background-color: #bace39;
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
                <label class="help" >عنوان :
                </label>
                <input class="help" type="text" id="title" maxlength="25" />
                <div class="help_comment" >
                    برای پروژه ی خود یک نام انتخاب نمایید
                </div>
                <label  class="help">زبان :</label>
                <select class="help" id="lang" >
                    <?
                    $l['FA'] = 'selected="selected"';
                    foreach ($_ENUM2FA['lang'] as $key => $value) {
                        echo '<option value="' . $key . '" ' . $l[$key] . '>' . $value . '</option>';
                    }
                    ?>
                </select>
                <div class="help_comment" >
                    زبان تایپ خود را انتخاب نمایید

                    <?
                    if ($user->isAgency()) {
                        echo '<br/><br/>';
                        echo SHOW_PRICE_TABLE('agency');
                    }
                    ?>

                </div>



                <label class=" help" >نوع پروژه: </label>
                <select class=" help" id="output" onchange="selectOutput()">
                    <option value="DOCX" >
                        تایپ در ورد (Word)
                    </option>
                    <option value="PPTX" >
                        پاورپوینت (PowerPoint)
                    </option>
                    <option value="XLSX" >
                        ورود داده به اکسل (Excel)
                    </option>
                    <option value="ACCS" >
                        اکسس (Access)
                    </option>
                    <option value="EDIT" >
                        ویرایش و صفحه آرایی
                    </option>
                    <option value="WAVE" >
                        فایل صوتی                        
                    </option>
                    <option value="SRCH" >
                        انجام تحقیق و مقاله
                    </option>
                    <option value="CHRT" >
                        رسم نمودار و چارت
                    </option>
                    <option value="SPSS" >
                        SPSS
                    </option>
                    <!--                    <option value="ONLINE" >
                                            تایپ فوری(آنلاین)
                                        </option>-->
                </select>

                <div class="help_comment" >
                    پروژه را مایلید در چه قالبی تحویل بگیرید
                </div>

                <span class="advance">
                    <label class=" help" >کیفیت انجام پروژه:</label>
                    <span style="" class="input help advance">
                        <input type="checkbox" id="level" style="margin: 3px"/>
                        غلط گیری و بازبینی مجدد
                    </span>
                    <div class="help_comment"  >
                        کیفیت تایپ خود را مشخص کنید                  
                    </div>
                </span>

                <span style="" id="perword">
                    <label class="help" >تعداد صفحات</label>
                    <input type="text" id="pagecount" max="10000" class="help numberfild" />
                    <div class="help_comment"  >
                        تعداد صفحات پروژه ی خود را حدودا وارد نمایید
                        <br/>
                        (تعداد صفحات در
                        word
                        )
                    </div>
                </span>
                
                
                <span style="display: none;" id="permin">
                    <label class="help" >زمان(دقیقه)  </label>
                    <input type="text" id="mincount" max="10000" class="help numberfild" />
                    <div class="help_comment"  >
                        مدت زمان فایل های شما حدودا چقدر است؟
                    </div>
                </span>


                <label class="help">
                    فایل پروژه: 
                    (حداکثر 6 فایل)
                </label>
                <?= uploadFild('files', 'help', $subSite . '/project', 1024 * 1024 * 20, 'x-zip|x-office|x-pic', 6) ?>
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

                <label class="advance help" >لینک دانلود پروژه</label>
                <input type="text" id="links"  class="advance help english" maxlength="25" placeholder="لینک فایل پروژه" />
                <div class="help_comment" >
                    در صورت داشتن لینک دانلود می توانید در این قسمت قرار دهید
                </div>


                <label class="help">
                    نمونه فایل: 
                    (اختیاری)
                </label>
                <?= uploadFild('demo', 'help', $subSite . '/project', 1024 * 1024 * 20, 'x-pic', 1) ?>
                <div class="help_comment" >
                    یک صفحه از کار خود رو به عنوان نمونه کار وارد نمایید تا تایپیست های مرکز بر اساس آن قیمت گذاری کنند
                </div>



                <label class="help" >شرح و توضیح :
                </label>
                <textarea id="desc" style="height:120px;" class="help" onmouseover="ShowHelpCover(this)" onmouseout="$('#help_cover').hide();"></textarea>
                <div class="help_comment" >
                    توضیح مختصری از مواردی که به نظرتان باید رعایت شود را بنویسید
                </div>

                <label class="help" >
                    حداکثر مدت تحویل کار:
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
                    زمانی را که مایلید فایل خود را تحویل بگیرید،
                    مشخص کنید
                </div>




                <label class="help">روش انجام پروژه :</label>
                <select class="help" id="type" onchange="changeMethod();">
                    <!--<option value="Protected" selected="selected">پروژه توسط مرکز تایپایران انجام شود</option>-->
                    <? if ($user->isAgency()) { ?>
                        <option value="Agency" id="agency_type">پروژهای نمایندگی</option>
                    <? } ?>
                    <option  value="Public">پروژه به مناقصه گذاشته شود</option>
                    <option  value="Private">واگذاری به تایپیست مشخص</option>
                </select>

                <div class="help_comment" >
                    <ol>
                        <? if ($user->isAgency()) { ?>
                            <li>
                                پروژه های نمایندگی بر اساس نرخ استاندارد محاسبه می شود
                            </li>
                        <? } ?>
                        <li>
                            پروژه ی تایپ خود را به مناقصه بگذارید
                            و به بهترین تایپیست واگذار کنید
                        </li>
                        <li>
                            پروژه را می توانید به تایپیست های آشنا واگذار کنید
                        </li>
                    </ol>
                </div>


                <label class="help" >
                    <? if ($user->isAgency()) { ?>
                        مبلغ ضمانت تایپیست:
                    <? } else { ?>
                        تخمین قیمت:
                    <? } ?>
                </label>
                <input type="text" id="price" max="10000000" class="help numberfild pricefild" />
                <div class="help_comment">
                    این مبلغ به عنوان ضمانت حسن انجام کار از تایپیست دریافت می شود
                </div>
                <div id="specific" style="display: none" >
                    <label class="help" >تایپیست: </label>
                    <input  type="hidden"  id="worker" >
                    <input class="help" id="typistusername" value="انتخاب تایپیست" style="width: 200px" type="button" onclick="showTypist()">
                    <div class="help_comment">
                        تایپیست مورد نظر خود را از لیست انتخاب کنید
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
<?php
//print_r($_FILES);
if (isset($_REQUEST['upload'])) {
    $out = array();
    if (isset($_REQUEST['loading'])) {
        $out['filename'] = $_REQUEST['filename'];

        $status = apc_fetch('upload_' . $out['filename']);
        $out['percent'] = $status['current'] / $status['total'] * 100;

        if ($out['percent'] < 30)
            $out['msg'] = 'لطفا منتظر بمانید';
        elseif ($out['percent'] < 60)
            $out['msg'] = 'و همچنان منتظر بمانید';
        elseif ($out['percent'] < 90)
            $out['msg'] = 'یخورده دیگه منتظر بمانید';
    } else {
        if (isset($_FILES['fl']['name']) && $_FILES['fl']['name'] != '') {
            $out['filename'] = $files->generateUniqueFileName($files->extension($_FILES["fl"]["name"]));
            if (!$files->upload('fl', $out['filename'], 'uploads/'.$subSite.'/project/', 1024 * 1024 * 20, 'x-zip|x-office|x-pic')) {
                $out['msg'] = ('فایل مورد نظر معتبر نمی باشد.');
                $out['uploaded'] = 0;
                $out['percent'] = 0;
            } else {
                $out['uploaded'] = 1;
                $out['percent'] = 100;
                $out['msg'] = 'فایل شما با موفقیت دریافت شد';
            }
        }
    }
    echo json_encode($out);
    exit;
}
$p = $pager->getParamById('projects', FALSE);
if (!$p) {
    $p = $project->getOfGui();
    $formName = 'Submit';
} else {
    if ($p['typist_id']) {
        header('Location: submit-project');
        exit;
    }
    $formName = 'Edit';
}
$v = $auth->validate($formName . 'ProjectForm', array(
    array('t', 'Required', 'عنوان پروژه را مشخص نمایید.'),
    array('lan', 'Required', ''),
    array('gpn', 'Required', 'تعداد صفحات متن خود را به صورت تقریبی مشخص نمایید'),
    array('desc', 'Required', 'توضیحات پروژه را وارد نمایید'),
//    array('fl', 'File', 'فایل پروژه را انتخاب کنید.'),
    array('fn', 'Required', 'فایل پروژه را انتخاب کنید.'),
    array('pt', 'Required', 'نوع پروژه را انتخاب نمایید.'),
    array('di1', 'Required', 'حداکثر زمان تحویل پروژه را مشخص کنید'),
    array('di2', 'Required', 'حداکثر ساعت تحویل پروژه را مشخص کنید'),
    array('out', 'Required', 'نوع فایلی را که مایلید تحویل بگیرید را مشخص کنید'),
    array('pt', 'Required', 'نوع پروژه زل مشخص کنید'),
    array('earnest', 'Required', 'مبلغ بیعانه را وارد نمایید')
        ));
if ($v) {
    $pid = $project->submit();

//    $pid=1101;
    if ($pid) {
//        $message->addMessage('اطلاعات پروژه با موفقیت ثبت گردید.<br>پس از بررسی مدیریت پروژه شما برای انجام شدن قرار خواهد گرفت.');
//        header('Location: stakeholdere_' . $pid . '_AS1');
//        header('Location: stakeholdere_' . $pid);
//        header('Location: earnest_' . $pid);
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
?>
</script>
<script  type="text/javascript" src="/medias/scripts/type/submit_project.js?v=1">
</script>

<div id="content-wrapper">
    <div id="content" >
        <h1>ارسال پروژه جدید</h1>
        <br/>
        <hr/>
        <br/>
        <?php $message->display() ?>
        <div style="float:left;">
            <!--<a id="aForm1" onclick="ChangeForm(1)" href="#form1"  style="display: block;opacity: 1;border:solid 2px;">-->
            <a id="aForm1" onclick="ChangeForm(1)" style="display: block;opacity: 1;">
                <img src="medias/images/theme/submit_1.png" width="130" />
            </a>
            <img src="medias/images/icons/submit_down.png" style="display: block;opacity: 0.5;"/>
            <? if ($p['output'] == 'ONLINE') { ?>
                <a id="aForm3" onclick="ChangeForm(3)"   style="display: block;opacity: 0.5;">
                    <img src="medias/images/theme/submit_2_3.png" width="130"/>
                </a>
            <? } else { ?>
                <a id="aForm2" onclick="ChangeForm(2)"   style="display: block;opacity: 0.5;">
                    <img src="medias/images/theme/submit_2.png" width="130"/>
                </a>
                <img src="medias/images/icons/submit_down.png" style="display: block;opacity: 0.5;"/>
                <a id="aForm3" onclick="ChangeForm(3)"   style="display: block;opacity: 0.5;">
                    <img src="medias/images/theme/submit_3.png" width="130"/>
                </a>
            <? } ?>
        </div>
        <!--        <div>
                    <img src="medias/images/theme/submitperoject.png" style="display: block;"/>
                </div>-->


        <form method="post" action<?= '="submit-project' . ($p['id'] ? ('_' . $p['id']) : '') . '"'; ?> style="padding-right: 8%" id="sform" class="form" enctype="multipart/form-data">
            <input type="hidden" name="formName" value="<? echo $formName; ?>ProjectForm" />
            <input type="hidden" name="pid" value="<?= $p['id'] ?>" />
            <div id="form1" style="">
                <div style="">
                    <label class="help" >عنوان :</label>
                    <input class="help" type="text" name="t" maxlength="25"  id="project_select" value="<? echo $p['title']; ?>"  />
                    <div class="help_comment" >
                        برای پروژه ی خود یک نام انتخاب نمایید
                    </div>
                    <label  class="help">زبان :</label>
                    <? $l[($p['lang'])] = 'selected="selected"'; ?>
                    <select class="help" name="lan" id="lang_select"  >
                        <?
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

                    <!--                <label class="help" > :</label>
                                    <input class="help" type="checkbox" name="" id="" style="" />
                                    <div class="help label" >
                    فرمول نویسی
                                    </div>
                                    <input class="help" type="checkbox" name="" id="" style="" />
                                    <div class="help label" >
                                        جدول
                                    </div>
                                    <input class="help" type="checkbox" name="" id="" style="" />
                                    <div class="help label" >
                                        ویرایش متن
                                    </div>
                                    <div class="help_comment" >
                                        ;
                                    </div>-->

                    <label class="help" >تعداد صفحات</label>
                    <input type="text" name="gpn" max="10000" class="help numberfild" value="<?= $p['guess_page_num']; ?>" />
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
                    <div class="input"  style="
                         background-color: white;
                         font: 13px BYekan, Tahoma;
                         overflow: hidden;
                         ">
                        <div style="width: 175px;overflow: hidden;height: 24px;font-family: Tahoma;" id="fsn">
                            انتخاب فایل
                        </div>
                        <div style="width: 175px; margin-top: -30px;">
                            <input  type="file" name="fl" id="fl" style="z-index: 1; margin: 0px; padding: 0px; cursor: pointer; opacity: 0;" onchange="checkFile()">
                        </div>
                    </div>
                    <input  type="hidden" id="fn" name="fn" value="<?= $p['file_name'] ?>" />
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


                </div>
                <div style="" id="desc-div">


                    <label class="help" >شرح و توضیح :
                    </label>
                    <textarea name="desc" style="height:120px;" class="help" onmouseover="ShowHelpCover(this)" onmouseout="$('#help_cover').hide();"><? echo $p['description']; ?></textarea>
                    <div class="help_comment" >
                        توضیح مختصری از مواردی که به نظرتان باید رعایت شود را بنویسید
                    </div>
                </div>
                <label></label>
                <input type="button" value="مرحله بعد" onclick="ChangeForm(2);" style="width: 200px;">
            </div>
            <div id="form2" style="display: none">

<!--                <input type="button" value="1" style="width: 40px;" onclick="$('#form2').hide(); $('#form1').show();"> ---- 
                <input type="button" value="2" style="width: 40px;" onclick="$('#form2').hide(); $('#form1').show();"> ----
                <input type="button" value="3" style="width: 40px;" >-->
                <div style="">
                    <label class="help" >
                        حد اکثر مدت تحویل کار:
                    </label>
                    <input name="di1" class="help" value="<?= $p['expire_interval'] ? round($p['expire_interval'] / (24 * 60 * 60)) : ($user->isAgency() ? '1' : ''); ?>"
                           style="background: url('medias/images/theme/tdays.gif') no-repeat scroll left center white;width: 65px;"/>
                    <div class="help" 
                         style="float: right;width: 23px;margin-top: 15px">
                        و
                    </div>
                    <input name="di2" class="help" value="<?= $p['expire_interval'] ? round(($p['expire_interval'] % (24 * 60 * 60)) / (60 * 60)) : ($user->isAgency() ? '0' : ''); ?>"
                           style="background: url('medias/images/theme/thours.gif') no-repeat scroll left center white;width: 65px;"/>
                           <?
//            echo jCalendarFild('LastDate', ' id="time_select"   required="required"  placeholder="' . 'تاریخ شمسی' . '" ');
//                    if (isset($p['expire_date'])) {
//                        $ed = $p['expire_date'];
//                    } else if (isset($p['expire_time'])) {
//                        $persiandate = new PersianDate();
//                        $ed = $persiandate->date("Y/m/d", $p['expire_time']);
//                    }
//                    echo jCalendarFild('d1', 'value="' . $ed . '" class="help" id="time_select" style="width: 100px;padding-left: 0px;padding-right: 0px;text-align: center;"  placeholder="' . 'تاریخ شمسی' . '" ');
                           ?>
                    <!--<label class="help" style="width: 3px;clear: none">-->
                    <!--ساعت:-->
                    <!--</label>-->
                    <!--<select class="help" name="d2" style="width: 90px;padding-right: 0px;">-->
                    <? /*
                      $et = $p['expire_time'] <= 24 ? $p['expire_time'] : date("H", $p['expire_time']);
                      $et = (int) $et;
                      for ($index = 8; $index < 12; $index++) {
                      echo '<option value="' . $index . '" ' . ($et == $index ? 'selected="selected"' : '') . ' >'
                      . ( ($index) . " صبح ") . '</option>';
                      }
                      for ($index = 12; $index < 13; $index++) {
                      echo '<option value="' . $index . '" ' . ($et == $index ? 'selected="selected"' : '') . ' >'
                      . ( ($index) . " ظهر ") . '</option>';
                      }
                      for ($index = 13; $index < 20; $index++) {
                      echo '<option value="' . $index . '" ' . ($et == $index ? 'selected="selected"' : '') . ' >'
                      . (($index % 12) . " عصر ") . '</option>';
                      }
                      for ($index = 20; $index < 24; $index++) {
                      echo '<option value="' . $index . '" ' . ($et == $index ? 'selected="selected"' : '') . ' >'
                      . (($index % 12) . " شب ") . '</option>';
                      }
                      for ($index = 24; $index < 25; $index++) {
                      echo '<option value="' . $index . '" ' . ($et == $index ? 'selected="selected"' : '') . ' >'
                      . (($index % 12 + 12) . " شب ") . '</option>';
                      }
                      for ($index = 1; $index < 8; $index++) {
                      echo '<option value="' . $index . '" ' . ($et == $index ? 'selected="selected"' : '') . ' >'
                      . (($index) . " بامداد ") . '</option>';
                      } */
                    ?>
                    <!--</select>-->

                    <div class="help_comment" >
                        زمانی را که مایلید تایپ خود را تحویل بگیرید،
                        مشخص کنید
                    </div>


                    <div id="out-div" >
                        <label class="out help" >نوع پروژه: </label>
                        <select class="out help" name="out">
                            <option value="DOCX" <? echo ((!isset($p['output']) || $p['output'] == 'DOCX') ? 'selected="selected"' : ''); ?>>
                                تایپ در فایل Word
                            </option>
                            <option value="ONLINE" <? echo (($p['output'] == 'ONLINE') ? 'selected="selected"' : ''); ?> >تایپ آنلاین </option>
                            <option value="PPTX" <? echo (($p['output'] == 'PPTX') ? 'selected="selected"' : ''); ?>>
                                پاورپویت
                            </option>
                            <option value="XLSX" <? echo (($p['output'] == 'XLSX') ? 'selected="selected"' : ''); ?>>
                                اکسل
                            </option>
                        </select>

                        <div class="help_comment" >
                            پروژه را مایلید در چه قالبی تحویل بگیرید
                        </div>
                    </div>

                    <!--            <label>کیفیت</label>
                                <select name="qu" id="quality_select"  class="help">
                                    <option value="generic">عادی</option>
                                    <option value="good">خوب</option>
                                    <option value="best">عالی</option>
                                </select>-->

                    <!--            <label>مدت ارسال پیشنهاد</label>
                                <input type="text" name="d" style=" background-image :url('medias/images/theme/tdays.gif');background-repeat: no-repeat;background-position: left center;" value="10" class="help"/>-->

                    <!--            <label>قابل تحویل</label>
                                <textarea name="del" style="height:120px;" class="help"></textarea>-->

                <!--<input type="button" value="مرحله قبل" onclick="$('#form2').hide(); $('#form1').show();">-->


                    <!--<div style="opacity: 0.5" onmouseover="this.style.opacity=1;" onmouseout="this.style.opacity=0.5;" >-->

                    <? if (FALSE && $discount->getReferer() && $discount->getReferer() > 0) { //nc? mafhomi?>
                        <input name="pt" id="method" value="Referer" type="hidden"/>
                    <? } else { ?>
                        <label class="help">روش انجام پروژه :</label>
                        <select class="help" name="pt" id="method" onchange="changeMethod();">
                            <!--<option value="Protected" selected="selected">پروژه توسط مرکز تایپایران انجام شود</option>-->
                            <? if ($user->isAgency()) { ?>
                                <option <? echo ((!isset($p['type']) || $p['type'] == 'Agency') ? 'selected="selected"' : ''); ?> value="Agency" >پروژهای نمایندگی</option>
                            <? } ?>
                            <option <? echo ($p['type'] == 'Public' ? 'selected="selected"' : ''); ?> value="Public">پروژه به مناقصه گذاشته شود</option>
                            <option <? echo ($p['type'] == 'Private' ? 'selected="selected"' : ''); ?> value="Private">واگذاری به تایپیست مشخص</option>
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
                    <? } ?>

                    <label></label>
                    <br/><br/>
                </div>
                <div style="">
                    <div  id="monaghese_specific" style="display: none" >

                        <label class="help" >
                            تخمین هزینه: 
                        </label>
                        <input type="text" name="mp" max="10000000" class="help numberfild pricefild" value="<? echo $p['max_price']; ?>"/>
                        <div class="help_comment">
                            با توجه به تعداد صفحات، مبلغی در حدود 
                            <span id="helpMaxPrice" style="color: red"></span>
                            ریال قیمت خوبی می تواند باشد
                        </div>
                    </div>
                    <div  id="monaghese" style="display: none" >

                        <label class="help" >روش انتخاب  تایپیست </label>

<!--                        <select name="selectkarfarma" id="selectkarfarma" onchange="changeselectkarfarma();">
    <option value="li">انتخاب تایپیست پس از مشخص شدن پیشنهادات</option>
    <option value="fm">انتخاب اولین مجری پیشنهاد دهنده</option>
    <option value="fim">انتخاب اولین مجری ویژه پیشنهاد دهنده</option>
    <option value="mr">انتخاب اولین مجری با امتیاز بالای (1-10)</option>
    <option value="mp">انتخاب مجری با قیمت پیشنهادی کمتر از...</option>
</select>-->
                        <input <? echo ((!isset($p['selection_method']) || $p['selection_method'] == 'li') ? 'checked="checked"' : ''); ?> class="help"  type="radio"  name="selectkarfarma" value="li" style="width:auto;"/><div class="help label" >
                            انتخاب تایپیست پس از مشخص شدن پیشنهادات
                        </div>
                        <div class="help_comment">
                            پس از مشخص شدن پیشنهای تایپیستها، می توانید تایپیست مورد نظر خود را مشخص کنید
                        </div>

                        <label class="help" ></label>
                        <input <? echo ( $p['selection_method'] == 'fm' ? 'checked="checked"' : ''); ?> class="help"  type="radio"  name="selectkarfarma" value="fm" style="width:auto;"/><div class="help label"  >
                            انتخاب اولین مجری پیشنهاد دهنده
                        </div>
                        <div class="help_comment">
                            پروژه به اولین تایپست پیشنهاد دهنده واگذار می شود
                        </div>

                        <!--<label class="help" ></label>
                        <input <? // echo ( $p['selection_method'] == 'fim' ? 'checked="checked"' : '');          ?> class="help" type="radio"  name="selectkarfarma" value="fim" style="width:auto;"/><div class="help label"  >
                            انتخاب اولین مجری ویژه پیشنهاد دهنده
                        </div>
                        <div class="help_comment">
                            پروژه به اولین تایپست ویژه پیشنهاد دهنده واگذار می شود
                        </div>-->

                        <label></label>
                        <input <? echo ( $p['selection_method'] == 'mr' ? 'checked="checked"' : ''); ?> class="help" type="radio"  name="selectkarfarma" value="mr" style="width:auto;"/><div class="help label" >
                            انتخاب اولین مجری با امتیاز بالای 
                            <input type="text" name="mr" max="10" value="<? echo ( isset($p['min_rate']) ? $p['min_rate'] : 6); ?>" class="help numberfild" style="width: 30px;float: none;margin: 0px;text-align: center"/>
                        </div>
                        <div class="help_comment">
                            پروژه به اولین تایپستی که امتیازی بیشتر از عدد مشخص شده دارد،
                            واگذار می شود
                        </div>

<!--                    <label></label><input  class="help" type="radio"  name="selectkarfarma" value="mp" style="width:auto;"/><div class="help label" >
                        انتخاب مجری با قیمت پیشنهادی کمتر از 
                        <? //echo NumTextFild('d3', ' style="width: 50px;float: none;margin: 0px;text-align: center"', 10000000);               ?>
                        تومان
                    </div>
                    <div class="help_comment">
                    </div>-->
                    </div>

                    <div id="specific" style="display: none" >
                        <label class="help" >تایپیست: </label>
                        <input  type="hidden"  name="private_typist_id" value="<? echo ((isset($p['private_typist_id']) && $p['private_typist_id']) ? $p['private_typist_id'] : ''); ?>" >
                        <input class="help" id="typistusername" style="width: 200px" type="button" value="<? echo ((isset($p['private_typist_id']) && $p['private_typist_id'] != 0) ? 'ارجاع به: ' . $user->getNickname($p['private_typist_id']) : "انتخاب تایپیست"); ?>" onclick="showTypist()">
                        <div class="help_comment">
                            تایپیست مورد نظر خود را از لیست انتخاب کنید
                        </div>
                    </div>

                    <!--                <div id="repprice" style="clear:both; display:none;">
                                        <label> </label>
                                        <div style=" border:1px dashed #BBB; padding:5px 10px; margin:20px">
                                            قیمت پروژه بر اساس نرخ استاندارد محاسبه می گردد.
                                        </div>
                                    </div>-->
                    <!--            <div id="userprice" style="clear:both; display:none;">
                                    <label>حداکثر قیمت پروژه (ریال)</label>
                                    <input type="text" name="mp" style="width:70px" value="0" />
                                </div>-->
                    <!--            <label>کد امنیتی : <img src="captcha.php" align="left" /></label>
                                <input type="text" style="width:70px" id="captcha" name="captcha" />-->
                    <label></label>
                    <input style="width: 20px;margin-left: 5px;padding: 3px 0px;" title="مرحله قبل" type="button" value="<" onclick="ChangeForm(1);">
                    <input  type="button" value="مرحله بعد" onclick="ChangeForm(3);" style="width: 170px;">
                </div>
            </div>
            <? include 'submit-project-factor.php'; ?>
        </form>
        <div class="clear"></div>
    </div>
</div>
<script type="text/javascript" >
    initHelpBox();
    changeTypeOnline();
    changeMethod();
    initInputNumber();
</script>
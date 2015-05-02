<?php
if (isset($_REQUEST['mode']) and $_REQUEST['mode'] == "delete") {
    if ($project->delete()) {
        $message->addMessage('پروژه ی شما حذف شد');
    } else {
        $message->addMessage('شما نمی توانید این پروژه را حذف کنید');
    }
} else { // edit mode
//        if ($bid->addBid($project)) {
//            $message->addMessage('پیشنهاد شما با موفقیت ارسال گردید.<br> جهت مشاهده پیشنهادهای خود به <a href="bids">صفحه پیشنهادهای من</a> مراجعه نمایید.');
//        } else {
//            $message->addMessage('شما نمی توانید این پیشنهاد را ویرایش کنید');
//        }
}


$action_str = "project_" . $project->id;



if ($auth->validate('RankTypistForm', array(
            array('r1', 'Selected', 'امتیازتان را به پایبندی به تعهدات و زمانبندی مجری انتخاب نمایید.'),
            array('r2', 'Selected', 'امتیازتان را به دقت و صحت کار مجری انتخاب نمایید.'),
        ))) {
    $project->addRank($_REQUEST['r1'], $_REQUEST['r2'], $_REQUEST['wsc'], $_REQUEST['ssc']);
}

$ff = $project->getFinalFile();
?>
<div id="content-wrapper">
    <div id="content">

        <?= showProjectInfo(); ?>

        <div style="height: auto;text-align: right" class="pero-r3s1" >
            <? if (!$project->typist_id || $user->isAdmin()) { ?>
                <? if ($project->verified != -1 || $user->isAdmin()) { ?>
                        <!--                    <a href<?= '="submit-project_' . $project->id . '"'; ?>>
                                                <img align="absmiddle" src="medias/images/icons/edit.png"/>
                                                ویرایش پروژه
                                            </a>-->
                    <br/>
                    <a href<?= '="' . $action_str . '?mode=delete"' ?> class="confirm">
                        <img align="absmiddle" src="medias/images/icons/close.png"/>
                        حذف پروژه
                    </a>
                    <br/>
                    <? if ($user->isAdmin()) { ?>
                        <a href<?= '="manage-projects?change=1&state=Close&prj_id=' . $project->id . '"'; ?> class="popup">
                            <img align="absmiddle" src="medias/images/icons/close.png"/>
                            بستن و آزادسازی گروگذاری
                        </a>
                    <? } ?>
                <? } ?>
                <br/>
                <br/>
            <? } ?>
        </div>
        <div class="clear"></div>
        <?php $message->display() ?> 

        <?php if (($project->state != 'Finish' && $project->stakeholdered == 1)) { ?>
            <div class="info-box">
                مبلغ
                <span class="price"><?= $project->earnest ?></span>
                ریال
                توسط مجری به عنوان ضمانت حسن انجام کار پرداخت شده است
            </div>
        <?php } ?>

        <? if ($project->state == "Open" && $project->verified != -1) { ?>
            <div class="info-box">
                <span class="info-icon-box">
                    توجه
                </span>
                در این مرحله شما منتظر ارسال پیشنهاد 
                <?= $_ENUM2FA['fa']['workers'] ?>
                باشید و یکی از پیشنهادهای ارسال شده را تایید کنید
                <br>   
                سیستم نمایش پیشنهادها آنلاین بوده و به محض ارسال پیشنهاد نمایش داده
                می شود، و نیازی به رفرش کردن صفحه نیست.
                <br/>
                <span style="color: red">
                    کاربر گرامی مبالغ پیشنهاد شده به ازای<?= " " . $_ENUM2FA['bid_type'][$project->bid_type] ?> محاسبه خواهد شد
                </span>
            </div> 
        <? } elseif ($project->state == "Run" && $project->stakeholdered == 0) { ?>
            <div class="info-box">
                <a href<?= '="stakeholdere_' . $project->id . '"' ?>  class="popup">
                    <img src="medias/images/theme/download1.png" />
                    گروگذاری
                </a>
                <div class="">
                    <span class="info-icon-box">
                        توجه
                    </span>
                    در این مرحله شما باید مبلغ پیشنهاد تایید شده را گروگذاری نمایید تا پروژه ی شما شروع شود
                </div>
            </div>
        <? } else { ?>
            <?php
            if ($project->output == 'ONLINE') {
                ?>
                <div class="info-box">
                    <a href<?= '="typeonline_' . $project->id . '"' ?> target="_blank">
                        <img src="medias/images/theme/download1.png" />
                        نمایش آنلاین
                    </a>
                    <div >
                        کارفرمای گرامی:
                        <br/>
                        شما می توانید روند پیشرفت پروژه را به صورت آنلاین مشاهده نمایید
                    </div>
                </div>
            <? } ?>


            <div class="info-box">
                <a href<?= '="review-request_' . $project->id . '"' ?> class="popup">
                    <img src="medias/images/theme/download1.png" />
                    ثبت شکایت
                </a>
                <div class="">
                    کارفرمای گرامی:
                    <br/>
                    در صورتی که در هر یک از مراحل انجام کار،از مجری شکایت دارید
                    در این قسمت ثبت نمایید
                </div>
            </div>
        <? } ?>

        <?php if ($project->typist_id) { ?>
            <div class="info-box">
                <a href<?= '="send-message_' . $project->typist_id . '_' . $project->id . '"' ?>  class="popup">
                    <img src="medias/images/theme/download1.png" />
                    ارسال پیام
                </a>
                <div class="">
                    کارفرمای گرامی:
                    <br/>
                    شما می توانید از طریق این سامانه با 
                    <?= $_ENUM2FA['fa']['worker'] ?>
                    از طریق پیام داخلی ارتباط برقرار نمایید
                </div>
            </div>
            <div class="info-box">
                <a href<?= '="sendsms_' . $project->typist_id . '"' ?>  class="popup">
                    <img src="medias/images/theme/download1.png" />
                    ارسال پیامک
                </a>
                <div class="">
                    کارفرمای گرامی:
                    <br/>
                    شما می توانید از طریق این سامانه با 
                    <?= $_ENUM2FA['fa']['worker'] ?>
                    از طریق پیامک ارتباط برقرار نمایید
                </div>
            </div>
        <?php } ?>





        <?php if ($project->state == 'Run' || $project->state == 'Finish') { ?>

            <?php
            $index = 0;
            if (count($ff) > 0) {
                foreach ($ff as $f) {
                    $index++;
                    ?>
                    <?php
                    if ($f['can_download'] == 1) {
                        if ($project->output == 'ONLINE' && $f['final_file'] == 'ONLINE')
                            $dl_link = 'typeonline_' . $project->id . '?v=2007';
                        else
                            $dl_link = 'uploads/' . $subSite . '/final/' . $f['final_file'];
                        ?>
                        <div class="info-box">
                            <a download="<?= "Project_" . $project->getCode() . "_File_" . $index . "." . $files->extension($dl_link); ?>" href<?= '="' . $dl_link . '"' ?>  target="_blank">
                                <img src="medias/images/theme/download1.png" />
                                دانلود فایل نهایی
                                <?= count($ff) > 1 ? $index : "" ?>
                            </a>
                            <div>
                                تعداد 
                                <?php echo $f['pages'] . " " . $_ENUM2FA['bid_type_word'][$project->bid_type] ?> 
                                توسط 
                                <?= $user->getNickname($project->typist_id); ?> 
                                در تاریخ 
                                <?= $persiandate->date('d F Y ساعت H:i', $f['dateline']) ?> 
                                ارسال شده است

                                <br>

                                <?php echo $f['message'] ?>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="info-box">
                            <a href<?= '="finish-project_' . $project->id . '"' ?> class="popup"  target="_blank">
                                <img src="medias/images/theme/download1.png" />
                                اتمام پروژه
                            </a>
                            <div>
                                تعداد 
                                <?php echo $f['pages'] . " " . $_ENUM2FA['bid_type_word'][$project->bid_type] ?> 
                                توسط 
                                <?= $user->getNickname($project->typist_id); ?> 
                                در تاریخ 
                                <?= $persiandate->date('d F Y ساعت H:i', $f['dateline']) ?> 
                                ارسال شده است.
                                <br/>
                                برای دانلود کردن آن بایستی ابتدا 
                                پروژه را به پایان برسانید.

                            </div>
                        </div>
                        <?php
                        break;
                    }
                    ?>
                <?php } ?>
            <?php } else { ?>
                <!--                <div class="info-box">
                                    <a>
                                        <img src="medias/images/theme/download1.png" />
                
                                    </a>
                                    <div>
                                        فایل نهایی هنوز ارسال نشده است.
                                    </div>
                                </div>-->
            <?php } ?>
        <?php } ?>
        <?php if ($user->isAgency()) { ?>
            <? foreach ($project->getProjectFileLinks() as $link) { ?>
                <div class="info-box">
                    <a href<?= '=' . $link; ?> target="_blank">
                        <img src="medias/images/theme/download1.png" />
                         فایل پروژه
                    </a>
                    <div ><strong>کارفرمای گرامی</strong><br />
                        فایل هایی که خودتان ارسال کرده‌اید را می‌توانید دانلود نمایید
                    </div>
                </div>
            <?php } ?>
        <?php } ?>




        <?php if ($project->typist_id > 0 && $project->ranked_typist == -1 && count($ff) > 0) { ?>
            <br>
            <h1>امتیاز دهی به 
                <?= $_ENUM2FA['fa']['worker'] ?>
            </h1>
            <div style="padding:10px 20px; font-size: 15px; border:1px dashed #DDD; margin:10px;">
                <form class="form" method="post" action<?= '="' . $action_str . '"'; ?> >
                    <input type="hidden" name="formName" value="RankTypistForm" />
                    <input type="hidden" name="pid" value="<?php echo $project->id ?>" />
                    <label>پایبندی به تعهدات و زمانبندی:</label>
                    <select name="r1">
                        <option value="0">انتخاب نمایید...</option>
                        <option value="1">بسیار ضعیف</option>
                        <option value="2">ضعیف</option>
                        <option value="3">متوسط</option>
                        <option value="4">خوب</option>
                        <option value="5">خیلی خوب</option>
                    </select>
                    <label>دقت و <?= $_ENUM2FA['fa']['work'] ?> صحیح:</label>
                    <select name="r2">
                        <option value="0">انتخاب نمایید...</option>
                        <option value="1">بسیار ضعیف</option>
                        <option value="2">ضعیف</option>
                        <option value="3">متوسط</option>
                        <option value="4">خوب</option>
                        <option value="5">خیلی خوب</option>
                    </select>
                    <label>ویژگی های <?= $_ENUM2FA['fa']['worker'] ?> از نظر شما:</label>
                    <textarea name="wsc"
                              placeholder="<?= $_ENUM2FA['fa']['worker'] ?> را ارزیابی کنید"
                              ></textarea>
                    <label>
                        مراحل انجام پروژه در این سایت را چگونه ارزیابی میکنید؟
                    </label>
                    <textarea name="ssc"
                              placeholder="مراحل ثبت سفارش، زمان و سرعت تحویل، پشتیبانی و... چطور بود؟"
                              ></textarea>
                    <label> </label>
                    <input type="submit" value="ثبت امتیاز" name="submit" id="submit" />
                </form>
                <div class="clear"> </div>
            </div>
            <br>
        <?php } ?>


        <?php if ($project->verified != -1) { ?>
            <?php if ($project->typist_id > 0) { ?>
                <div class="info-box">
                    <a href<?= '="ajax-pages?page=project_bid&pid=' . $project->id . '"' ?>  class="popup">
                        <img src="medias/images/theme/download1.png" />
                        نمایش پیشنهادات
                    </a>
                    <div class="">
                        کارفرمای گرامی:
                        <br/>
                        لیست پشنهادهای ارسالی به این پروژه را می توانید در این قسمت ببینید
                    </div>
                </div>
            <? } else { ?>
                <h2>پیشنهادهای ارسال شده:</h2>
                <br>
                <div style="
                     clear: both ;
                     padding:10px;
                     direction:rtl;
                     background:#E2E2E2;
                     margin: 4px 0;">
                    <div id="project_bid_div"></div>
                    <img src="medias/images/icons/loading2.gif" width="32" height="32">
                </div>
                <script type="text/javascript">
                    curVer['project_bid']=0;
                    function afterCompose(){
                        updateData('project_bid', <?= ($project->state == 'Open') ? '1' : '30'; ?>*60,25,<?= $project->id ?>);
                    }
                    afterCompose();
                </script>
            <?php } ?>
        <?php } ?>
        <?
//        if ($project->group_id) {
//            $group = new Group($project->group_id);
//            echo $group->displayMembers();
//        }
        ?>
        <?= showVisitor($project); ?>
        <div class="clear"></div>
    </div>
</div>

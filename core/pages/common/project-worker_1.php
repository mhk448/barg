<?php
/* @var $database Database */
/* @var $cdatabase Database */
/* @var $user User */
/* @var $message Message */
/* @var $project Project */

if ($auth->validate('SubmitFinalFileForm', array(
            array('fl', 'File', 'فایل پروژه را انتخاب کنید.'),
        ))) {
    if ($project->submitFinalFile()) {
        $message->addMessage('فایل نهایی با موفقیت ارسال گردید.<br>فایل شما توسط کاربر بررسی می شود و پس از تایید آن وجه آن به اعتبار شما اضافه می گردد.');
    }
}

if ($auth->validate('SubmitGroupFileForm', array(
            array('fl', 'File', 'فایل را انتخاب کنید.'),
        ))) {
    if ($project->submitGroupFile($_POST['m'])) {
        $message->addMessage('فایل مورد نظر برای اعضای گروه به اشتراک گذاشته شد');
    }
}

if ($auth->validate('SubmitCreditGroupForm', array(
        ))) {
    if ($project->spelitCreditGroup('m_')) {
        $message->addMessage("انتقال وجه با موفقیت انجام شد");
    }
}

if ($auth->validate('SubmitGroupForm', array(
            array('gid', 'Required', 'گروه مورد نظر خود را انتخاب کنید.'),
        ))) {
    if ($project->setGroup(intval($_POST['gid']), 'ms', 'mt')) {
        $message->addMessage('پروژه برای اعضای گروه به اشتراک گذاشته شد');
    }
}

if ($auth->validate('SubmitShareForm', array(
            array('uid', 'Required', 'کاربر مورد نظر خود را انتخاب کنید.')
        ))) {
    if ($project->addShare($_REQUEST['uid'], $_REQUEST['msg'])) {
        $message->addMessage('پروژه با کاربر انتخاب شده به اشتراک گذاشته شد');
    }
}

if ($auth->validate('AddBidForm', array())) {
    if (isset($_POST['mode']) and $_POST['mode'] == "Delete") {
        if ($bid->delete($project, $user->id)) {
            $message->addMessage('پیشنهاد شما حذف شد');
        } else {
            $message->addMessage('شما نمی توانید این پیشنهاد را حذف کنید');
        }
    } else {
        if ($bid->add($project)) {
            $message->addMessage('پیشنهاد شما با موفقیت ارسال گردید.<br> جهت مشاهده پیشنهادهای خود به <a href="bids">صفحه پیشنهادهای من</a> مراجعه نمایید.');
        } else {
            $message->addMessage('شما نمی توانید این پیشنهاد را ویرایش کنید');
        }
    }
}

$id = (int) $project->id;
$userSentBid = new Bid();
$userSentBid->setMyProjectBid($id, $user->id);
$action_str = $id ? ("project_" . $id) : 'project'; // nc?

$ff = $project->getFinalFile();

if (isset($_REQUEST["showBidForm"])) {
    if ($project->state != 'Open' || !$user->isWorker()) {
        $message->displayError('امکان ارسال پیشنهاد وجود ندارد');
    } elseif ($project->lock_price > $user->getCredit()) {
        $message->displayError('شما حداقل اعتبار مورد نیاز برای پیشنهاد به این پروژه را ندارید. &nbsp;&nbsp;'
                . '<br/> اعتبار شما:‌ ' . $user->getCredit() . ' ریال '
                . '<br/><a href="' . $_CONFIGS['Site']['Sub']['Blog'] . '/type-help/type-why-typist-stakeholder"' . ' target="_blank">چرا باید این میزان اعتبار را داشته باشم؟</a> &nbsp;&nbsp;&nbsp; '
                . '<br/><a href="add-credit?need_p=' . $project->lock_price . '" class="active_btn popup">افزایش اعتبار</a>');
    } else {
        showBidForm($action_str, $userSentBid);
    }
} elseif (isset($_REQUEST["showFinalForm"])) {
    showFinalForm($action_str);
} elseif (isset($_REQUEST["showAddGroupForm"])) {
    showAddGroupForm($action_str);
} elseif (isset($_REQUEST["showGroupFileForm"])) {
    showGroupFileForm($action_str);
} elseif (isset($_REQUEST["showShareForm"])) {
    showShareForm($action_str);
} elseif (isset($_REQUEST["showCreditGroupForm"])) {
    showCreditGroupForm($action_str);
} else {
    ?>
    <div id="content-wrapper">
        <div>
            <div id="content">

                <?= $user->isAdmin() ? "" : showProjectInfo(); ?>

                <?php $message->display() ?>        




                <?php if (isCurrentWorker() && $project->state == 'Run' && $project->stakeholdered == 0) { ?>
                    <div class="info-box">
                        <span style="color: red">
                            از انجام پروژه قبل از گروگزاری کارفرما خودداری نمایید
                        </span>
                    </div>
                <?php } ?>

            </div>

            <script type="text/javascript">
                $(document).ready(function() {
                    $('#navigation .box h3.title').click(function() {
                        $(this).siblings('.content').slideToggle();
                    });
                });
            </script>
            <? if ($project->state !== 'Open' && $project->typist_id == $user->id || $user->isAdmin()) { ?>
                <div id="navigation" style="margin-bottom:550px;">
                <? } else { ?>
                    <div id="navigation" style="margin-bottom:300px;">
                    <? } ?>
                    <div class="box contact">
                        <h3 class="title">ارتباطات</h3>
                        <div class="content">
                            <? if (($project->typist_id == $user->id || $user->isAdmin())) { ?>






                                <div class="item msg"><a href<?= '="send-message_' . $project->user_id . '_' . $project->id . '"' ?>  class="popup">
                                        <span class="title">ارسال پیام</span>
                                        <span class="detail">ارسال پیام متنی از طریق سایت برای کارفرما</span>
                                    </a></div>

                                <div class="item sms"><a href<?= '="sendsms_' . $project->user_id . '"' ?>  class="popup">
                                        <span class="title">ارسال پیامک (اس ام اس)</span>
                                        <span class="detail">ارسال پیامک (اس ام اس) به کارفرما</span>
                                    </a></div>


                            <? } else { ?>
                                <div class="item chat">
                                    <span class="title">عدم دسترسی</span>
                                    <span class="detail">فقط در پروژهای خودتان دسترسی دارید.</span>
                                </div>
                            <? } ?>

                        </div>
                    </div>

                    <div class="box project-info">
                        <h3 class="title">اجزاء پروژه</h3>
                        <div class="content">
                            <div class="item download">

                                <? $dli = 0; ?>
                                <? foreach ($project->getProjectFileLinks() as $link) { ?>
                                    <? $dli++ ?>
                                    <a download="<?= "Project_" . $project->getCode() . "_Attachment_" . $dli . "." . $files->extension($link); ?>" href<?= '=' . $link; ?> target="_blank">

                                    <? } ?>

                                    <span class="title">دانلود فایل ضمیمه</span>
                                    <span class="detail">قبل از پیشنهاد، فایل پروژه را مشاهده نمایید</span>
                                </a></div>


                            <? if ($project->demo && isSubType()) { ?>
                                <? foreach (json_decode($project->demo, TRUE) as $dlink) { ?>
                                    <div class="item download">
                                        <a download="<?= "Project_" . $project->getCode() . "_Demo." . $files->extension($dlink); ?>" href<?= '="uploads/' . $subSite . '/project/' . $dlink . '"'; ?> target="_blank">
                                            <span class="title">دانلود نمونه فایل</span>
                                            <span class="detail">نمونه فایل پروژه رو می توانید مشاهده کنید</span>
                                        </a></div>

                                </div>
                            <? } ?>
                        <? } ?>


                        <?
                        if ($project->state == 'Open' AND
                                ($project->type != Project::$T_PRIVATE || $project->private_typist_id == $user->id ) AND
                                (!$userSentBid->id || $userSentBid->accepted == 0 || ($userSentBid->accepted == -2 && $userSentBid->dateline < time() - 2 * 60) )) {
                            ?>

                            <? if ($userSentBid->id) { ?>
                                <div class="item agree"><a href<?= '="' . $action_str . '?showBidForm=1"' ?> class="popup" >
                                        <span class="title">ویرایش پیشنهاد</span>
                                    </a> <span class="detail">شما هنوز می توانید پیشنهادتان را ویرایش کنید</span>
                                </div>


                            <? } else { ?>
                                <div class="item agree"><a href<?= '="' . $action_str . '?showBidForm=1"' ?> class="popup" >
                                        <span class="title">ارسال پیشنهاد</span>
                                    </a> <span class="detail">برای انجام کار پیشنهاد خود را ارسال کنید</span>
                                </div>
                            <? } ?>
                        <? } ?> 

                        <? if (($project->typist_id == $user->id || $user->isAdmin())) { ?>
                            <div class="item agree">
                                <span class="title">پیشنهادتان تایید است</span>
                                <span class="detail">این پروژه برای شما تایید شده است</span>
                            </div>
                        <? } ?>
                        <? if ($project->state == 'Run' && $userSentBid->accepted == 0) { ?>
                            <div class="item agree">
                                <span class="title">رد شدن یا نبود پیشنهاد</span>
                                <span class="detail">پیشنهادی وجود ندارد یا پذیرفته نشده است</span>
                            </div>
                        <? } ?>


                        <?php if ($project->typist_id == $user->id || $user->isAdmin()) { ?>
                            <?php if ($project->state == "Run") { ?>
                                <?php if ($project->canCancelBid() || $user->isAdmin()) { ?>
                                    <div class="item cancel">
                                        <a href<?= '="cancel-bid_' . $project->id . '"' ?> class="confirm">
                                            <span class="title">انصراف از پروژه</span>
                                            <span class="tooltip" title="پس از گروگذاری کارفرما تا 2 ساعت مهلت انصراف از پروژه برای شما وجود دارد">
                                                <span class="detail"> 
                                                    <? if ($project->stakeholdered == 0) { ?>
                                                        تا ۲ ساعت پس از گروگذاری کارفرما
                                                    <? } else { ?>
                                                        <?= $persiandate->counterDown('reject_bid', ($project->stakeholder_date + 2 * 60 * 60), ($user->isAdmin() ? '' : '#reject_bid_div')); ?>
                                                    <? } ?></span>
                                            </span>


                                    </div>
                                <? } ?>
                            <? } ?>



                            <?php if (!$project->canCancelBid()) { ?>
                                <div class="item cancel">
                                    <span class="title">انصراف از پروژه</span>
                                    <span class="tooltip" title="پس از تایید کارفرما 2 ساعت فرصت انصراف از پروژه وجود داشته است">

                                        <span class="detail"> مهلت انصراف گذشته است</span> </span>   

                                </div>

                            <? } ?>

                        <? } ?>



                        <? if ($project->typist_id == $user->id || $user->isAdmin()) { ?>
                            <div class="item complete">
                                <a href<?= '="' . $action_str . '?showFinalForm=1"' ?> class="popup" >

                                    <span class="title">ارسال فایل نهایی</span>
                                    <span class="detail">در انتها فایل تایپ شده را از اینجا ارسال کنید</span>

                                </a></div>
                            <?
                            $ff = $project->getFinalFile();
                            $index = 1;
                            if (count($ff) > 0) {
                                foreach ($ff as $f) {

                                    if ($project->output == 'ONLINE' && $f['final_file'] == 'ONLINE')
                                        $dl_link = 'typeonline_' . $project->id . '?v=2007';
                                    else
                                        $dl_link = 'uploads/' . $subSite . '/final/' . $f['final_file'];
                                    ?> 
                                    <div class="dlicon">
                                        <a class="tooltip" title=" تعداد 
                                        <?= $f['pages'] ?> 
                                           صفحه                                
                                           تاریخ 
                                           <?= $persiandate->date('d F Y ساعت H:i', $f['dateline']) ?> 
                                           توضیحات:
                                           <?= $f['message'] ?>" download="<?= "Project_" . $project->getCode() . "_File_" . $index . "." . $files->extension($dl_link); ?>" href<?= '="' . $dl_link . '"' ?>  target="_blank">
                                            <span class="textdl" title=" ">
                                                دانلود فایل نهایی
                                                <?= $index++ ?>
                                        </a>
                                        </span>
                                    </div>
                                <? } ?>
                            <? } ?>
                        <? } ?>

                    </div>
                </div>

                <div class="box group-working">
                    <h3 class="title">کار گروهی</h3>
                    <div class="content">
                        <!-- clases for this item : work or disable -->

                        <? if ($project->typist_id !== $user->id && !$user->isAdmin()) { ?>
                            <div class="item work">

                                <span class="title">عدم دسترسی</span>
                                <span class="detail">در این مرحله این امکان غیرفعال است</span>


                            </div>
                        <? } else { ?>



                            <div class="item work">

                                <? if (!$project->isShared() && $project->state == 'Run' && count($user->getActiveGroups()) > 0) { ?>
                                    <a href<?= '="' . $action_str . '?showAddGroupForm=1"' ?> class="popup" >
                                        <span class="title">انجام کار به صورت گروهی</span>
                                        <span class="detail">اشتراک گذاری پروژه برای اعضاء گروه</span>
                                    </a>
                                <? } ?> 
                                <? if ($project->isShared() && $project->state == 'Run') { ?>
                                    <span class="title">انجام کار به صورت گروهی</span>
                                    <span class="detail">پروژه برای گروه به اشتراک گذاشته شده است</span>
                                <? } ?>
                                <? if (!$project->isShared() && $project->state == 'Run' && !count($user->getActiveGroups()) > 0) { ?>
                                    <span class="title">انجام کار به صورت گروهی</span>
                                    <span class="tooltip" title="گروه خود را یا تشکیل نداده اید و یا ظرفیت گروه از حد مجاز کمتر یا بیشتر است برای بررسی کلیک نمایید">
                                        <a href="edit-group">
                                            <span class="detail">گروهی وجود ندارد یا تکمیل نشده است</span></a>
                                    <? } ?>

                                    <? if (!$project->isShared() && $project->state == 'Finish') { ?>
                                        <span class="title">انجام کار به صورت گروهی</span>
                                        <span class="detail">در این مرحله امکان اشتراک گذاری وجود ندارد</span>
                                    <? } ?>
                                    <? if ($project->isShared() && $project->state == 'Finish') { ?>
                                        <span class="title">انجام کار به صورت گروهی</span>
                                        <span class="detail">پروژه به صورت گروهی انجام شده است</span>
                                    <? } ?>
                            </div>

                            <div class="item share">

                                <? if ($project->state == 'Run') { ?>
                                    <script type="text/javascript">
                                        function selectUser(id,username){
                                            mhkform.ajax("project_<?= $project->id ?>?showShareForm=1&ajax=1$addUser=1&uid="+id+"","");
                                        }
                                    </script>
                                    <a onclick="return mhkform.ajax('user-list_worker&ajax=1');" id="share" >

                                    <? } ?>

                                    <span class="title">اشتراک گذاری پروژه</span>
                                    <span class="detail">اشتراک گذاری پروژه برای سایر کاربران</span>
                                </a></div>





                            <? if ($project->isShared()) { ?>
                                <div class="item twit">
                                    <a href<?= '="twitts_projectworker_' . $project->id . '"' ?> class="" target="_blank" >


                                        <span class="title">توئیت اختصاصی مجریان</span>
                                        <span class="detail">توئیت ویژه اعضاء گروه و یا مشترکین پروژه</span>
                                    </a></div>

                            <? } ?>

                            <? if ($project->state == 'Finish' && !$project->group_split_info && ($project->typist_id == $user->id || $user->isAdmin())) { ?>

                                <div class="item groupprice">
                                    <a href<?= '="' . $action_str . '?showCreditGroupForm=1"' ?> class="popup" >
                                        <span class="title">تقسیم دستمزد</span>
                                        <span class="detail">دستمزد همکاران را پرداخت کنید</span>
                                    </a> </div>

                            <? } ?>

                            <? if ($project->isShared()) { ?>
                                <div class="item send">                
                                    <a href<?= '="' . $action_str . '?showGroupFileForm=1"' ?> class="popup" >              
                                        <span class="title">ارسال فایل برای گروه</span>
                                        <span class="detail">فایل‌های قابل‌نمایش برای مشترکین پروژه</span>
                                    </a> </div>
                            <? } ?>


                            <?
                            if ($project->isShared() && isCurrentWorker()) {
                                $group_files = $project->getGroupFile();
                                if (count($group_files) > 0) {
                                    foreach ($group_files as $f) {
                                        $name = $user->getNickname($f['user_id']);
                                        $dl_link = 'uploads/' . $subSite . '/group_file/' . $f['file'];
                                        ?>
                                        <div class="dlgroup">
                                            <a class="tooltip" title=" یک فایل توسط 
                                            <?= $name ?> 
                                               در تاریخ 
                                               <?= $persiandate->date('d F Y ساعت H:i', $f['dateline']) ?> 
                                               ارسال شده است.
                                               توضیحات:
                                               <?php echo $f['message'] ?>" href<?= '="' . $dl_link . '"' ?>  target="_blank">

                                                <span class="textdl" title=" ">
                                                    فایل 
                                                    <?= $name ?>
                                                </span></a>

                                        </div>

                                    <? } ?>
                                <? } ?>
                            <? } ?>

                        <? } ?>
                    </div>




                <?php } ?>
            </div>

            <div class="box reports">
                <h3 class="title">گزارشات</h3>
                <div class="content">
                    <?php if ($project->typist_id == $user->id || $user->isAdmin()) { ?>
                        <div class="item master-pawn">
                            <span class="title">وضعیت گروگذاری کارفرما</span>
                            <?php if (($project->state != 'Finish' && $project->stakeholdered == 1)) { ?>
                                <?php if ($project->type != 'Agency') { ?>
                                    <span class="tooltip" title="مبلغ<?= $project->earnest ?>ریال توسط کارفرما به عنوان ضمانت پرداخت شده است"> 
                                        <span class="detail">کارفرما اقدام به گروگذاری کرده است</span>
                                    </span>

                                <?php } else { ?>
                                    <span class="tooltip" title="در پروژه های نمایندگی، جهت سرعت بخشیدن به انجام پروژه، تایپایران ضمانت پرداخت آنها را تایید می کند.">
                                        <span class="detail">تضمین پرداخت پروژه توسط تایپایران</span>    <?php } ?> 

                                <?php } ?>

                                <?php if (isCurrentWorker() && $project->state == 'Run' && $project->stakeholdered == 0) { ?>

                                    <span class="tooltip" title="از انجام پروژه قبل از گروگذاری کارفرما خودداری نمایید">
                                        <span class="detail">کارفرما اقدام به گروگذاری نکرده است</span>
                                    </span>

                                <?php } ?>

                                <?php if (isCurrentWorker() && $project->state == 'Finish') { ?>
                                    <span class="detail">بیعانه آزاد و دستمزد پرداخت شده است</span>
                                <?php } ?>

                        </div>
                        <div class="item your-pawn">
                            <?php if (($project->state != 'Finish')) { ?>


                                <span class="title">وضعیت گروگذاری شما</span>
                                <span class="tooltip" title="مبلغ گروگذاری به عنوان ضمانت حسن انجام کار توسط شما تا زمان دریافت فایل توسط کارفرما نزد سایت قفل می شود و پس از آن آزاد می شود">
                                    <span class="detail">شما مبلغ <?= $project->earnest ?>ریال گروگذاری کرده اید</span></span>
                            <?php } ?>
                            <?php if (($project->state == 'Finish')) { ?>
                                <span class="title">وضعیت گروگذاری شما</span>
                                <span class="detail">گروگذاری شما به اعتبارتون برگشت داده شده</span>
                            <?php } ?>


                        <?php } ?>   
                    </div>


                    <?php if ($project->state == 'Finish' && $project->typist_id == $user->id || $user->isAdmin()) { ?>
                        <div class="item dastmozd">               		
                            <span class="title">دستمزد پروژه</span>
                            <span class="tooltip" title="مبلغ کل دستمزد این پروژه می باشد، ممکن است پروژه رو اشتراک گذاشته باشید و بخشی از آن را با هم گروهی های خود تقسیم کرده باشید، در این صورت جدول تقسیم دستمزد رو مشاهده می کنید">
                                <span class="detail">دستمزد این پروژه <?= $project->getWorkerPrice(); ?>ریال است</span></span>
                        </div>
                    <?php } ?>                    


                    <?php if (($project->state !== 'Open')) { ?>
                        <?php if ($project->typist_id == $user->id || $user->isAdmin()) { ?>
                            <div class="item agree-time">
                                <span class="title">زمان تائید پیشنهاد</span>
                                <span class="detail"><?= $persiandate->date('d F Y ساعت H:i', $project->stakeholder_date) ?> </span>
                            </div>
                        <?php } ?>
                    <?php } ?>

                    <div class="item protest"> 
                        <a href<?= '="review-request_' . $project->id . '"' ?> class="popup">
                            <span class="title">ثبت شکایت و بازبینی</span>
                            <span class="tooltip" title="قبل از ثبت شکایت مطالب مندرج در صفحه پرسش و پاسخ های پروژه را مطالعه نمایید، این صفحه در منو بخش پشتیبانی وجود دارد">
                                <span class="detail">درخواست بررسی و شکایت پیرامون پروژه</span></span></a>
                    </div>



                </div>
            </div>
        </div> 
    </div> 
    <? if ($project->typist_id == $user->id || $user->isAdmin()) { ?>
        <? if ($project->state == 'Finish' && $project->isShared()) { ?>
            <? if ($project->group_split_info) { ?>
                <? $us = json_decode($project->group_split_info, TRUE) ?>
                <br/>
                <table class="projects">
                    <tr>
                        <td colspan="2" style="text-align: center">
                            جدول تقسیم دستمزد
                        </td>
                    </tr>
                    <? $sum_split_price = 0; ?>
                    <? foreach ($us as $uid => $split_price) { ?>
                        <? $sum_split_price+=$split_price; ?>
                        <tr>
                            <td>کاربر <?= $user->getNickname($uid); ?>:</td>
                            <td>
                                <label class="price"><?= $split_price; ?></label>
                                <label>ریال</label>
                            </td>
                        </tr>
                    <? } ?>
                    <tr>
                        <td>جمع:</td>
                        <td>
                            <label class="price"><?= $sum_split_price; ?></label>
                            <label>ریال</label>
                        </td>
                    </tr>
                </table>
                <br/>
            <? } ?>

        <? } ?>
        <?
        if ($project->isShared()) {
            $out = "";
            foreach ($project->getSharedUsers() as $mem) {
                $u = new User($mem['user_id']);
                $out .= $u->displayMiniInfo(TRUE, TRUE, TRUE) . " ";
            }
            echo $out;
        }
        ?>
    <? } ?>
    <?= showVisitor($project); ?>
    <?= showBiders($project); ?>




    <?

    function showBidForm($action_str, $userSentBid) {
        global $_PRICES, $project, $_ENUM2FA, $user;
        $worker_price = ($user->special_type == User::$S_SPECIAL) ? 1 : ($_PRICES['P_TYPIST']);
        ?>
        <a name="bidform"></a>
        <h2>ارسال پیشنهاد</h2>
        <hr>
        <?php if (isSubType() && $project->type != 'Agency') { ?>
            <div style="float: left;"><br/>نرخنامه تایپایران<br/><?= SHOW_PRICE_TABLE("user"); ?></div>
        <? } ?>
        <div style="float: right;padding: 5px 20px;width: 650px;text-align: justify;">
            <b>نکات:‌</b>
            <ul class="disc">
                <?= Content::BODY(Content::$NOTE_PROJECT_BID); ?>
                <?php if ($project->type == 'Agency') { ?>
                    <li>
                        قیمت بر اساس نرخ استاندارد محاسبه میشود،
                        <span style="color: red">
                            از درج قیمت
                        </span>    
                        در قسمت 

                        <span style="color: red">
                            توضیحات
                        </span>    

                        جدا خودداری نمایید
                    </li>
                <?php } else { ?>
                    <?= Content::BODY(Content::$NOTE_PROJECT_BID_NO_AGENCY); ?>
                    <li>
                        قیمت پیشنهادی خود را در کادر مخصوص وارد نمایید.
                        در صورتی که قیمت را پیشنهاد ندهید مبلغ انجام این کار برای شما
                        <span style="color: red">
                            صفر
                        </span>
                        خواهد بود.
                        قیمت به پیشنهادی به ازای
                        <span style="color: red">
                            <?= $_ENUM2FA['bid_type'][$project->bid_type]; ?>
                        </span>
                        خواهد بود
                    </li>
                <?php } ?>
            </ul>    


            <form method="post" class="form" action<?= '="' . $action_str . '"'; ?> enctype="multipart/form-data">
                <input type="hidden" name="formName" value="AddBidForm" />
                <input type="hidden" name="pid" value="<?php echo $project->id ?>" />
                <input type="hidden" name="bt" value="<?php echo $project->bid_type ?>" />
                <?php if ($project->type == 'Agency') { ?>
                    <label style="width:300px">قیمت   <?= $_ENUM2FA['bid_type'][$project->bid_type]; ?>
                        <? echo $_PRICES['worker'][$project->lang] ?>
                        ریال
                    </label>
                <?php } else { ?>
                    <? $bg_col[Bid::$TYPE_FULL] = "fd91ff"; ?>
                    <? $bg_col[Bid::$TYPE_PERMIN] = "ccccff"; ?>
                    <? $bg_col[Bid::$TYPE_PERPAGE] = "ff6666"; ?>
                    <? $bg_col[Bid::$TYPE_PERWORD] = "ccffcc"; ?>


                    <label style="width: 150px;" class="help">
                        مبلغ پیشنهادی (ریال)
                    </label>
                    <input type="text" name="p" required="required" class="appt numberfild help" style="background-color: <?= "#" . $bg_col[$project->bid_type]; ?>;width:100px" <?= (isSubType() ? '' : '') ?> onkeyup="apptFun();" value="<?= $userSentBid->price ?>"/>
                    <span style="color: red">
                        <?= $_ENUM2FA['fa']['worker'] ?> محترم مبلغ پیشنهادی به ازای 
                        <?= $_ENUM2FA['bid_type'][$project->bid_type]; ?>
                        محاسبه خواهد شد
                    </span>
                    <div class="help_comment">
                        قیمت پیشنهادی خود را وارد نمایید. در صورتی که قیمت را پیشنهاد ندهید مبلغ انجام این کار برای شما 0 خواهد بود
                    </div>

                    <script type="text/javascript">
                        function apptFun(){
                            var PT=<?= $worker_price; ?>;
                            var p = parseInt($(".appt").val());
                            $("#app").html(p);
                            $("#ptt").html(Math.round(p * PT));
                            $("#pttt").html(Math.round(p * PT)/10);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
                            $("#app").addClass('price');
                            $("#ptt").addClass('price');
                            $("#pttt").addClass('price');
                            initPriceFormat();
                        }
                        initHelpBox();
                    </script>
                <?php } ?>
                <label style="width: 150px;">توضیح و پیام</label>
                <textarea name="m" style="width:30%; height:100px;"><?= $userSentBid->message ?></textarea>
                <!--                <label>فایل ضمیمه (ZIP)</label>
                                <input type="file" name="fl" style="width:300px" />-->

                <?php if ($project->type == 'Agency') { ?>
                <?php } else { ?>
                    <div class="input" style="padding-right: 20px;display: inline-block;float: right;margin-right: 5px; height:100px;">
                        <ul >
                            <li><b>قیمت <?= $_ENUM2FA['bid_type'][$project->bid_type]; ?>:<span id="app">0</span> ریال</b></li>
                            <li>کارمزد مرکز: <?= (1 - $worker_price) * 100; ?>%</li>
                            <li>مالیات برارزش افزوده: 0</li>
                            <li><b>میزان عایدی شما: <span id="ptt" class="price">0</span> ریال</b></li>
                            <li><b style="color: red">معادل: <span id="pttt" class="price">0</span> تومان</b></li>
                        </ul>
                    </div>
                <?php } ?>

                <label style="width: 150px;"> </label>
                <input type="checkbox"  checked="checked" onclick="return false;"/>
                <div class="label">
                    تایید قوانین این مرکز
                </div>
                <label style="width: 150px;"> </label>
                <? if ($userSentBid->id) { ?>
                    <input type="hidden" value="Edit" name="mode" />
                    <input type="submit" value="ویرایش" name="submit" id="submit" style="" />
                </form>
                <form method="post" class="form" action<?= '="' . $action_str . '"'; ?> >
                    <input type="hidden" name="formName" value="AddBidForm" />
                    <input type="hidden" name="pid" value="<?php echo $project->id ?>" />
                    <input type="hidden" value="Delete" name="mode" />
                    <input type="submit" value="حذف" name="submit" style="" />

                <? } else { ?>
                    <input type="hidden" value="Add" name="mode" />
                    <input type="submit" value="ارسال پیشنهاد" name="submit" id="submit"  style="" />
                <? } ?>

            </form>

        </div>

        <div class="clear"></div>
    <? } ?>



    <?

    function showFinalForm($action_str) {
        global $_PRICES, $project;
        $fabidtype[Bid::$TYPE_FULL] = "تعداد صفحات";
        $fabidtype[Bid::$TYPE_PERMIN] = "زمان (دقیقه)";
        $fabidtype[Bid::$TYPE_PERPAGE] = "تعداد صفحات";
        $fabidtype[Bid::$TYPE_PERWORD] = "تعداد کلمات";
        ?>
        <br/>
        <h2>ارسال فایل نهایی پروژه</h2>
        <hr/>
        <div style="text-align: right">
            <b>نکات:‌</b>
            <ul class="disc">
                <?php if ($project->type == 'Agency') { ?>
                <?php } else { ?>
                                                                                                                                                                                                                <!--                <li><b>قیمت پروژه: <?php echo number_format($project->accepted_price) ?> ریال</b></li>
                                                                                                                                                                                                                <li>کارمزد مرکز: <?= (1 - $_PRICES['P_TYPIST']) * 100; ?>%</li>
                                                                                                                                                                                                                <li><b>میزان عایدی شما: <?php echo number_format(($project->accepted_price * $_PRICES['P_TYPIST'])) ?> ریال</b></li>-->
                <?php } ?>
                <?php if ($project->output != 'ONLINE') { ?>
                    <?= Content::BODY(Content::$NOTE_PROJECT_FINAL_FILE); ?>
                <?php } ?>
                <!--            <li>در قسمت مربوط به تعداد صفحات، تعداد صفحات فایل نهایی را وارد کنید</li>-->
            </ul>
        </div>
        <form method="post" class="form" action<?= '="' . $action_str . '"'; ?> enctype="multipart/form-data">
            <input type="hidden" name="formName" value="SubmitFinalFileForm" />
            <input type="hidden" name="pid" value="<?php echo $project->id ?>" />
            <?php if ($project->type == 'Agency') { ?>
                <label>توضیح و پیام:</label>
                <textarea name="m" style="width:300px; height:120px;"></textarea>
                <label>فایل نهایی:</label>
                <input type="file" name="fl" style="width:300px" />
                <label><?= $fabidtype[$project->bid_type] ?>:</label>
                <input type="text" name="pp" class="numberfild"/>
                <label> </label>
                <input type="submit" value="ارسال" name="submit" id="submit" />
            <?php } elseif ($project->output != 'ONLINE') { ?>
                <label>توضیح و پیام:</label>
                <textarea name="m" style="width:300px; height:120px;"></textarea>
                <label>فایل نهایی:</label>
                <input type="file" name="fl" style="width:300px" />
                <label><?= $fabidtype[$project->bid_type] ?>:</label>
                <input type="text" name="pp" class="numberfild"/>
                <label> </label>
                <input type="submit" value="ارسال" name="submit" id="submit" />
            <?php } else { ?>
                <input type="hidden" name="m" value="فایل نهایی شما آماده شد" />
                <label><?= $fabidtype[$project->bid_type] ?>:</label>
                <input type="text" name="pp" class="numberfild"/>
                <!--<input type="hidden" name="pp" value="<?= $project->guess_page_num ?>" />-->
                <label> </label>
                <input type="submit" value="تایید و ثبت" name="submit" id="submit" />
            <?php } ?>
        </form>
        <div class="clear"></div>
        <br/><br/>
        <?
    }

    function showAddGroupForm($action_str) {
        global $_PRICES, $project, $user;
        $groups = $user->getActiveGroups();
        ?>
        <br/>
        <h2>انجام گروهی پروژه</h2>
        <hr/>
        <div style="text-align: right">
            <b>نکات:‌</b>
            <ul class="disc">
                <li>امتیازی که از پروژه های گروهی دریافت می کنید علاوه بر ثبت شدن در سابقه شما در رتبه گروه نیز تاثیر دارد</li>
                <li>مسئولیت انجام صحیح پروژه بر عهده شما است و دستمزد پروژه به حساب کاربری شما اضافه خواهد شد</li>
                <li>اطلاعات پروژه از جمله فایل ضمیمه، هزینه پروژه، پیامهایی که به پروژه پیوست شده و ... به اشتراک گذاشته می شود</li>
                <!--<li></li>-->
            </ul>
        </div>
        <?
        foreach ($groups as $group0) {
            $group = new Group($group0['id']);
            $mems = $group->getMembers();
            ?>
            <form method="post" class="form" action<?= '="' . $action_str . '"'; ?> enctype="multipart/form-data">
                <input type="hidden" name="formName" value="SubmitGroupForm" />
                <input type="hidden" name="pid" value="<?php echo $project->id ?>" />
                <label>عنوان گروه:</label>
                <input type="text" name="" value="<?= $group->title; ?>" readonly="readonly" />
                <input type="hidden" name="gid" value="<?= $group->id; ?>" />
                <? foreach ($mems as $mem) { ?>
                    <?
                    if ($mem['user_id'] != $user->id) {
                        $uname = $user->getNickname($mem['user_id']);
                        ?>
                        <label>دعوت از <?= $uname ?>:</label>
                        <input type="checkbox" name="ms_<?= $mem['user_id'] ?>" class="" onclick="$('.mst_<?= $mem['user_id'] ?>').toggle()" />
                        <span style="display: none" class="mst_<?= $mem['user_id'] ?>">
                            <!--<label></label>-->
                            <textarea name="mt_<?= $mem['user_id'] ?>" placeholder="توضیحات برای کاربر <?= $uname; ?>"></textarea>    
                        </span>
                    <? } ?>
                <? } ?>
                <label></label>
                <input type="submit" value="تایید " name="submit" id="submit" />
            </form>
            <div class="clear"></div>
            <br/><br/>
        <? } ?>
        <?
    }

    function showShareForm($action_str) {
        global $_PRICES, $project, $user, $_ENUM2FA;
        ?>
        <br/>
        <h2>به اشتراک گذاری پروژه</h2>
        <hr/>
        <div style="text-align: right">
            <b>نکات:‌</b>
            <ul class="disc">
                <li>مسئولیت انجام صحیح پروژه بر عهده شما است و دستمزد پروژه به حساب کاربری شما اضافه خواهد شد</li>
                <li>اطلاعات پروژه از جمله فایل ضمیمه، هزینه پروژه، پیامهایی که به پروژه پیوست شده و ... به اشتراک گذاشته می شود</li>
                <!--<li></li>-->
            </ul>
        </div>
        <form method="post" class="form" action<?= '="' . $action_str . '"'; ?> enctype="multipart/form-data">
            <input type="hidden" name="formName" value="SubmitShareForm" />
            <input type="hidden" name="pid" value="<?php echo $project->id ?>" />
            <input type="hidden" name="uid" value="<?= $_REQUEST['uid'] ?>" />
            <label></label>
            <input value="دعوت از <?= $user->getNickname($_REQUEST['uid']) ?>" type="button">
            <label>توضیحات:</label>
            <textarea name="msg" placeholder="توضیحات "></textarea>    
            <label></label>
            <input type="submit" value="تایید " name="submit" id="submit" />
        </form>
        <div class="clear"></div>
        <br/><br/>
        <?
    }

    function showGroupFileForm($action_str) {
        global $_PRICES, $project;
        $g = $project->getGroup();
        ?>
        <br/>
        <h2>ارسال فایل به گروه</h2>
        <hr/>
        <div style="text-align: right">
            <b>نکات:‌</b>
            <ul class="disc">
                <li>فقط اعضای گروه 
                    «<?= $g->title ?>»
                    به فایلهایی که از این طریق ارسال می شوند دسترسی دارند</li>
                <!--<li></li>-->
            </ul>
        </div>
        <form method="post" class="form" action<?= '="' . $action_str . '"'; ?> enctype="multipart/form-data">
            <input type="hidden" name="formName" value="SubmitGroupFileForm" />
            <input type="hidden" name="pid" value="<?php echo $project->id ?>" />
            <label>توضیح و پیام:</label>
            <textarea name="m" style="width:300px; height:120px;"></textarea>
            <label>فایل </label>
            <input type="file" name="fl" style="width:300px" />
            <label> </label>
            <input type="submit" value="ارسال" name="submit" id="submit" />
        </form>
        <div class="clear"></div>
        <br/><br/>
        <?
    }

    function showCreditGroupForm($action_str) {
        global $_PRICES, $project, $user;
        $mems = $project->getSharedUsers();
        ?>
        <br/>
        <h2>تقسیم دستمزد</h2>
        <hr/>
        <div style="text-align: right">
            <b>نکات:‌</b>
            <ul class="disc">
                <li></li>
            </ul>
        </div>
        <form method="post" class="form" action<?= '="' . $action_str . '"'; ?> enctype="multipart/form-data">
            <input type="hidden" name="formName" value="SubmitCreditGroupForm" />
            <input type="hidden" name="pid" value="<?php echo $project->id ?>" />

            <label>هزینه پروژه</label>
            <input type="text" class="numberfild" value="<?= $project->getWorkerPrice(); ?>" disabled="disabled" />
            <? foreach ($mems as $mem) { ?>
                <? if ($mem['user_id'] != $user->id) { ?>
                    <label><?= $_ENUM2FA['fa']['worker'] ?> <?= $user->getNickname($mem['user_id']) ?>:</label>
                    <input type="text" name="m_<?= $mem['user_id'] ?>" class="numberfild mem_group" onkeyup="culc_credit()" value="0" />
                <? } ?>
            <? } ?>
            <label>سهم شما(<?= $user->getNickname() ?>):</label>
            <input type="text" name="m_<?= $user->id ?>" class="numberfild my_credit" readonly="readonly" value="<?= $project->getWorkerPrice(); ?>"/>

            <script type="text/javascript">
                $p_price=<?= $project->getWorkerPrice() ?>;
                function culc_credit(){
                    sumGC=0;
                    var m=$('.mem_group');
                    for(var i=0;i<m.length;i++){
                        sumGC += parseInt($(m[i]).val());
                    }
                    $('.my_credit').val($p_price - sumGC);
                    if(!sumGC || $p_price < sumGC){
                        $('.submit_credit').attr("disabled", "disabled");
                        $('.submit_credit').hide();
                        $('.invalid_msg').show();
                    }else{
                        $('.submit_credit').removeAttr("disabled");
                        $('.submit_credit').show();
                        $('.invalid_msg').hide();
                    }
                }
            </script>
            <label></label>
            <input type="text" class="invalid_msg" style="display: none;color: red" disabled="disabled" value="مبالغ را اصلاح نمایید"/>
            <input type="submit" class="submit_credit" value="انتقال" name="submit" id="submit" onclick="$(this).hide();" />
        </form>
        <div class="clear"></div>
        <br/><br/>
        <?
    }
    ?>


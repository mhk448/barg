<?php
$p = $pager->getParamById('projects');
$project = new Project($p['id']);
$ff = $project->getFinalFile();
$bid = $project->getAcceptedBid();

$fileNotExist = FALSE;
if (!$ff) {
    $fileNotExist = TRUE;
    $message->addMessage("فایل نهایی توسط مجری هنوز ارسال نشده است");
    $message->addMessage("لطفا منتظر اتمام پروژه بمانید");
}

$ff = $ff[0];
if ($p['state'] == 'Finish') {
    Report::addLog("Error set finish finished project uuid:sdfsdsfsfe");
    header('Location: project_' . $project->id);
    exit;
}
if ($p['type'] == 'Agency') {
    $pprice = roundPrice($ff['pages'] * $_PRICES['agency'][$p['lang']]);
} else {
    if ($bid->type == Bid::$TYPE_PERPAGE ||
            $bid->type == Bid::$TYPE_PERWORD ||
            $bid->type == Bid::$TYPE_PERMIN) {
        $pprice = roundPrice($ff['pages'] * $bid->price);
    } elseif ($bid->type == Bid::$TYPE_FULL) {
        $pprice = $p['accepted_price'];
    }
}
if ($fileNotExist) {
    $message->display();
} elseif (isset($_CONFIGS['Params'][2]) && $_CONFIGS['Params'][2] === 'AP1') {
    $u_typist = new User($project->typist_id);
    if ($p['type'] == 'Agency') {
        if ($user->getCredit(TRUE) < $pprice) {
            $message->displayError('شما اعتبار لازم جهت بستن پروژه را ندارید.<br>اعتبار شما:‌ ' . $user->getCredit(TRUE) . ' ریال &nbsp;&nbsp;&nbsp; <br/><center><a href="add-credit?need_p=' . ($pprice - $project->lock_price) . '&sq=finish-project_' . $project->id . '_AP1" class="active_btn">افزایش اعتبار</a></center>');
        } else {
            if (isset($ff['pages'])) {
                $upprice = roundPrice($ff['pages'] * $_PRICES['worker'][$p['lang']]);
                $pprice = $discount->derogate($p['discount_code'], $pprice);

                if ($u_typist->special_type == User::$S_SPECIAL)
                    $elmend_price = 0;
                else
                    $elmend_price = $pprice - $upprice;

                $project->setFinish($elmend_price, $pprice);
                if (mysql_errno() > 0)
                    $message->addError('خطایی رخ داده است.');
                else {
                    $message->addMessage('پروژه شما با موفقیت بسته شد. <br>هم اکنون می توانید فایل نهایی را دانلود نمایید.<br><a class="active_btn" href="project_' . $p['id'] . '">رفتن به صفحه پروژه جهت دانلود فایل نهایی</a>');
//                    $message->addMessage('پروژه شما با موفقیت بسته شد. <br>هم اکنون می توانید فایل نهایی را دانلود نمایید');
                }
                include 'core/pages/' . $subSite . '/project.php';
            } else {
                $message->displayError('فایل نهایی پروژه هنوز توسط مجری ارسال نگردیده است.');
            }
        }
    } else {
        if ($p['stakeholdered'] == 0) {
            $message->displayError('هنوز پروژه را گروگزاری نکرده اید. &nbsp;&nbsp;&nbsp; <a href="stakeholdere_' . $p['id'] . '">گروگزاری پروژه</a>');
        } elseif ($user->getCredit(TRUE) < $pprice) {
            $message->displayError('شما اعتبار لازم جهت بستن پروژه را ندارید.<br>اعتبار شما:‌ ' . $user->getCredit(TRUE) . ' ریال &nbsp;&nbsp;&nbsp; <br/><center><a href="add-credit?need_p=' . ($pprice - $project->lock_price) . '&sq=finish-project_' . $project->id . '_AP1" class="active_btn">افزایش اعتبار</a></center>');
        } else {
            if (isset($ff['pages'])) {
                $upprice = roundPrice($pprice * $_PRICES['P_TYPIST']);
                $pprice = $discount->derogate($p['discount_code'], $pprice);

                if ($u_typist->special_type == User::$S_SPECIAL)
                    $elmend_price = 0;
                else
                    $elmend_price = $pprice - $upprice;

                $project->setFinish($elmend_price, $pprice);
                if (mysql_errno() > 0)
                    $message->addError('خطایی رخ داده است.');
                else {
                    $message->addMessage('پروژه شما با موفقیت بسته شد. <br>هم اکنون می توانید فایل نهایی را دانلود نمایید.<br><a class="active_btn" href="project_' . $p['id'] . '">رفتن به صفحه پروژه جهت دانلود فایل نهایی</a>');
//                    $message->addMessage('پروژه شما با موفقیت بسته شد. <br>هم اکنون می توانید فایل نهایی را دانلود نمایید');
                }
                include 'core/pages/' . $subSite . '/project.php';
            } else {
                $message->displayError('فایل نهایی پروژه هنوز توسط مجری ارسال نگردیده است.');
            }
        }
    }
    $message->display();
    //header("Location:  project_".$bid['project_id']);
} else {
    ?>
    <div id="content-wrapper">
        <div id="content">
            <h1>پایان پروژه و آزادسازی</h1>
            <?php $message->display() ?>
            <br>
            <table width="90%" align="center" class="projects">
                <tr>
                    <td><b>وضعیت پروژه:</b> <?= $_ENUM2FA['state'][$p['state']] ?></td>
                    <td><b>نوع پروژه:</b> <?= $_ENUM2FA['type'][$p['type']] ?></td>
                </tr>
                <tr>
                    <td><b>تاریخ ارسال:‌</b> <?php echo $persiandate->date('d F Y ساعت H:i', $p['submit_date']) ?></td>
                    <td><b>حداکثر تاریخ تحویل: </b>  <?php echo $persiandate->date('d F Y ساعت H:i', $p['expire_time']) ?></td>
                </tr>
                <tr>
                    <td><b><?= $_ENUM2FA['fa']['worker'] ?></b> <?= $user->getNickname($p['typist_id']) ?></td>
                    <td><b>تخمین قیمت:</b> <?php
        if ($p['type'] == 'Agency') {
            global $_PRICES;
            echo 'به ازای هر صفحه ' . round($_PRICES[($p['lang'])] * $_PRICES['P_AGENCY']);
        } else {
            echo number_format($p['max_price']);
        }
            ?> ریال </td> 
                </tr>
    <!--				<tr>
                        <td><b>مهلت اجرای پروژه:</b> <?php //echo $p['delivery_days']                     ?> روز و <?php // echo $p['delivery_hours']                    ?> ساعت</td>
                        <td><b>حداقل اعتبار مورد نیاز:</b>  <?php //echo $p['min_credit']                     ?> ریال</td>
                </tr>-->
                <tr>
                    <td><b>تعداد پیشنهادات:</b> <?= $project->getBidsCount(); ?></td>
                    <td><b>زبان پروژه:</b>  
                        <?php
                        $l = explode("2", $p['lang']);
                        if (count($l) > 1) {
                            echo $_ENUM2FA['lang'][$l[0]] . " به " . $_ENUM2FA['lang'][$l[1]];
                        } else {
                            echo $_ENUM2FA['lang'][$p['lang']];
                        }
                        ?>
                    </td>
                </tr>
            </table>
            <br>
            <h1>هزینه پروژه</h1>
            <br>
            <?php if ($p['type'] == 'Agency') { ?>
                هزینه‌ای که از اعتبار شما کسر خواهد گردید = تعداد صفحات x قیمت هر صفحه به زبان پروژه
                <br>
                <?php if (isset($ff['pages'])) { ?>
                    تعداد صفحات : <?php echo $ff['pages'] ?>
                    <br>
                    <b>هزینه پروژه = <?php echo number_format($pprice) ?> ریال</b>
                <?php } else { ?>
                    <br><div class="error">فایل نهایی پروژه هنوز توسط مجری ارسال نگردیده است.</div>
                <?php } ?>
            <?php } else { ?>
                <? if ($bid->type == Bid::$TYPE_PERPAGE) { ?>
                    هزینه پروژه = قیمت توافق شده x تعداد 
                    <?= $_ENUM2FA['bid_type'][$bid->type] ?>
                <? } elseif ($bid->type == Bid::$TYPE_FULL) { ?>
                    هزینه پروژه = قیمت توافق شده
                <? } ?>

                <br>
                <?php if (isset($ff['pages'])) { ?>
                    <b>هزینه پروژه = <?php echo number_format($pprice) ?> ریال</b>
                <?php } else { ?>
                    <br><div class="error">فایل نهایی پروژه هنوز توسط مجری ارسال نگردیده است.</div>
                <?php } ?>
            <?php } ?>

            <br>توجه نمایید که پس از قبول ، هزینه پروژه از اعتبار شما کسر خواهد گردید.
            <br>
            <span style="color:#F90">در صورتی که پس از مشاهده فایل نهایی مغایرتی با شرایط تعیین شده مشاهده نمودید در صفحه پروژه<a href="review-request_<?php echo $p['id'] ?>"> درخواست بازبینی نمایید</a>.</span>
            <div style="margin:20px; border:1px solid #CCC; padding:10px; text-align:center;">
                <?php if (isset($ff['pages'])) { ?>
                    <a onclick="mhkform.ajax('finish-project_<?php echo $p['id'] ?>_AP1?ajax=1','#ajax_content')" href="#"><img src="medias/images/icons/tick.png" align="absmiddle" /> قبول هزینه و پایان پروژه</a>
                <?php } else { ?>
                    <img src="medias/images/icons/tick.png" align="absmiddle" /> قبول هزینه و پایان پروژه
                <?php } ?>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="project_<?php echo $p['id'] ?>"  onclick="return !mhkform.close();"><img src="medias/images/icons/cross.png" align="absmiddle" /> انصراف</a>
            </div>

        </div>
    </div>
<?php } ?>

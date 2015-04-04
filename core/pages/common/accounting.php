<?php
if ($auth->validate('RequestCreditsForm', array())) {
    if ($user->requestCredits($_POST['pr'], isset($_POST['fd'])))
        $message->addMessage('درخواست شما با موفقیت ارسال گردید.');
}
?>
<div id="content-wrapper">
    <div id="content">
        <h1>درخواست واریز به حساب بانکی</h1>
        <hr/>
        <?php $message->display() ?>
        <br>

        <div style="padding:0 20px;">
            <b>میزان اعتبار:</b> <?php echo $user->getCredit(TRUE) ?> ریال
            <br>
            <b>اعتبار قفل شده:</b> <?php echo $user->locked_credits ?> ریال

            <br>
            <b>قابل برداشت:</b> <?php echo $user->getCredit() ?> ریال
            <br>
            <? if ($user->locked_credits > 0) { ?>
                <br/>
                <a href="report#lock" class="ajax active_btn">
                    مشاهده لیست گروگذاری های جاری
                </a>
                <br/>
            <? } ?>

            <hr><br>
            نکات:
            <ul>
                <li>
                    در حال حاضر با توجه به زمان تسویه درگاه پرداخت امن پاسارگاد، بازه زمانی واریز بین 4 الی 6 روز می باشد
                </li>
                <li>
تراکنش ها از طریق سامانه بین بانکی پایا پرداخت می شود
و حواله بین بانکی در مدت چند ساعت  ممکن است به طول بیانجامد
                </li>
                <? if ($user->isWorker()) { ?>
                    <li>
                        در صورت برداشت تمام موجودی حساب خود دیگر قادر به ارسال پیشنهاد برای پروژه ها نیستید
                        زیرا به منظور ارسال پیشنهاد برای هر پروژه به میزان مبلغ تخمین زده شده باید
                        گروگذاری نمایید
                    </li>
                <? } else { ?>
                    <li>
                        کاربران گرامی توجه داشته باشید که مبلغ تراکنش بین بانکی (۵۰۰۰ریال) از حساب شما کسر خواهد شد
                    </li>
                <? } ?>
                <li>
                    حتما قبل از درخواست،
                    اطلاعات بانکی شامل 
                    <span style="color: red">
                        نام بانک، شماره حساب، شماره کارت و شناسه شبا 
                    </span>
                    را تکمیل نمایید
                </li>
                <li>
                    اطلاعات حساب شما باید مطابق نام و نام خانوادگی ثبت شده باشد
                    در صورت مغایرت پرداخت انجام نخواهد شد
                    <span style="color: red">
                        (نام و نام خانوادگی خود را به فارسی ثبت نمایید)
                    </span>
                </li>
<!--                <li style="color: red">
                درخواست هایی که از تاریخ ۱۸ اسفند ۹۲ به بعد ثبت می شوند به دلیل زمان 
تسویه درگاه پرداخت امن پاسارگاد، درخواست بعد از تعطیلات نوروز پرداخت می گردند
                </li>-->
            </ul>
            <br>
            <? // if ($message->messages_count == 0) { ?>
            <form method="post" class="form"  action="accounting">
                <input type="hidden" name="formName" value="RequestCreditsForm" />
                <label>مبلغ مورد نظر (ریال)</label>
                <input required="required" class="numberfild" type="text" name="pr" />
                <label> </label>
                <? if (isset($_REQUEST['fd'])) { ?>
                    <input type="hidden" name="fd" value="1" />
                    <input type="submit" value="حذف درخواست قبلی و ثبت در خواست جدید" name="submit"  />
                <? } else { ?>
                    <input type="submit" value="درخواست پرداخت" name="submit"  />
                <? } ?>
            </form>
            <? // } ?>
        </div>
        <div class="clear"></div>
        <br><br><hr><br>
        اطلاعات شما:
        <ul>
            <li>
                <b> نام و نام خانوادگی : </b> 
                <?php echo $user->fullname ?>
            </li>
            <li>
                <b>بانک : </b>
                <?php echo $user->bank_name ?>
            </li>
            <li>
                <b>شماره حساب : </b> 
                <span class="english">
                    <?php echo $user->bank_account ?>
                </span>
            </li>
            <li>
                <b>شماره ۱۶ رقمی کارت : </b>
                <span class="english">
                    <?php echo $user->bank_card ?>
                </span>
            </li>
            <li>
                <b>شبا : </b>
                <span class="english">
                    IR:<?php echo $user->bank_shaba ?>
                </span>
            </li>
        </ul>
        <a class="active_btn" href="edit-profile?edit=bank"> 
            ویرایش اطلاعات
        </a>
    </div>
</div>

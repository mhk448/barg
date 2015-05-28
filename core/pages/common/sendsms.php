<?php
/*
 * In The Name of GOD
 * @author MHK448
 * Email: MHK448@gmail.com
 * Created at: Jul 26, 2013 , 11:32:15 AM
 * mhkInfo:
 */
$u = $pager->getComParamById('users');
if (isset($_POST['submit'])) {
    
    $personalmessage->SMSSend($user->id, $u['id'], $_POST['m']);
    $message->display();
} else {
    ?>
    <div id="content-wrapper">
        <div id="content">
            <script type="text/javascript">
                function checkCount(){
                    var msg =$("#sms_msg").val();
                    var sms_l=msg.length;
                    sms_l=sms_l+<?= mb_strlen($_CONFIGS['SMS_Postfix'],'UTF-8') ?>;
                    var sms_c=parseInt((sms_l/70)+1,10);
                    $("#sms_price").html(sms_c*<?=($_PRICES['SMS']+$_PRICES['P_SMS'])?>);
                }
            </script>

            <h1>  ارسال پیامک </h1>
            <?php $message->display() ?>
            <div style=" padding: 10px 20px; ">
                <b>نکات:‌</b>
                <ul class="disc">
                    <li>توجه نمایید که ارسال هرگونه شماره تماس، تلفن، آدرس، ایمیل و سایر راههای ارتباطی بر طبق قوانین این مرکز ممنوع بوده و با متخلفین به شدت برخورد خواهد شد.</li>
                    <li>مبلغ
                        <span id="sms_price" style="font-weight: bold;"><?=($_PRICES['SMS']+$_PRICES['P_SMS'])?></span>
                    ریال بابت ارسال پیام از اعتبار شما کم خواهد شد</li>
                </ul>
            </div>   


            <form method="post" class="form" <?= ' action="sendsms_' . $u['id'] . '" '; ?>>
                <label>به کاربر</label>
                <input type="text" value="<?php echo $u['username'] ?>" disabled="disabled" readonly="readonly" />
                <label>متن پیام</label>
                <textarea id="sms_msg" onkeyup="checkCount()" onchange="checkCount()" name="m" style="width:300px; height:120px;"></textarea>
                <label> </label>
                <input type="submit" value="ارسال پیام" name="submit" id="submit" />
            </form>
            <div class="clear"></div>
            
        </div>
        
    </div>
<? } ?>
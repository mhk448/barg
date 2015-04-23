<?php
$type = (isset($_REQUEST['type'])) ? trim($_REQUEST['type']) : '';
$bank_trans = (isset($_REQUEST['bank_trans'])) ? trim($_REQUEST['bank_trans']) : '';
$senderQuery = (isset($_REQUEST['sq'])) ? ( trim($_REQUEST['sq'])) : '';
$amount = (isset($_REQUEST['p']) && is_numeric($_REQUEST['p'])) ? (int) $_REQUEST['p'] : 0;
////////////////
if ($type == 'bank' && isset($_POST['submit'])) {
    $cdatabase->insert('payments', array(
        'user_id' => (int) $user->id,
        'payment_type' => 'Bank',
        'bank_name' => $_POST['bn'],
        'bank_pay_type' => $_POST['bpt'],
        'transaction_id' => $_POST['tid'],
        'price' => $_POST['p'],
        'resource_bank_code' => $_POST['r'],
        'pay_date' => $_POST['pd'],
        'verified' => 0,
        'redirect_path' => $senderQuery,
        'dateline' => time()
    ));
    $message->displayMessage('اطلاعات مربوط به پرداخت شما ثبت شد');
    $message->displayMessage('پس از بررسی صحت اطلاعات مبلغ پرداخت شده به حساب کاربریتان اضافه خواهد شد');
    if (($senderQuery)) {
        $message->runScripts('mhkform.redirect("' . $senderQuery . '")', 5);
    }
} else {
    ?>
    <div id="content-wrapper">
        <div id="content">
            <?php
            if (isset($_GET['error']) && $_GET['error'] == 'bank')
                echo '<div class="error">خطایی در سامانه پرداخت امن رخ داده است. لطفا از صحت مشخصات خود مطمئن شوید.</div>';

            $message->display();
            if ($type == 'online') {
                finalRewive($bank_trans, $amount, $senderQuery);
            } elseif ($type == 'bank') {
                phisycalPay($senderQuery);
            } else {
                selectPayMethod($senderQuery);
            }
            ?>
        </div>
    </div>

<? } ?>

<?

function phisycalPay($senderQuery) {
    global $cdatabase, $user;
    $payed = $cdatabase->selectCount("payments", $cdatabase->whereId($user->id, 'user_id') . " AND verified=0 AND payment_type<>'Online' ");
    if ($payed) {
        ?>
        <h1>پرداخت از طریق بانک</h1>
        <div style="padding:4px;">
            اطلاعات پرداخت قبلی شما ثبت شده 
            و در حال بررسی می باشد
            <br/>
            <br/>
            لطفا منتظر بمانید
            <br/>
            <br/>
            <a onclick="mhkform.close()" class="active_btn">تایید</a>

        </div>
        <?
        return FALSE;
    }
    ?>
    <h1>پرداخت از طریق بانک</h1>
    <? if (!isset($_REQUEST['reg'])) { ?>
        <div style="padding:40px 0; width: 400px; ">
            <h3 style="font-size:16px">شماره حسابها و شماره کارتها:</h3>
            <br>
            <div style="padding:0px 20px; font-size:17px;">
                <!--<img src="medias/images/banks/bank_melli.png" style="float:right;margin-left:10px;"/>-->
                <b>بانک پاسارگاد</b>
                <br>
                کارت:
                <span dir="ltr">5022-2910-1822-6785</span>
                <br>
                <br><br>
                <div class="clear"></div>
                <!--<img src="medias/images/banks/bank_saderat.png" style="float:right;margin-left:10px;"/>-->
                <b>بانک ملی ایران</b>
                <br>
                کارت:
                <span dir="ltr">6037-9918-4203-3064</span>
                <br><br>
            </div>
            <div style="padding: 10px 20px;" >

                <a href<?= '="add-credit?type=bank&reg=0&sq=' . $senderQuery . '&p=' . $_REQUEST['p'] . '"'; ?> class="popup active_btn">
                    ثبت فیش واریزی
                </a>
            </div>
        </div>
    <? } else { ?>
        <div style="padding:40px;">
            <form class="form" method="post" action="add-credit">
                <input type="hidden" name="formName" value="BankForm" />
                <input type="hidden" name="type" value="bank" />
                <input type="hidden" name="sq" value="<?= $senderQuery ?>">
                <label>نام بانک</label>
                <select name="bn">
                    <option value="ملی">ملی</option>
                    <!--<option value="صادرات">صادرات</option>-->
                    <!--<option value="تجارت">تجارت</option>-->
                    <option value="پاسارگاد">پاسارگاد</option>
                </select>
                <label>نوع پرداخت</label>
                <select name="bpt">
                    <option value="Card">
                        کارت به کارت 
                    </option>
                    <option value="Account">
                        واریز به حساب 
                    </option>
                </select>

                <label>شماره فیش</label>
                <input type="text" name="tid" class="english"/>
                <label>مبلغ (ریال)</label>
                <input type="text" name="p" class="numberfild" value="<?= $_REQUEST['p']; ?>"/>
                <label>کد مبداء</label>
                <input type="text" name="r"  class="english"/>
                <label>تاریخ</label>
                <?= jCalendarFild('pd', ' id="time_select"   required="required"  placeholder="' . 'تاریخ شمسی' . '" '); ?>
                <label> </label>
                <input type="submit" value="ثبت اطلاعات" name="submit"  />
            </form>
        </div>
    <? } ?>
    <div class="clear"> </div>
<? } ?>

<?

function selectPayMethod($senderQuery) {
    global $user;
    $addPrice = isset($_REQUEST['p']) ?
            $_REQUEST['p'] : (!isset($_REQUEST['need_p']) ?
                    "" : ($_REQUEST['need_p'] - $user->getCredit()));
    ?>
    <br/>
    <h1>افزودن به اعتبار</h1>
    <hr/>
    <br/>
    <br/>
    <? if (isset($_REQUEST['need_p'])) { ?>
        <br/>
        اعتبار شما کافی نیست
        <br/>
        اعتبار فعلی شما 
        <?= $user->getCredit() ?>
        ریال می باشد و باید حداقل 
        <?= $_REQUEST['need_p'] - $user->getCredit() ?>
        ریال دیگر بپردازید
        <br/>
    <? } ?>

    <div style="min-width: 800px">

        مبلغ مورد نیاز جهت افزایش:
        <input type="text" class="numberfild"  id="p"  value="<?= $addPrice; ?>"/>
        ریال
        <input type="hidden" id="sq" value="<?= $senderQuery ?>" />
        <input type="hidden" id="type" value="online">
        <br/>
        <br/>
        <br/>
        لطفا روش پرداخت  خود را مشخص نمایید:
        <br/>
        <br/>
        <br/>
        <div class="cf" id="banks" >
            <ul id="banks-list">
                <!--                <li data-bankid="9" class="Melli">
                                    <div class="default-bg" style="overflow: hidden;"></div>
                                    <div class="on-hover">
                                        <div class="inner fill_with_text" style="font-size: 37px;">
                                            ملی
                                        </div>
                                    </div>
                                </li>-->
                <!--                <li data-bankid="10" class="Saderat">
                                    <div class="default-bg" style="overflow: hidden;"></div>
                                    <div class="on-hover">
                                        <div class="inner fill_with_text" style="font-size: 17px;">
                                            صادرات
                                        </div>
                                    </div>
                                </li>
                                <li data-bankid="5" class="Parsian">
                                    <div class="default-bg" style="overflow: hidden;"></div>
                                    <div class="on-hover">
                                        <div class="inner fill_with_text" style="font-size: 17px;">
                                            پارسیان
                                        </div>
                                    </div>
                                </li>
                                <li data-bankid="2" class="Mellat">
                                    <div class="default-bg" style="overflow: hidden;"></div>
                                    <div class="on-hover">
                                        <div class="inner fill_with_text" style="font-size: 33px;">
                                            ملت
                                        </div>
                                    </div>
                                </li>
                                <li data-bankid="0" class="Saman">
                                    <div class="default-bg" style="overflow: hidden;"></div>
                                    <div class="on-hover">
                                        <div class="inner fill_with_text" style="font-size: 23px;">
                                            سامان
                                        </div>
                                    </div>
                                </li>
                                <li data-bankid="12" class="Tejarat">
                                    <div class="default-bg" style="overflow: hidden;"></div>
                                    <div class="on-hover">
                                        <div class="inner fill_with_text" style="font-size: 22px;">
                                            تجارت
                                        </div>
                                    </div>
                                </li>
                                <li data-bankid="15" class="Refah">
                                    <div class="default-bg" style="overflow: hidden;"></div>
                                    <div class="on-hover">
                                        <div class="inner fill_with_text" style="font-size: 34px;">
                                            رفاه
                                        </div>
                                    </div>
                                </li>
                                <li data-bankid="16" class="Sepah">
                                    <div class="default-bg" style="overflow: hidden;"></div>
                                    <div class="on-hover">
                                        <div class="inner fill_with_text" style="font-size: 32px;">
                                            سپه
                                        </div>
                                    </div>
                                </li>
                                <li data-bankid="20" class="Maskan">
                                    <div class="default-bg" style="overflow: hidden;"></div>
                                    <div class="on-hover">
                                        <div class="inner fill_with_text" style="font-size: 22px;">
                                            مسکن
                                        </div>
                                    </div>
                                </li>
                                <li data-bankid="1" class="EghtesadeNovin">
                                    <div class="default-bg" style="overflow: hidden;"></div>
                                    <div class="on-hover">
                                        <div class="inner fill_with_text" style="font-size: 19px;">
                                            اقتصاد نوین
                                        </div>
                                    </div>
                                </li>
                                <li data-bankid="3" class="Keshavarzi">
                                    <div class="default-bg" style="overflow: hidden;"></div>
                                    <div class="on-hover">
                                        <div class="inner fill_with_text" style="font-size: 16px;">
                                            کشاورزی
                                        </div>
                                    </div>
                                </li>-->
                <!--                <li data-bankid="8" class="Pasargad">
                                    <div class="default-bg" style="overflow: hidden;"></div>
                                    <div class="on-hover">
                                        <div class="inner fill_with_text" style="font-size: 16px;">
                                            پاسارگاد
                                        </div>
                                    </div>
                                </li>-->
                <!--                <li data-bankid="13" class="ToseyeTavon">
                                    <div class="default-bg" style="overflow: hidden;"></div>
                                    <div class="on-hover">
                                        <div class="inner fill_with_text" style="font-size: 21px;">
                                            توسعه تعاون
                                        </div>
                                    </div>
                                </li>
                                <li data-bankid="14" class="Ansar">
                                    <div class="default-bg" style="overflow: hidden;"></div>
                                    <div class="on-hover">
                                        <div class="inner fill_with_text" style="font-size: 26px;">
                                            انصار
                                        </div>
                                    </div>
                                </li>
                                <li data-bankid="11" class="PostBank">
                                    <div class="default-bg" style="overflow: hidden;"></div>
                                    <div class="on-hover">
                                        <div class="inner fill_with_text" style="font-size: 22px;">
                                            پست بانک
                                        </div>
                                    </div>
                                </li>
                                <li data-bankid="4" class="Sina">
                                    <div class="default-bg" style="overflow: hidden;"></div>
                                    <div class="on-hover">
                                        <div class="inner fill_with_text" style="font-size: 31px;">
                                            سینا
                                        </div>
                                    </div>
                                </li>
                                <li data-bankid="17" class="Sarmayeh">
                                    <div class="default-bg" style="overflow: hidden;"></div>
                                    <div class="on-hover">
                                        <div class="inner fill_with_text" style="font-size: 19px;">
                                            سرمایه
                                        </div>
                                    </div>
                                </li>
                                <li data-bankid="18" class="Tat">
                                    <div class="default-bg" style="overflow: hidden;"></div>
                                    <div class="on-hover">
                                        <div class="inner fill_with_text" style="font-size: 37px;">
                                            تات
                                        </div>
                                    </div>
                                </li>
                                <li data-bankid="19" class="KarAfarin">
                                    <div class="default-bg" style="overflow: hidden;"></div>
                                    <div class="on-hover">
                                        <div class="inner fill_with_text" style="font-size: 22px;">
                                            کار آفرین
                                        </div>
                                    </div>
                                </li>
                                <li data-bankid="21" class="Mehr">
                                    <div class="default-bg" style="overflow: hidden;"></div>
                                    <div class="on-hover">
                                        <div class="inner fill_with_text" style="font-size: 37px;">
                                            مهر
                                        </div>
                                    </div>
                                </li>-->
                <!--                <li data-bankid="22" class="Dey ">
                                    <div class="default-bg" style="overflow: hidden;"></div>
                                    <div class="on-hover">
                                        <div class="inner fill_with_text" style="font-size: 37px;">
                                            دی
                                        </div>
                                    </div>
                                </li>
                                <li data-bankid="23" class="Shahr">
                                    <div class="default-bg" style="overflow: hidden;"></div>
                                    <div class="on-hover">
                                        <div class="inner fill_with_text" style="font-size: 33px;">
                                            شهر
                                        </div>
                                    </div>
                                </li>
                                <li data-bankid="6" class="ToseyeSaderat">
                                    <div class="default-bg" style="overflow: hidden;"></div>
                                    <div class="on-hover">
                                        <div class="inner fill_with_text" style="font-size: 17px;">
                                            توسعه صادرات
                                        </div>
                                    </div>
                               </li>--> 
                <!--                <li data-bankid="7" class="SanatoMadan">
                                    <div class="default-bg" style="overflow: hidden;"></div>
                                    <div class="on-hover">
                                        <div class="inner fill_with_text" style="font-size: 18px;">
                                            صنعت و معدن
                                        </div>
                                    </div>
                                </li>-->
                <!--                <li data-bankid="7" class="ParsPal">
                                    <div class="default-bg" style="overflow: hidden;"></div>
                                    <div class="on-hover">
                                        <div class="inner fill_with_text" style="font-size: 18px;">
                پارس پال
                                        </div>
                                    </div>
                                </li>-->
            </ul>
            <input type="hidden" id="selectedBankId" name="selectedBankId" value="1">
            <div class="clear"></div>
        </div>
<!--        <div data-bankid="17" class="active_btn fill_with_text" style="font-size: 14px;padding: 5px 10px;width: 300px;">
            پرداخت از طریق درگاه بانک پاسارگاد
        </div>-->
        <br/>
        <div data-bankid="18" class="active_btn fill_with_text" style="font-size: 14px;padding: 5px 10px;width: 300px;">
            پرداخت از طریق درگاه پارس پال
        </div>


        <script type="text/javascript">
            $('.fill_with_text').click(function(){
                if($('#p').val()<500){
                    mhkform.info('مبلغ را وارد نمایید');
                    return;
                }
                //                id=$(this).parent().parent().attr('data-bankid');
                id=$(this).data('bankid');
                if(id=='7')
                    bank_trans='tejarat';
                else if(id=='18')
                    bank_trans='parspal';
                else
                    bank_trans='pasargad';
                url='&p='+$('#p').val()+'&sq='+$('#sq').val()+'&type='+$('#type').val()+'&bank_trans='+bank_trans;
                mhkform.ajax('add-credit?ajax=1'+url);
            });
        </script>


        <br/>

<!--        <a href<?= '="add-credit?type=bank&sq=' . $senderQuery . '&p=' . $addPrice . '"'; ?> class="popup" >
            <div  class="popup active_btn" style="font-size: 14px;padding: 5px 10px;width: 300px;">
                پرداخت از طریق شماره حساب و ثبت فیش واریزی
            </div>
        </a>-->
    </div>

<?php }
?>






<?

function finalRewive($bank_trans, $amount, $senderQuery) {
    global $user, $cdatabase, $persiandate, $_CONFIGS, $subSite;
    if ($amount > 0 && $bank_trans == "pasargad") {
        $cdatabase->insert('payments', array(
            'user_id' => (int) $user->id,
            'payment_type' => 'Online',
            'bank_name' => 'پاسارگاد',
            'price' => $amount,
            'verified' => -1,
            'redirect_path' => $senderQuery,
            'dateline' => time()
        ));
        $in = $cdatabase->getInsertedId();
        require_once 'pasargad.php';
        // You can send product data first.
        $cart_data = array(
            'buyer_name' => $user->fullname,
            'buyer_tel' => $user->phone,
            'total_amount' => $amount,
            'delivery_days' => 1,
            'delivery_address' => "",
            'invoice_date' => $persiandate->date('Y/m/d'),
            'invoice_number' => $in,
            'cart' => array(
                array(
                    'content' => 'افزایش اعتبار',
                    'fee' => $amount,
                    'count' => 1,
                    'description' => 'افزایش اعتبار در ' . ' ' . $_CONFIGS['Site']['Sub']['NickName']
                )
            )
        );
        // And make a full cart
        $cart = new PasargadCart($cart_data, "&sq=" . $senderQuery);
        // Get Pasaragad class
        $pasargad = new Pasargad();
        // Generate XML
        $xml = $pasargad->createXML($cart);
        // Get sing
        $sign = $pasargad->sign($xml);
    } elseif ($amount > 0 && $bank_trans == "parspal") {
        $cdatabase->insert('payments', array(
            'user_id' => (int) $user->id,
            'payment_type' => 'Online',
            'bank_name' => 'پارس پال',
            'price' => $amount,
            'verified' => -1,
            'redirect_path' => $senderQuery,
            'dateline' => time()
        ));
        $in = $cdatabase->getInsertedId();


        $MerchantID['type'] = '18986032';
        $MerchantID['translate'] = '18986042';
        $Password['type'] = 'y7KaM02RE2';
        $Password['translate'] = 'XGhYFD9Yz2';


        $Price = $amount / 10; //Price By Toman

        $ReturnPath = $_CONFIGS['Site']['Sub']['Path'] . 'index.php?request=response&bank=parspal&sq=' . $senderQuery;

        $ResNumber = $in; // Order Id In Your System 
        $Description = 'افزایش اعتبار در ' . ' ' . $_CONFIGS['Site']['Sub']['NickName'];
        $Paymenter = $user->fullname;
        $Email = $user->email;
        $Mobile = $user->phone;

        $client = new SoapClient('http://merchant.parspal.com/WebService.asmx?wsdl');

        $res = $client->RequestPayment(array("MerchantID" => $MerchantID[$subSite], "Password" => $Password[$subSite], "Price" => $Price, "ReturnPath" => $ReturnPath, "ResNumber" => $ResNumber, "Description" => $Description, "Paymenter" => $Paymenter, "Email" => $Email, "Mobile" => $Mobile));

        $PayPath = $res->RequestPaymentResult->PaymentPath;
        $Status = $res->RequestPaymentResult->ResultStatus;

        if ($Status == 'Succeed') {
            echo " <script type='text/javascript'>mhkform.redirect('" . $PayPath . "', false)</script><div>درحال اتصال به درگاه پرداخت پارس پال ...</div>";
        } else {
            echo $Status;
        }
    } elseif ($amount > 0 && $bank_trans == "tejarat") {



        $cdatabase->insert('payments', array(
            'user_id' => (int) $user->id,
            'payment_type' => 'Online',
            'bank_name' => 'تجارت',
            'price' => $amount,
            'verified' => -1,
            'redirect_path' => $senderQuery,
            'dateline' => time()
        ));
        $in = $cdatabase->getInsertedId();
    }









    if ($bank_trans == "pasargad") {
        ?>
        <h1>پرداخت آنلاین</h1>
        <img src="medias/images/banks/bank_pasargad.png" style="float:right;margin-left:10px;"/> 
        <ul>
            <li>
                پرداخت از طریق درگاه اینترنتی بانک پاسارگاد صورت می گیرد
            </li>
            <li>
                مبلغ مورد نظر جهت افزایش 
                <?= $amount ?>
                ریال است
            </li>
        </ul>
        <div style="padding:20px">
            <form class="form" action="https://paypaad.bankpasargad.com/PaymentController" method="POST">
                <input type="hidden" name="content" value='<?php echo $xml ?>' />
                <input type="hidden" name="sign" value="<?php echo $sign ?>" />
                <input type="hidden" name="formName" value="BankForm" />
                <input  style="float: none" type="submit" value="ورود به درگاه بانک پاسارگاد" name="submit" />
            </form>
            <div style="clear:both"> </div>
        </div>
    <?php } elseif ($bank_trans == "tejarat") { ?>

        <h1>پرداخت آنلاین</h1>
        <img src="medias/images/banks/bank_tejarat.png" style="float:right;margin-left:10px;"/>
        <ul>
            <li>
                پرداخت از طریق درگاه اینترنتی بانک تجارت صورت می گیرد
            </li>
            <li>
                مبلغ مورد نظر جهت افزایش 
                <?php echo $amount ?>
                ریال است
            </li>
            <li>
                شماره ی فاکتور شما: 
                <? $factId = '50' . $in; ?>
                <?= $factId ?>
            </li>
        </ul>
        <div style="padding:20px">
            <form class="form" action="http://tmerchant.tejaratbank.net:9085/paymentGateway/page" method="POST">
                <input type="hidden" name="merchantId" value="F047" />
                <input type="hidden" name="paymentId" value="<?= $factId ?>" />
                <input type="hidden" name="customerId" value="<?= $user->username ?>" />
                <input type="hidden" name="revertURL" value="<?= $_CONFIGS['Site']['Sub']['Path'] ?>index.php?request=response&bank=tejarat<?= $senderQuery; ?>" />
                <input type="hidden" name="amount" value="<?= preg_replace("/[^0-9]/", "", $amount) ?>" />
                <input style="float: none" type="submit" value="ورود به درگاه بانک تجارت" name="submit"  />
            </form>
            <div style="clear:both"> </div>
        </div>
    <? } ?>
<? } ?>
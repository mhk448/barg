<?php

if (isset($_GET['bank']) && $_GET['bank'] == 'parspal') {

    if (isset($_POST['status']) && $_POST['status'] == 100) {
        $MerchantID = '1898603';
        $Password = 'y7KaM02RE';

        $Refnumber = $_POST['refnumber'];
        $Resnumber = $_POST['resnumber']; // typeiran id

        $Price = $cdatabase->selectField("payments", 'price', $cdatabase->whereId($Resnumber));
        $Price = intval($Price) / 10;

        $Status = $_POST['status'];

        $client = new SoapClient('http://merchant.parspal.com/WebService.asmx?wsdl');

        $res = $client->VerifyPayment(array("MerchantID" => $MerchantID, "Password" => $Password, "Price" => $Price, "RefNum" => $Refnumber));

        $Status = $res->verifyPaymentResult->ResultStatus;
        $PayPrice = $res->verifyPaymentResult->PayementedPrice;
        if ($Status == 'success') {// Your Peyment Code Only This Event
            $creditlog->bank_addPayments($Resnumber, $Refnumber, time());
            $message->addMessage('پرداخت با موفقیت انجام شد ، شماره رسید پرداخت : ' .$Refnumber . ' ،  مبلغ پرداختی : ' .$Price*10 . 'ریال');
        } else {
            $message->addError('خطا در پردازش عملیات پرداخت ، نتیجه پرداخت : ' . $Status );
        }
    } else {
        $message->addError('بازگشت از عملیات پرداخت، خطا در انجام عملیات پرداخت ( پرداخت ناموفق )');
    };

    if (isset($_GET['sq']) && $_GET['sq']) {
        header('Location: ' . $_GET['sq']);
        exit;
    } else {
        $message->display();
    }
}



    
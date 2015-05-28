<?php

if (isset($_GET['bank']) && $_GET['bank'] == 'tejarat') {
    require_once 'verify.php';
} else if (isset($_GET['bank']) && $_GET['bank'] == 'parspal') {
    require_once 'response-parspal.php';
} else {

    require_once 'pasargad.php';

//Get POST data
    $i_date = $_REQUEST['iD'];
    $i_number = $_REQUEST['iN'];
    $tref = $_REQUEST['tref'];

//Make a cart object
    $cart_data = array(
        'invoice_date' => $i_date,
        'invoice_number' => $i_number
    );
    $cart = new PasargadCart($cart_data);

//Get Pasargad class
    $pasargad = new Pasargad();

//Send data to Pasargad system and get response
    $response = $pasargad->getResponse($tref);
    if ($response->result == 'true' && $response->invoice_number==$i_number ) {
        $creditlog->bank_addPayments($i_number, $tref, $i_date);
    } else {
        // Something is wrong
        $message->addError('<div class="error">&#1582;&#1591;&#1575;&#1740;&#1740; &#1583;&#1585; &#1587;&#1575;&#1605;&#1575;&#1606;&#1607; &#1662;&#1585;&#1583;&#1575;&#1582;&#1578; &#1575;&#1605;&#1606; &#1585;&#1582; &#1583;&#1575;&#1583;&#1607; &#1575;&#1587;&#1578;. &#1604;&#1591;&#1601;&#1575; &#1575;&#1586; &#1589;&#1581;&#1578; &#1605;&#1588;&#1582;&#1589;&#1575;&#1578; &#1582;&#1608;&#1583; &#1605;&#1591;&#1605;&#1574;&#1606; &#1588;&#1608;&#1740;&#1583;.</div>');
    }
//    $message->display();

    if (isset($_GET['sq'])) {
        header('Location: ' . $_GET['sq']);
        exit;
    }
}
// End of file: response.php
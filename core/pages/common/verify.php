<?php
include_once 'lib/nusoap.php';

$ns = 'http://tejarat/paymentGateway/definitions';
$wsdl = "http://tmerchant.tejaratbank.net:9086/paymentGateway/services/merchant.wsdl";
//$wsdl ="http://pg.tejaratbank.net/paymentGateway/services/merchant.wsdl";
if (isset($_POST['resultCode'])) {

    $resultCode = $_POST['resultCode'];
    $referenceId = isset($_POST['referenceId']) ? $_POST['referenceId'] : 0;
    $paymentID = isset($_SESSION["PaymentID"]) ? $_SESSION['PaymentID'] : 0;

    if (($resultCode == 100)) {
        try {
            $client = new nusoap_client($wsdl, true);

            $err = $client->getError();
            if ($err) {
                echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
                echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
            }

            $params = array(
                'merchantId' => 'F047',
                'referenceNumber' => $referenceId
            );

            Report::addLog($_REQUEST);
            $client->setUseCurl(0);
            $client->soap_defencoding = 'UTF-8';
            $client->decode_utf8 = true;

            $client->setEndpoint($wsdl);
            $result = $client->call('verifyRequest', $params, $ns);

            if ($client->fault) {
                echo '<h2>Fault (Expect - The request contains an invalid SOAP body)</h2><pre>';
                print_r($result);
                echo '</pre>';
            } else {
                $err = $client->getError();
                if ($err) {
                    echo '<h2>Error</h2><pre>' . $err . '</pre>';
                } else {
                    echo '<h2>Result</h2><pre>';
                    print_r($result);
                    echo '</pre>';
                }
            }
            echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
            echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
            echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
        } catch (Exception $ex) {

            echo '<h2>Error</h2><pre>' . $ex->getMessage() . '</pre>';
        }
    } else {
        echo '<div class="error">&#1582;&#1591;&#1575;&#1740;&#1740; &#1583;&#1585; &#1587;&#1575;&#1605;&#1575;&#1606;&#1607; &#1662;&#1585;&#1583;&#1575;&#1582;&#1578; &#1575;&#1605;&#1606; &#1585;&#1582; &#1583;&#1575;&#1583;&#1607; &#1575;&#1587;&#1578;. &#1604;&#1591;&#1601;&#1575; &#1575;&#1586; &#1589;&#1581;&#1578; &#1605;&#1588;&#1582;&#1589;&#1575;&#1578; &#1582;&#1608;&#1583; &#1605;&#1591;&#1605;&#1574;&#1606; &#1588;&#1608;&#1740;&#1583;.
	<br />' . print_r($_POST, ture) . '
	</div>';
    }
} else {
    echo '<div class="error">&#1582;&#1591;&#1575;&#1740;&#1740; &#1583;&#1585; &#1587;&#1575;&#1605;&#1575;&#1606;&#1607; &#1662;&#1585;&#1583;&#1575;&#1582;&#1578; &#1575;&#1605;&#1606; &#1585;&#1582; &#1583;&#1575;&#1583;&#1607; &#1575;&#1587;&#1578;. &#1604;&#1591;&#1601;&#1575; &#1575;&#1586; &#1589;&#1581;&#1578; &#1605;&#1588;&#1582;&#1589;&#1575;&#1578; &#1582;&#1608;&#1583; &#1605;&#1591;&#1605;&#1574;&#1606; &#1588;&#1608;&#1740;&#1583;.</div>';
}
?>


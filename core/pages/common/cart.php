<?php
if(isset($_GET['error']) && $_GET['error']=='bank'){
	echo "خطایی در سامانه پرداخت امن رخ داده است. لطفا از صحت مشخصات خود مطمئن شوید.<br />";
}

require_once 'pasargad.php';

// Set cart data
$cart_data = array(
	'buyer_name' => 'علی مرادی',
	'buyer_tel' => '09350000000',
	'total_amount' => 200,
	'delivery_days' =>18,
	'delivery_address' =>"تهران، خیابان آزادی...",
	'invoice_date'=>'1389/08/06',
	'invoice_number'=>'20101028185615120'
);

// Make a new PasargadCart object with the given data
$cart = new PasargadCart($cart_data);

// You can change any value like this
$cart->invoice_date = '1389/08/07';

// You can send product data first.
$cart_data = array(
   'buyer_name' => 'علی مرادی',
   'buyer_tel' => '09350000000',
   'total_amount' => 200,
   'delivery_days' =>18,
   'delivery_address' =>"تهران، خیابان آزادی...",
   'invoice_date'=>'1389/08/07',
   'invoice_number'=>'20101028185615120',
   'cart'=>array(
       array(
           'content'=>'PHP Handbook',
           'fee'=>30000,
           'count'=>1,
           'description'=>'This is good book.'
           )
       ,
       array(
           'content'=>'MySQL Handbook',
           'fee'=>25000,
           'count'=>2,
           'description'=>'This is a good book too.'
       )
   )
);
// And make a full cart
$cart = new PasargadCart($cart_data);

// Or you can set products data like this
$cart_items = array(
		array(
           'content'=>'PHP Handbook',
           'fee'=>30000,
           'count'=>1,
           'description'=>'This is good book.'
           )
       ,
       array(
           'content'=>'MySQL Handbook',
           'fee'=>25000,
           'count'=>2,
           'description'=>'This is a good book too.'
       )
);

// And send it to the PasargadCart object after making the object
$cart->cart = $cart->makeProductItems($cart_items);

// Get Pasaragad class
$pasargad = new Pasargad();
// Generate XML
$xml = $pasargad->createXML($cart);
// Get sing
$sign = $pasargad->sign($xml);
?>

<!-- Sending data to Pasargad system -->
<form action="https://paypaad.bankpasargad.com/PaymentController" method="POST">
	<input type="hidden" name="content" value='<?php echo $xml ?>' />
	<input type="hidden" name="sign" value="<?php echo $sign ?>" />
	<input type="submit" value="ارسال" name="submit" />
</form>


<?php
//End of file: cart.php
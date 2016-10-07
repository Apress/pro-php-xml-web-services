<?php
require_once 'Services/AmazonECS4.php';

/* Your Amazon access key */
$accesskey = '<insert your Access Key ID>';

/* Create the object without an associate ID */
$amazon = new Services_AmazonECS4($accesskey);

/* Create a new cart, adding one item */
$items = array(array('ASIN'=>'1590596331', 'Quantity'=>1));
$result = $amazon->CartCreate($items);

/* Retrieve the CartId and HMAC from the results */
$cartid = $result["CartId"];
$hmac = $result["HMAC"];

/* Find the CartItemId for the item just added to the cart */
$cart_item_id = NULL;
foreach ($result['CartItems'] AS $key=>$value) {
   var_dump($key);
   if ($key == 'CartItem' && $value['ASIN'] == '1590596331') {
      $cart_item_id = $value['CartItemId'];
   }
}

/* If CartItemId is found, then modify the quantity to 6 */
if (! is_null($cart_item_id)) {
   $items = array(array('CartItemId'=>$cart_item_id, 'Quantity'=>6));
   $result = $amazon->CartModify($cartid, $hmac, $items);
}

var_dump($result);

$purchase_url = $result['PurchaseURL'];

/* Send user to this URL to make purchase */
print $purchase_url;
?>

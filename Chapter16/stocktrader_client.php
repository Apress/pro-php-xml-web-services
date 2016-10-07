<?php
/* An array to hold data returned from server */
$arMessage = array();

/* The userid is obtained through some other mechanism */
$userid = 1;

/* Common function to make XML-RPC requests */
function make_request($request_xml, &$arMessage, $stockSymbol,
                      $stockQuantity, $transtype) {
   $retval = call_using_sockets('localhost', 80, '/stocktrader.php', $request_xml);

   $data = xmlrpc_decode($retval);

   if (is_array($data) && xmlrpc_is_fault($data))
   {
      $arMessage[] = "Unable to $transtype $stockQuantity shares of $stockSymbol";
      $arMessage[] = "Error Code: ".$data['faultCode'];
      $arMessage[] = "Error Message: ".$data['faultString'];
   } else {
      $arMessage[] = $data;
   }
}

/* Stock symbol, quantity, and type of transaction (buy/sell) are obtained 
   through some mechanism such as an HTML form */

/* Purchase 100 shares of Yahoo */
$stockSymbol = "YHOO";
$stockQuantity = 100;

$request_xml = xmlrpc_encode_request('stockPurchase', array($userid, $stockSymbol,
                                                            $stockQuantity));
make_request($request_xml, $arMessage, $stockSymbol, $stockQuantity, 'Purchase');

/* Add an blank to the message array to add extra line feed during output */
$arMessage[] = "";

/* Sell 50 shares of Google */
$stockSymbol = "GOOG";
$stockQuantity = 50;
$request_xml = xmlrpc_encode_request('stockSale', array($userid, $stockSymbol,
                                                        $stockQuantity));

make_request($request_xml, $arMessage, $stockSymbol, $stockQuantity, 'Sell');

/* Add an blank to the message array to add extra line feed during output */
$arMessage[] = "";

/* Buy 10 shares of Microsoft */
$stockSymbol = "MSFT";
$stockQuantity = 50;
$request_xml = xmlrpc_encode_request('stockPurchase', array($userid, $stockSymbol,
                                                            $stockQuantity));

make_request($request_xml, $arMessage, $stockSymbol, $stockQuantity, 'Purchase');

/* Output the messages received from the server */
foreach ($arMessage AS $message) {
   print $message."\n";
}
?>

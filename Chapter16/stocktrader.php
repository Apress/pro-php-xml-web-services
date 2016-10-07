<?php
/* Stocks available to be traded */
$arStocks = array('YHOO'=>'Yahoo!', 'GOOG'=>'Google');

/* Function that performs the actual stock purchase */
function buy_stock($method_name, $args, $app_data) {
   if (! is_array($args) || count($args) <> 3) {
      return array('faultCode'=>-2,
                   'faultString'=>'Invalid Number of Parameters');
   }
   $userid = $args[0];
   $symbol = $args[1];
   $quantity = $args[2];
   if (array_key_exists($symbol, $GLOBALS['arStocks'])) {
      return "Bought $quantity shares of ".$GLOBALS['arStocks'][$symbol];
   } else {
      return array('faultCode'=>-1, 
                   'faultString'=>"Stock Symbol $symbol cannot be traded");
   }
}

/* Function that performs stock sale */
function sell_stock($method_name, $args, $app_data) {
   if (! is_array($args) || count($args) <> 3) {
      return array('faultCode'=>-2,
                   'faultString'=>'Invalid Number of Parameters');
   }
   $userid = $args[0];
   $symbol = $args[1];
   $quantity = $args[2];
   if (array_key_exists($symbol, $GLOBALS['arStocks'])) {
      return "Sold $quantity shares of ".$GLOBALS['arStocks'][$symbol];
   } else {
      return array('faultCode'=>-1, 
                   'faultString'=>"Stock Symbol $symbol cannot be traded");
   }
}

$request_xml = file_get_contents("php://input");

/* Create XML-RPC server, and register the functions */
$xmlrpc_server = xmlrpc_server_create();
xmlrpc_server_register_method($xmlrpc_server, "stockPurchase", "buy_stock");
xmlrpc_server_register_method($xmlrpc_server, "stockSale", "sell_stock");

/* Set content type to text/xml */
header('Content-Type: text/xml');

/* Process the XML-RPC request */
print xmlrpc_server_call_method($xmlrpc_server, $request_xml, array());
?>

<?php
require_once 'XML/RPC.php';

$userid = 1;
$stockSymbol = "YHOO";
$stockQuantity = 100;

$params = array(new XML_RPC_Value($userid, 'int'), 
                new XML_RPC_Value($stockSymbol, 'string'), 
                new XML_RPC_Value($stockQuantity, 'int'));
$msg = new XML_RPC_Message('stockPurchase', $params);

$objStock = new XML_RPC_Client('/stocktrader.php', 'localhost');

$retVal = $objStock->send($msg);

if (!$retVal) {
    echo 'Error: ' . $objStock->errstr;
} else {
   if (!$retVal->faultCode()) {
      $xmlrpcValue = $retVal->value();
      echo $xmlrpcValue->scalarval()."\n";
   } else {
      echo "Unable to Purchase $stockQuantity shares of $stockSymbol";
      echo "Error Code: ".$retVal->faultCode()."\n";
      echo "Error Message: ".$retVal->faultString()."\n";
   }
}
?>


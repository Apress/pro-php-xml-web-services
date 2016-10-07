<?php
class NumberToDollars {
   public $dNum;
}

$wsdl = 'http://www.dataaccess.com/webservicesserver/conversions.wso?WSDL';

try {
   $xConverter = new SoapClient($wsdl);

   $param = new NumberToDollars();
   $param->dNum = 123456;

   $retVal = $xConverter->NumberToDollars($param);
   
   print $retVal->NumberToDollarsResult."\n";
} catch (SoapFault $e) {
   var_dump($e);
}
?>

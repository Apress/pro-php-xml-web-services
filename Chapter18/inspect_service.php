<?php
/* Set the location of the WSDL document */
$wsdl = 'http://www.dataaccess.com/webservicesserver/conversions.wso?WSDL';

try {
   $xConverter = new SoapClient($wsdl);
   echo "Types:\n";
   if ($xTypes = $xConverter->__getTypes()) {
      foreach ($xTypes AS $type) {
         echo $type."\n\n";
      }
   }

   echo "Functions:\n";
   if ($xTypes = $xConverter->__getFunctions()) {
      foreach ($xTypes AS $type) {
         echo $type."\n\n";
      }
   }

} catch (SoapFault $e) {
   var_dump($e);
}
?>


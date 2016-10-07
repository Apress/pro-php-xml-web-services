<?php
try {
   $sClient = new SoapClient('exampleapi.wsdl');

   /* Set search parameters */
   $params = array('first'=>'jo*', 'last'=>'*');

   /* Make request and dump response */
   $response = $sClient->getPeopleByFirstLastName($params);
   var_dump($response);
} catch (SoapFault $e) {
   /* Dump any caught SoapFault exceptions */
   var_dump($e);
}
?>


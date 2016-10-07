<?php
include("SOAP/Client.php");

/* Create client using WSDL */
$wsdl = new SOAP_WSDL("exampleapi.wsdl");
$sClient = $wsdl->getProxy();

/* Make request and dump response */
$response = $sClient->getPeopleByFirstLastName('jo*', '*');
var_dump($response);
?>


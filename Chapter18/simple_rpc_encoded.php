<?php
/* Temperature in celcius */
$temp_celcius = 5;

/* Location of WSDL */
$wsdl = 'http://java.hpcc.nectec.or.th:1978/axis/TemperatureConvert.jws?wsdl';

$sClient = new SoapClient($wsdl);

/* Output the temperature in Fahrenheit*/
print  $sClient->CelsiusTOFahrenheit($temp_celcius)
?>


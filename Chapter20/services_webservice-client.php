<?php
<?php
try {
    $sClient = new SoapClient('http://www.example.org/services_webservice-server.php?WSDL');
    $response = $sClient->search('smi');
    foreach ($response AS $key=>$value) {
        $person = $sClient->getPerson($value);
        var_dump($person);
    }
} catch (SoapFault $e) {
   var_dump($e);
}
?>


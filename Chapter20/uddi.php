<?php
require_once 'UDDI/UDDI.php';
$uddi = new UDDI('IBM', 2);

$params = array("generic"=>"2.0", "name"=>"Acme XML%",
                                  "maxRows"=>5, 
                                  "findQualifiers"=>"sortByNameAsc,sortByDateAsc");

$result = $uddi->find_business($params);
var_dump($result);
?>


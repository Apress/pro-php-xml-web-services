<?php
$access_key = '&AWSAccessKeyId=<your access key id>';

$query = 'http://webservices.amazon.com/onca/xml?Service=AWSECommerceService';
$query .= $access_key;
$query .= '&Operation=ItemSearch&Keywords='.rawurlencode('linksys');
$query .= '&SearchIndex=Electronics';


$dom = new DOMDocument();
$dom->formatOutput = TRUE;
$dom->load($query);
print $dom->saveXML();
?>


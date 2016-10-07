<?php
$access_key = '&AWSAccessKeyId=<your Access Key ID>';

$query = 'http://webservices.amazon.com/onca/xml?Service=AWSECommerceService';
$query .= $access_key;
$query .= '&Operation=CartCreate&Item.1.ASIN=1590596331&Item.1.Quantity=1';
$query .= '&MergeCart=True';

$dom = new DOMDocument();
$dom->formatOutput = TRUE;
$dom->load($query);
print $dom->saveXML();
?>


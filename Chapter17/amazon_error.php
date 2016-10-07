<?php
$query = 'http://webservices.amazon.com/onca/xml?Service=AWSECommerceService'.
         '&Operation=ItemSearch';

/* Example Error checking using DOM */
$dom = new DOMDocument();
$dom->formatOutput = TRUE;
$dom->load($query);
$xpath = new DOMXPath($dom);
$errors = $xpath->query('//*[local-name()="Error"]');
if ($errors && $errors->length > 0) {
   /* Dump first error */
   echo $dom->saveXML($errors->item(0));
} else {
   /* Result is valid so process */
}

/* Example Error checking using SimpleXML */
$sxe = simplexml_load_file($query);
$xpath = $sxe->xpath('//*[local-name()="Error"]');
if (is_array($xpath) && count($xpath) > 0) {
   /* Dump first error */
   echo $xpath[0]->asXML();
} else {
   /* Result is valid so process */
}
?>


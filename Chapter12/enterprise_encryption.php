<?php
$key = 'secret';

/* Encrypt Data */
$doc = new DOMDocument();
$doc->load('payment.xml');


$xpath = new DOMXPath($doc);
$creditcard = $xpath->query("//creditcard")->item(0);
$plaintext = $doc->saveXML($creditcard);

$td = mcrypt_module_open(MCRYPT_3DES, '',  MCRYPT_MODE_CBC, '');
$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td),  MCRYPT_RAND);
mcrypt_generic_init($td, $key, $iv);
$encrypted_data = mcrypt_generic($td, $plaintext);
mcrypt_generic_deinit($td);
mcrypt_module_close($td);

$keyInfo = $doc->createElementNS("http://www.w3.org/2000/09/xmldsig#", "KeyInfo");

$keyTmp = $doc->createElementNS("http://www.w3.org/2000/09/xmldsig#",
                                "KeyName", "mcryptiv");
$keyInfo->appendChild($keyTmp);

/* Base64 Encode the IV value, and set to KeyValue content */
$keyTmp = $doc->createElementNS("http://www.w3.org/2000/09/xmldsig#",
                                "KeyValue", base64_encode($iv));
$keyInfo->appendChild($keyTmp);

/* Add EncryptedData element */
$encData = $doc->createElementNS("http://www.w3.org/2001/04/xmlenc#",
                                 "EncryptedData");
$encData->setAttribute("Type", "http://www.w3.org/2001/04/xmlenc#Element");
$creditcard->parentNode->replaceChild($encData, $creditcard);


/* Add EncryptionMethod element */
$encMethod = $doc->createElementNS("http://www.w3.org/2001/04/xmlenc#",
                                   "EncryptionMethod");
$encMethod->setAttribute("Algorithm",
                         "http://www.w3.org/2001/04/xmlenc#tripledes-cbc"); 
$encData->appendChild($encMethod);

/* Add KeyInfo element */
$encData->appendChild($keyInfo);

/* Create CipherData element */
$cipherData = $doc->createElementNS("http://www.w3.org/2001/04/xmlenc#",
                                    "CipherData");
$encData->appendChild($cipherData);

/* Base64 encode the value to be used as the element content */
$encoded = base64_encode($encrypted_data);
$cipherValue = $doc->createElementNS("http://www.w3.org/2001/04/xmlenc#",
                                     "CipherValue", $encoded);
$cipherData->appendChild($cipherValue);

print $doc->saveXML()."\n\n";


/* De-Crypt Document */
$encdom = $doc;
$xpath = new DOMXPath($encdom);
$query = "//*[local-name()='EncryptedData' and ".
         "namespace-uri()='http://www.w3.org/2001/04/xmlenc#']";
$nodeset = $xpath->query($query);
if ($nodeset->length == 0) {
   exit;
}

$encData = $nodeset->item(0);

/* Get information on type of data encrypted */
$encType = $encData->getAttribute("Type");

/* default algorithm */
$algorithm = "http://www.w3.org/2001/04/xmlenc#tripledes-cbc";

/* Find the algorithm used for encryption */
$query = "//*[local-name()='EncryptionMethod' and ".
         "namespace-uri()='http://www.w3.org/2001/04/xmlenc#']";
$nodeset = $xpath->query($query);
if ($nodeset->length == 1) {
   $attrAlgorithm = $nodeset->item(0)->getAttribute("Algorithm");
   if ($attrAlgorithm) {
      $algorithm = $attrAlgorithm;
   }
}

switch ($algorithm) {
   case "http://www.w3.org/2001/04/xmlenc#tripledes-cbc":
      $mcryptalg = MCRYPT_3DES;
      $mcryptblock = MCRYPT_MODE_CBC;
      break;
   default:
      print "Unhandled Algorithm";
      exit;
}

/* Find Key Information */
$query = "string(//*[local-name()='KeyName' and ".
         "namespace-uri()='http://www.w3.org/2000/09/xmldsig#'])";
$keyName = $xpath->evaluate($query);
$query = "string(//*[local-name()='KeyValue' and ".
         "namespace-uri()='http://www.w3.org/2000/09/xmldsig#'])";

/* KeyValue is Base64 encoded and must be decoded */
$keyValue = base64_decode($xpath->evaluate($query));

/* Find the Cipher Information */
$node = NULL;
$query = "//*[local-name()='CipherData' and ".
         "namespace-uri()='http://www.w3.org/2001/04/xmlenc#']";
$nodeset = $xpath->query($query);
if ($nodeset->length == 1) {
   $CipherData = $nodeset->item(0);
   /* Find the child element as this element may have only one */
   foreach ($CipherData->childNodes AS $node) {
      if ($node->nodeType == XML_ELEMENT_NODE) {
         break;
      }
   }
}

/* Error out if no child elements found */
if (! $node) {
   print "Unable to find Encrpyted Data";
   exit;
}

/* Based on the element name, find the data and obtain encrypted octet sequence */ 
if ($node->nodeName == "CipherReference") {
   /* Handle CipherReference here
      $encryptedData = .....   
   */
} elseif ($node->nodeName == "CipherValue") {
   /* Base64 Decode decode the value to obtain encrypted octet sequence */
   $encryptedData = base64_decode($node->nodeValue);
}

$td = mcrypt_module_open($mcryptalg, '',  $mcryptblock, '');

/* IV was passed with KeyValue and must be used to properly decrypt */
mcrypt_generic_init($td, $key, $keyValue);
$decrypted_data = mdecrypt_generic($td, $encryptedData);
mcrypt_generic_deinit($td);
mcrypt_module_close($td);
print $decrypted_data."\n\n";
exit;

$newdoc = NULL;
switch ($encType) {
   case "http://www.w3.org/2001/04/xmlenc#Element":
      /* load Element element into a new document */
      $newdoc = new DOMDocument();
      $newdoc->loadXML($decrypted_data); 
      break;
   case "http://www.w3.org/2001/04/xmlenc#Content":
      /* This may be a fragment so create a doc with a root node, 
         load the data into a fragment - PHP 5.1 only - and append 
         the fragment to the document element. */
      $newdoc = new DOMDocument();
      $newdoc->loadXML('<root />');
      $frag = $newdoc->createDocumentFragment();
	      $frag->appendXML($decrypted_data);
	      $newdoc->documentElement->appendChild($frag);
      break;
   default:
      /* Data is generic type and possibly not XML */
}

if ($newdoc) {
   print $newdoc->saveXML();
}

?>
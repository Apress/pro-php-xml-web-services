<?php
$key = "secret";
$canonMethod = "http://www.w3.org/TR/2001/REC-xml-c14n-20010315";

/* Generic hmac function */
function hmac ($key, $data)
{
   $b = 64; // byte length
   if (strlen($key) > $b) {
      $key = pack("H*",sha1($key));
   }
   $key  = str_pad($key, $b, chr(0x00));
   $ipad = str_pad('', $b, chr(0x36));
   $opad = str_pad('', $b, chr(0x5c));
   $k_ipad = $key ^ $ipad ;
   $k_opad = $key ^ $opad;

   return sha1($k_opad  . pack("H*",sha1($k_ipad . $data)));
}


/* Load skeleton signature */
$doc = new DOMDocument();
$doc->load('listing12-3.xml');


$xPath = new DOMXpath($doc);
/* Following line split into two lines due tobecause of length */
$query = '//*[local-name()="Reference" and '.
         'namespace-uri()="http://www.w3.org/2000/09/xmldsig#"]';
$nodeset = $xPath->query($query);
$refElement = $nodeset->item(0);
$dataURI = $refElement->getAttribute("URI");

/* Retrieve the Object element */
$ID = substr ($dataURI, 1);
$query = '//*[@Id="'.$ID.'"]';
$nodeset = $xPath->query($query);
$Object = $nodeset->item(0);

/*******************
 * Generate Digest *
 *******************/

$dom = new DOMDocument();
$copyObject = $dom->importNode($Object, TRUE);
$dom->appendChild($copyObject);

$query = '//*[local-name()="DigestMethod" and '.
   'namespace-uri()="http://www.w3.org/2000/09/xmldsig#"]';
$nodeset = $xPath->query($query);
$digMethod = $nodeset->item(0);
$algorithm = $digMethod->getAttribute("Algorithm");
if ($algorithm == "http://www.w3.org/2000/09/xmldsig#sha1") {
   $canonical = $dom->saveXML($copyObject);

   /* Create SHA1 hash of the canonical form of the Object element */
   $hash = sha1($canonical);
   $bhash = pack("H*", $hash);
   $digValue = base64_encode($bhash);
   
   /* Following is done in example only to add proper whitespacing */
   $addPrev = NULL;
   $addPost = NULL;
   if ($digMethod->previousSibling->nodeType == XML_TEXT_NODE) {
      $addPrev = clone $digMethod->previousSibling;
   }
   if ($digMethod->nextSibling->nodeType == XML_TEXT_NODE) {
      $addPost = clone $digMethod->nextSibling;
   }
   /* End custom whitespaces */

   /* Create DigestValue element, and append to parent of DigestMethod */
   $digestValue = $doc->createElementNS("http://www.w3.org/2000/09/xmldsig#",
                                        "DigestValue", $digValue);
   $digMethod->parentNode->appendChild($digestValue);
   
   /* Following is done in example only to add proper whitespacing */
   if ($addPrev) {
      $digMethod->parentNode->insertBefore($addPrev, $digestValue);
      $digMethod->parentNode->removeChild($digMethod->nextSibling);
   }
   if ($addPost) {
      $digMethod->parentNode->appendChild($addPost);
   }
   /* End addition of whitespaces */
} else {
   print "Unhandled Encoding";
   exit;
}

/**********************
 * Generate Signature *
 **********************/

/* Retrieve SignedInfo element */
$query = '//*[local-name()="SignedInfo" and '.
         'namespace-uri()="http://www.w3.org/2000/09/xmldsig#"]';
$nodeset = $xPath->query($query);
$signedInfo = $nodeset->item(0);

$dom = new DOMDocument();
$copyInfo = $dom->importNode($signedInfo, TRUE);
$dom->appendChild($copyInfo);

$dom = new DOMDocument();
$copyInfo = $dom->importNode($signedInfo, TRUE);
$dom->appendChild($copyInfo);
/*
  Following only works only with PHP 5.1 and above. LIBXML_NOEMPTYTAG used to
  create start and end tags for empty elements. Document element $copyInfo passed 
  to dump the node which , which does not generate an XML declaration output
*/
$canonical = $dom->saveXML($copyInfo, LIBXML_NOEMPTYTAG);

/* Calculate HMAC SHA1 */
$hmac = hmac($key,$canonical);
print $hmac."\n";
$bhmac = base64_encode(pack("H*", $hmac));

/* Handle wWhitespaces for pPresentation layout */
$addPrev = NULL;
$addPost = NULL;
if ($Object->previousSibling->nodeType == XML_TEXT_NODE) {
  $addPrev = clone $Object->previousSibling;
}
if ($Object->nextSibling->nodeType == XML_TEXT_NODE) {
  $addPost = clone $Object->nextSibling;
}
/* END Handle wWhitespaces for pPresentation layout */

/*
   Create and append the SignatureValue element as child of Signature element
   insertBefore are used with whitespacing to generate output in Listing 12-2.
*/
$sigValue = $doc->createElementNS("http://www.w3.org/2000/09/xmldsig#",
                                  "SignatureValue", $bhmac);
if ($addPrev) {
  $Object->parentNode->insertBefore($sigValue, $Object->previousSibling);
} else {
  $Object->parentNode->insertBefore($sigValue, $Object);
}

/* Following is done in example only to add proper whitespacing */
if ($addPost) {
  $Object->parentNode->insertBefore($addPrev, $sigValue);
}

print $doc->saveXML()."\n";



/********************
 * Verify Signature *
 ********************/

/* Retrieve Reference node and location of data */
$xPath = new DOMXpath($doc);
$query = '//*[local-name()="Reference" and
 namespace-uri()="http://www.w3.org/2000/09/xmldsig#"]';
$refElement = $xPath->query($query)->item(0);
$dataURI = $refElement->getAttribute("URI");



/* Retrieve Digest Value for current Reference */
$query = 'string(./*[local-name()="DigestValue" '.
   'and namespace-uri()="http://www.w3.org/2000/09/xmldsig#"])';
$signedDigest = $xPath->evaluate($query, $refElement);

$ID = substr ($dataURI, 1);
$query = '//*[@Id="'.$ID.'"]';
$Object = $xPath->query($query)->item(0);

/* Create canonical form for Object element */
$dom = new DOMDocument();
$copyObject = $dom->importNode($Object, TRUE);
$dom->appendChild($copyObject);
$canonical = $dom->saveXML($copyObject);

/* Assume digest algorithm retrieved and SHA1 was found */
/* Create SHA1 hash of the canonical form of the Object element */
$hash = sha1($canonical);
$bhash = pack("H*", $hash);
$digValue = base64_encode($bhash);

if ($signedDigest != $digValue) {
   print "Digest Authentication Failed\n";
   exit;
} else {
   print "Digest Authentication Success!\n";
}

/**********************
 * Validate Signature *
 **********************/

/* Retrieve Value for SignatureValue element */
$query = 'string(//*[local-name()="SignatureValue" '.
   'and namespace-uri()="http://www.w3.org/2000/09/xmldsig#"])';
$signature = base64_decode($xPath->evaluate($query));

/* Generate canonical form of SignedInfo element*/
$signedInfo = $xPath->query("//*[local-name() = 'SignedInfo']")->item(0);
$dom = new DOMDocument();
$copyInfo = $dom->importNode($signedInfo, TRUE);
$dom->appendChild($copyInfo);
/*
  Following only works only with PHP 5.1 and above
  LIBXML_NOEMPTYTAG used to create start and end tags for empty elements
  document element $copyInfo passed dump the node which does not generate
  an XML declaration output
*/
$canonical = $dom->saveXML($copyInfo, LIBXML_NOEMPTYTAG);
$key = "secret";
$hmac = hmac($key,$canonical);
$calc_signature = pack("H*", $hmac);

if ($signature != $calc_signature) {
   print "Signature Authentication Failed\n";
} else {
   print "Signature Authentication Success!\n";
}


?>
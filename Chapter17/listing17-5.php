<?php
/* This is the application ID you registered with Yahoo */
$appid = "<your Yahoo! application id>";

/* URL to Product Search service */
$url = 'http://api.shopping.yahoo.com/ShoppingService/V1/productSearch';

/* The query is separate here because the terms must be encoded. */
$url .= '?query='.
         rawurlencode('Linksys Wireless-G Broadband Router WRT54G Router');

/* Complete the URL with App ID, limit to 5 results*/
$url .= "&amp;appid=$appid&amp;results=5";

/* Create document, and set url to url document element */
$dom = new DomDocument();
$dom->appendChild(new DOMElement('url', $url));

/* Load the style sheet yahooprod.xsl from Listing 17-6. */
$xsl = new DOMDocument();
$xsl->load('yahooprod.xsl');

/* Have the style sheet make the request and transform the results */
$proc = new xsltprocessor();
$proc->importStylesheet($xsl);
print $proc->transformToXML($dom);
?>


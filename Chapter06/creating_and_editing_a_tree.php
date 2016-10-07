<?php
/* Document Nodes */
$doctype = DOMImplementation:: createDocumentType("book", 
           "-//OASIS//DTD DocBook XML V4.1.2//EN", 
           "http://www.oasis-open.org/docbook/xml/4.1.2/docbookx.dtd");
$dom = DOMImplementation:: createDocument(NULL, "book", $doctype);

$dom->encoding = "UTF-8";


/* Creating Elements */
$bookinfo = $dom->createElement("bookinfo");

$bititle = $dom->createElement("title", "DOM in PHP 5");

$biauthor = $dom->createElementNS(NULL, "author");

$trash = $dom->createElementNS("http://www.example.com/trash", "tr:trash");

$firstname = new DOMElement("firstname", "Rob");
$surname = new DOMElement("surname", "Richards");

try {
   $test = new DOMElement("123");
} catch (DOMException $e) {
   var_dump($e);
}

$nsElement = new DOMElement("nse:myelement", NULL, "http://www.example.com/ns");


/* Inserting Elements */
$dom->documentElement->appendChild($bookinfo);

$biauthor->appendChild($surname);
$biauthor->insertBefore($firstname, $surname);

$biauthor->appendChild($firstname);
$biauthor->appendChild($surname);

$bookinfo->appendChild($biauthor);

$dom->formatOutput = TRUE;
print $dom->saveXML();


$bookinfo->insertBefore($bititle, $biauthor);


/* Attribute Nodes */
$bookinfo->setAttribute("lang", "en");


/* Text Nodes */
$yeartxt = $dom->createTextNode("2005");
$yeartxt = new DOMText("2005");

/* Create and Append a copyright element */
$copyright = $bookinfo->appendChild(new DOMElement("copyright"));

/* Create year element */
$year = $dom->createElement("year");

/* Append text node to set content */
$year->appendChild($yeartxt);
$copyright->appendChild($year);

/* Append a newly created holder element with content "Rob Richards" */
$copyright->appendChild(new DOMElement("holder", "Rob Richards"));

/* If content is not whitespace then ... */
if (! $yeartxt->isElementContentWhitespace()) {
   /* Print substring at offset 1 and length 2: 00 */
   print $yeartxt->substringData(1,2)."\n";
   
   /* Append the string -2006 to the content and print output: 2005-2006 */
   $yeartxt->appendData("-2006");
   print $yeartxt->nodeValue."\n";
   
   /* Delete content at offset 4 with length of 5 and print output: 2005 */
   $yeartxt->deleteData(4,5);
   print $yeartxt->nodeValue."\n";

   /* Insert string "ABC" at offset 1 and print output: 2ABC005 */
   $yeartxt->insertData(1, "ABC");
   print $yeartxt->nodeValue."\n";
   
   /* Replace content at ofset 1 with length of 3 with an empty string: 2005 */
   $yeartxt->replaceData(1, 3, "");
   print $yeartxt->nodeValue."\n";
}

$dom->formatOutput = TRUE;
print $dom->saveXML();
?>

<?php
/* Set up the XSLT pProcessor */
$xslDoc = new DOMDocument();
$xslDoc->load("bigxml2.xsl");
$xsltProc = new XsltProcessor();
$xsltProc->importStylesheet($xslDoc);

$reader = new XMLReader();
$reader->open('bigxml2.xml');
/* Following two lines, position curson cursor on the document element node */
$reader->read();
$reader->read();
/* Move cursor to first child node of document element */
if ($reader->read()) {
   /* Perform tests, and use next() method to traverse sibling nodes */
   do {
      if ($reader->nodeType == XMLREADER::ELEMENT) {
         /* XSL output filenames will be based on element names */
         $filename = $reader->localName.".xml";

         $node = $reader->expand();
         /* Add expanded node to a DOMDocument, and transform it */
         $dom = new DOMDocument();
         $dom->appendChild($node);
         $xsltProc->transformToUri($dom, $filename);
         unset($dom);
      }
   } while($reader->next());
}?>

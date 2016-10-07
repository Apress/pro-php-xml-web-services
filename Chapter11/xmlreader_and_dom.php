<?php
define('XINCLUDEURI', "http://www.w3.org/2001/XInclude");

/* Adds new xi:include elements to the new document */
function addXISection($xidoc, $filename) {
   $root = $xidoc->documentElement;
   $newXI = $xidoc->createElementNS(XINCLUDEURI, "xi:include");
   $root->appendChild($newXI);
   $newXI->setAttribute("href", $filename);
}

/* Create the main document that will hold the XInclude links */
$domXI = new DOMDocument();
$root = $domXI->appendChild(new DOMElement("document"));
$root->setAttributeNS("http://www.w3.org/2000/xmlns/", "xmlns:xi", XINCLUDEURI);

/* Create the Reader, and begin to parse document */
$reader = new XMLReader();
$reader->open('bigxml2.xml');

/* Following two lines, position cursor on the document element node */
$reader->read();
$reader->read();

/* Move cursor to first child node of document element */
if ($reader->read()) {
   /* Perform tests, and use next() method to traverse sibling nodes */
   do {
      if ($reader->nodeType == XMLREADER::ELEMENT) {
         /* XInclude filenames will be based on element names */
         $filename = $reader->localName.".xml";
         $node = $reader->expand();

         /* Add expanded node to a DOMDocument, and serialize it to file */
         $subdom = new DOMDocument();
         $subdom->appendChild($node);
         $subdom->save($filename);

         /* Free document from memory */
         unset($subdom);

         addXISection($domXI, $filename);
      }
   } while($reader->next());
}
$domXI->formatOutput = TRUE;
$domXI->save("segmented.xml");
?>

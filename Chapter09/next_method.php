<?php
$objReader = XMLReader::open('reader.xml');
/* Find the title element */
while ($objReader->read()) {
   if ($objReader->nodeType == XMLREADER::ELEMENT
       && $objReader->localName == "title") {
      break;
   }
}

/* find the section element that is a sibling of title */
while ($objReader->next()) {
   if ($objReader->nodeType == XMLREADER::ELEMENT
       && $objReader->localName == "section") {
      break;
   }
}

/* Descend into subtree of section element */
$objReader->read();
/* First whitespace node is skipped */

$depth = $objReader->depth;

while ($objReader->next()) {
   /* If depth is less that initial depth cursor is out of the subtree */
   if ($objReader->depth < $depth) {
      print "\n**** Ascending rest of tree\n";
      print "Current Node: ".$objReader->localName;
      print " Type: ".$objReader->nodeType." Depth: ".$objReader->depth."\n";
      break;
   }
   print "Current Node: ".$objReader->localName;
   print " Type: ".$objReader->nodeType." Depth: ".$objReader->depth."\n";
}
?>

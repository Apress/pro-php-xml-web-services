<?php
$objReader = XMLReader::open('reader.xml');
$objReader->setParserProperty(XMLREADER::VALIDATE, TRUE);
while ($objReader->read()) {
   if (! $objReader->isValid()) {
      print "NOT VALID\n";
      break;
   }
}
?>

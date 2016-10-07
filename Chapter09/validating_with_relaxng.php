<?php
$schema = '<?xml version="1.0" encoding="utf-8" ?>
<element name="chapter" xmlns="http://relaxng.org/ns/structure/1.0">
   <element name="title">
      <text/>
   </element>
   <element name="para">
      <text/>
   </element>
   <element name="section">
      <attribute name="id" />
      <text/>
   </element>
</element>';

$objReader = XMLReader::open('reader.xml');
$objReader->setRelaxNGSchemaSource($schema);

libxml_use_internal_errors(TRUE);
while ($objReader->read()) {
   if (! $objReader->isValid()) {
      $xmlError = libxml_get_last_error();
      var_dump($xmlError);
      exit;
   }
}

?>

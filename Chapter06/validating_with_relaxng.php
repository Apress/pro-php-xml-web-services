<?php
$dom = DOMDocument::loadXML('<?xml version="1.0"?>
<courses>
   <course>
      <title>Algebra</title>
   </course>
</courses>');


$schema = '<?xml version="1.0" encoding="utf-8" ?>
<element name="courses" xmlns="http://relaxng.org/ns/structure/1.0">
   <zeroOrMore>
      <element name="course">
         <element name="title">
            <text/>
         </element>
      </element>
   </zeroOrMore>
</element>';

$isvalid = $dom->relaxNGValidateSource($schema);
var_dump($isvalid);

?>
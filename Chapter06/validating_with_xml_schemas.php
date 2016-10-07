<?php
$dom = DOMDocument::loadXML('<?xml version="1.0"?>
<courses>
   <course>
      <title>Algebra</title>
   </course>
</courses>');

$schema = '<?xml version="1.0"?>
<xsd:schema xmlns:xsd="http://www.w3.org/2001/XMLSchema">
   <xsd:element name="courses">
      <xsd:complexType>
         <xsd:sequence>
            <xsd:element name="course" minOccurs="0" maxOccurs="unbounded">
               <xsd:complexType>
                  <xsd:sequence>
                    <xsd:element name="title" type="xsd:string"/>
                  </xsd:sequence>
               </xsd:complexType>
            </xsd:element>
         </xsd:sequence>
      </xsd:complexType>
   </xsd:element>
</xsd:schema>';

$isvalid = $dom->schemaValidateSource($schema);

var_dump($isvalid);

?>
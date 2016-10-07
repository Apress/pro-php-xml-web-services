<?php

class cXML extends DOMDocument {
   private $currentNode = NULL;
   public $sepaerator = ":";


   public function __construct() {
      parent::__construct();
	      $this->currentNode = $this;  
   }

   function startElement($parser, $data, $attrs) {
      try {
         $nsElement = explode($this->sepaerator, $data);
         if (count($nsElement) > 1) {
            $uri = array_shift($nsElement);
            $name = implode($this->sepaerator, $nsElement);
            $node = $this->createElementNS($uri, $name);
         } else {
            $node = $this->createElement($data);
         }
         $this->currentNode = $this->currentNode->appendChild($node);
         foreach ($attrs AS $name=>$value) {
            $nsAttribute = explode($this->sepearator, $name);
            if (count($nsAttribute) > 1) {
               $uri = array_shift($nsAttribute);
               $name = implode($this->sepaerator, $nsAttribute);
               $node = $this->currentNode->setAttributeNS($uri, $name, $value);
            } else {
               $this->currentNode->setAttribute($name, $value);
            }
         }
      } catch (DOMException $e) {
         throw $e;
      }
   }

   function endElement($parser, $data) { 
      $this->currentNode = $this->currentNode->parentNode;
   }

   function characterData($parser, $data) {
      try {
         $this->currentNode->appendChild(new DOMText($data));
      } catch (DOMException $e) {
         throw $e;
      }
   }

   function PIHandler($parser, $target, $data) {
      $node = $this->createProcessingInstruction($target, $data);
      $this->currentNode->appendChild($node);
   }
}


$xml_parser = xml_parser_create_ns(NULL, "@");

$objXMLDoc = new cXML();
$objXMLDoc->sepearator = "@";

xml_set_object($xml_parser, $objXMLDoc);
xml_parser_set_option ($xml_parser, XML_OPTION_CASE_FOLDING, 0);
xml_set_element_handler($xml_parser, "startElement", "endElement");
xml_set_character_data_handler($xml_parser, "characterData");
xml_set_processing_instruction_handler($xml_parser, "PIHandler");

/* The following can be changed to any XML document */
$xmldata = "<root><element1>text</element1><e2>text<e3>more</e3>text</e2></root>";

try {
   if (! xml_parse($xml_parser, $xmldata, true)) {
      $xmlError = libxml_get_last_error();
      var_dump($xmlError);
   }
} catch (DOMException $e) {
   var_dump($e);
}

xml_parser_free($xml_parser);

print $objXMLDoc->saveXML();
?>
<?php
class cReader extends XMLReader {
   private $document = NULL;
   private $currentNode = NULL;
   const xmlns = "http://www.w3.org/2000/xmlns/";

   public function __construct() {
      /* Create the base document for the tree */
      $this->document = new DOMDocument();
      $this->currentNode = $this->document;
   }

   function attributes() {
      /* DOM throws exceptions so try/catch used */
      try {
         if ($this->moveToFirstAttribute()) {
            do {
               /* Attributes are always prefixed when in a namespace */
               if ($this->prefix) {
                  if ($this->prefix != "xmlns") {
                     $this->currentNode->setAttributeNS($this->namespaceURI,
                                                        $this->name, $this->value);
                   } else {
                      /* This is a namespace declaration.
                         Ensure it is created as it may not be used on element */
                      $this->currentNode->setAttributeNS(self::xmlns,
                                                         $this->name, $this->value);
                   }
               } else {
                  /* No need to handle default namespace declarations.
                     DOM already creates them with the element */
                  if ($this->name != "xmlns") {
                     $this->currentNode->setAttribute($this->name, $this->value);
                   }
               }
            } while ($this->moveToNextAttribute());
         }
      } catch (DOMException $e) {
         throw $e;
      }
   }

   function startElement() {
      try {
         if ($this->namespaceURI) {
            $node = $this->document->createElementNS($this->namespaceURI,
                                                     $this->name);
         } else {
            $node = $this->document->createElement($this->name);
         }
         $this->currentNode = $this->currentNode->appendChild($node);
         if ($this->hasAttributes) {
            $this->attributes();
         }
      } catch (DOMException $e) {
         throw $e;
      }
   }

   function endElement() { 
      $this->currentNode = $this->currentNode->parentNode;
   }

   function characterData() {
      try {
         $this->currentNode->appendChild(new DOMText($this->value));
      } catch (DOMException $e) {
         throw $e;
      }
   }

   function PIHandler() {
      $node = $this->document->createProcessingInstruction($this->name,
                                                           $this->value);
      $this->currentNode->appendChild($node);
   }

   function saveXML() {
      return $this->document->saveXML();
   }
}

$xmldata = "<root><element1>text</element1><e2>text<e3>more</e3>text</e2></root>";

$objReader = new cReader();
$objReader->XML($xmldata);

try {
   while ($objReader->read()) {
      switch ($objReader->nodeType) {
         case XMLREADER::ELEMENT:
            $objReader->startElement();
            break;
         case XMLREADER::END_ELEMENT:
            $objReader->endElement();
            break;
         case XMLREADER::TEXT:
         case XMLREADER::CDATA:
         case XMLREADER::WHITESPACE:
         case XMLREADER::SIGNIFICANT_WHITESPACE:
            $objReader->characterData();
            break;
         case XMLREADER::PI:
            $objReader->PIHandler();
            break;
      }
   }
} catch (DOMException $e) {
   var_dump($e);
}

print $objReader->saveXML();
?>

<?php
$doc = DOMDocument::loadXML('<?xml version="1.0"?>
<root>
   <child1>child1 content</child1>
   <child2>child2 content</child2>
   <child3>child3 content</child3>
</root>');

$root = $doc->documentElement;
$child2 = $root->getElementsByTagName("child2")->item(0);
$child3 = $root->getElementsByTagName("child3")->item(0);

$root->removeChild($child2);

/* Output the serialized tree using formatting for readability */
$doc->formatOutput = TRUE;
echo $doc->saveXML();


$oldchild = $root->replaceChild(new DOMElement("newchild", "new content"), $child3);

/* Output the serialized tree using formatting for readability */
$doc->formatOutput = TRUE;
echo $doc->saveXML();

?>
<?php
require_once "XML/Util.php";

$doc = XML_Util::getXMLDeclaration("1.0", "UTF-8");

$atts = array("name"=>"courses");
$doc .= XML_Util::createStartElement("element", $atts,
                                     "http://relaxng.org/ns/structure/1.0");
$doc .= XML_Util::createStartElement("zeroOrMore");
$doc .= XML_Util::createStartElement("element", array("name"=>"course"));
$doc .= XML_Util::createStartElement("element", array("name"=>"title"));
$doc .= XML_Util::createTag("text");
$doc .= XML_Util::createEndElement("element");
$doc .= XML_Util::createEndElement("element");
$doc .= XML_Util::createEndElement("zeroOrMore");
$doc .= XML_Util::createEndElement("element");

print $doc;
?>


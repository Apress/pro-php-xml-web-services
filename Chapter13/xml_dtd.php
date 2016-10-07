<?php
require_once 'XML/DTD.php';
$dtdfile = "xmldtd.dtd";

$dtdParser = new XML_DTD_Parser;
$tree = $dtdParser->parse($dtdfile);
var_dump($tree);
?>


<?php
require_once 'XML/Serializer.php';

$vals = array('a', 'b', 'c');

$options = array(
   'addDecl' => TRUE,
   'encoding' => 'UTF-8',
   'indent' => "\t",
   'defaultTagName' => 'myelement',
   'rootName' => 'mydoc'
);

$Serializer = new XML_Serializer($options);
$result = $Serializer->serialize($vals, array('returnResult' => TRUE));

print $result."\n";
$result = $Serializer->getSerializedData();

require_once 'XML/Unserializer.php';

$XMLUnserializer = new XML_Unserializer();

$result2 = $XMLUnserializer->unserialize($result, FALSE,
                                         array('returnResult' => TRUE));

if (PEAR::isError($result2)) {
   die($result2->getMessage());
}

var_dump($XMLUnserializer->getUnserializedData());

print "\n".$XMLUnserializer->getRootName()."\n";
 
?>


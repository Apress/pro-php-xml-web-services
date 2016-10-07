<?php
$xml = '<doc><element1 att1="attvalue" att2="att2value"/>
<element2>content</element2><!-- This 
is a 
comment --></doc>';

require_once 'XML/Beautifier.php';
$fmt = new XML_Beautifier(array("multilineTags"=>TRUE, "normalizeComments"=>
TRUE));
$result = $fmt->formatString($xml);
print $result;
?>


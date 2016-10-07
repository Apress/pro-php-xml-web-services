<?php
require_once 'XML/FastCreate.php';

$oFastCreate = XML_FastCreate::factory('Text');

$oFastCreate->courses(
   $oFastCreate->comment('Intro to French Course'),
   $oFastCreate->course(
      $oFastCreate->title('French I'),
      $oFastCreate->description('Introductory French')
   ),
   $oFastCreate->comment('Intermediate French Course'),
   $oFastCreate->course(
      $oFastCreate->title('French II'),
      $oFastCreate->description('Intermediate French')
   )
);

$xml = $oFastCreate->getXML();
print $oFastCreate->indentXML($xml);
?>


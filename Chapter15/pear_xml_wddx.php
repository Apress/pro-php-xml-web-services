<?php
/* Require the XML_Wddx package */
require 'XML/Wddx.php';

/* Some variables to pass */
$myinteger = 1;
$mystring = 'My String';
$mysecondstring = "Second\nString";
$myarray = array('a', 'b', 'c');
$mystruct = array('key1'=>'a', 'key2'=>'b', 'key3'=>'c');

/* Multiple variables must be passed within an array */
$myvalues = array($myinteger, $mystring, $mysecondstring, $myarray, $mystruct);

$objWddx = new XML_Wddx();

echo $objWddx->serialize($myvalues);
?>


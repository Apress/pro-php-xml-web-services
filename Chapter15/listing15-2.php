<?php
/* Some variables to pass */
$myinteger = 1;
$mystring = "My String";
$mysecondstring = "Second\nString";
$myarray = array('a', 'b', 'c');
$mystruct = array('key1'=>'a', 'key2'=>'b', 'key3'=>'c');

/* Multiple variables being serialized at once */
$serialized_out = wddx_serialize_vars('myinteger', 'mystring', 'mysecondstring',
                         'myarray', 'mystruct');
echo $serialized_out;
?>


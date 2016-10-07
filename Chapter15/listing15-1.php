<?php
class myClass
{
   public $prop1;
   public $prop2 = 'default';
   public $prop3 = 0;
   /* Additional functionality here */
}

$objMyClass = new myClass();
$objChildClass = new myClass();

/* Set prop1 to the $objChildClass */
$objMyClass->prop1 = $objChildClass;

$myInteger = 2;

/* Serialize the variables
The variable names are passed not the actual variables */
$output = wddx_serialize_vars('myInteger', 'objMyClass');

print $output
?>


<?php

function generate_error($messages) {
   $error = '<error>';
   /* A message does not contain any characters invalid for element content */
   foreach ($messages AS $message) {
      $error .= '<message>'.$message.'</message>';
   }
   $error .= '</error>';
   return $error;
}

function addit($num1, $num2) {
   $retval = '<value>';
   $retval .= $num1 + $num2;
   $retval .= '</value>';
   return $retval;
}

/* Set content type for XML */
header('Content-type: text/xml');
print '<?xml version="1.0"?>';

$errors = array();
if (isset($_GET['num1'])) {
   if (isset($_GET['num2'])) {
      print addit((int)$_GET['num1'], (int)$_GET['num2']);
   } else {
      $errors[] = 'Missing num2 parameter';
   }
} else {
   $errors[] = 'Missing num1 parameter';
   if (! isset($_GET['num2'])) {
      $errors[] = 'Missing num2 parameter';
   }
}

print generate_error($errors);
?>


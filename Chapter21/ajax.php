<?php
header('Content-Type: text/xml');
print '<?xml version="1.0" encoding="UTF-8"?>';

$current_users = array('rob', 'john', 'joe');
function checkname($username) {
   if (in_array($username, $GLOBALS['current_users'])) {
      return 1;
   }
   return 0;
}
?>


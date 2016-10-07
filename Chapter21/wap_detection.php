<?php
define('TYPE_BROWSER', 0);
define('TYPE_WAP_1', 1);
define('TYPE_WAP_2', 2);

/* Check whether client is a mobile device - does it support WAP? */
if (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml')) {
   /* Does this WAP device also support XHTML/WAP 2.0? */
   if (strpos($_SERVER['HTTP_ACCEPT'], 'xhtml+xml')) {
      define('WAP_TYPE', TYPE_WAP_2);
   } else {
      define('WAP_TYPE', TYPE_WAP_1);
   }
} else {
   /* Client is not a mobile device, so handle as a regular browser */
   define('WAP_TYPE', TYPE_BROWSER);
}

/* Perform some action based on the detection */
If (WAP_TYPE != TYPE_BROWSER) {
   header("Location: http://mobile.example.com/index.php");
   exit;
}
?>

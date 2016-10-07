<?php
$secret_key = 'secret';

if (isset($_POST['xmldoc']) && isset($_POST['hmac'])) {
   $xmldata = base64_decode($_POST['xmldoc']);

   /* Generate the expected HMAC */
   $hmac_sha1hash = bin2hex(mhash(MHASH_SHA1, $xmldata, $secret_key));

   /* Verify message integrity and authenticity */
   if ($hmac_sha1hash == $_POST['hmac']) {
      $dom = new DOMDocument();
      $dom->loadXML($xmldata);
      print $dom->saveXML();
   } else {
      print 'DATA HAS BEEN ALTERED!!!';
   }
} else {
   print 'Missing Arguments';
}
?>

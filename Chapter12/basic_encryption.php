<?php
$secret_key = 'secret';

/* Encrypt Data */
$orderxml = file_get_contents('order.xml');

$dom = new DOMDocument();
$dom->loadXML($orderxml);
$order = $dom->documentElement;
foreach ($order->childNodes AS $node) {
   if ($node->nodeName == 'creditcard') {
      /* Get serialized creditcard node */
      $data = $dom->saveXML($node);

      /* Encrypt the serialized node */
      $td = mcrypt_module_open(MCRYPT_3DES, '',  MCRYPT_MODE_CBC, '');
      $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td),  MCRYPT_RAND);
      mcrypt_generic_init($td, $secret_key, $iv);
      $encrypted_data = rtrim(mcrypt_generic($td, $data));
      mcrypt_generic_deinit($td);
      mcrypt_module_close($td);

      /* Create a new replacement node containing encrpyted encrypted data */
      $encNode = $dom->createElement('encrypted', base64_encode($encrypted_data));
      $order->replaceChild($encNode, $node);

      /* Add the Initialization Vector as an attribute */
      $encNode->setAttribute('iv', base64_encode($iv));
      break;
   }
}

$enc_document = $dom->saveXML();
print $enc_document."\n\n";


/* De-Crypt Data */
$dom = new DOMDocument();
$dom->loadXML($enc_document);
$order = $dom->documentElement;
foreach ($order->childNodes AS $node) {
   if ($node->nodeName == 'encrypted') {
      /* Get Initialization Vector */
      $iv = base64_decode($node->getAttribute('iv'));

      /* Get data, and decode it */
      $data = base64_decode($node->nodeValue);

      /* Decrypt the data */
      $td = mcrypt_module_open(MCRYPT_3DES, '',  MCRYPT_MODE_CBC, '');
      mcrypt_generic_init($td, $secret_key, $iv);
      $decrypted_data = rtrim(mdecrypt_generic($td, $data));
      mcrypt_generic_deinit($td);
      mcrypt_module_close($td);

      $frag = $dom->createDocumentFragment();
      /* Functionality available in PHP 5.1 */
      $frag->appendXML($decrypted_data);

      /* Replacement node */
      $order->replaceChild($frag, $node);
      break;
   }
}

print $dom->saveXML();

?>
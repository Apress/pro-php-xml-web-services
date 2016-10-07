<?php
/* Address of remote server - Set these to the server and port where the 
   remote server script is located. */
$remote_protocol = 'tcp';
$remote_server = 'localhost';
$remote_server_port = 80;

/* The serialized packet. In this case, being an example, it is hard-coded 
   to request the record having an id of 5. */
$packet = wddx_serialize_value(array('recid'=>5));

/* Make POST request using sockets */
$remote_connect = $remote_protocol.'://'.$remote_server;
$sock = fsockopen($remote_connect, $remote_server_port, $errno, $errstr, 30);
if (!$sock) die("$errstr ($errno)\n");

/* Use var name packet for the POST */
$data = 'packet='.urlencode($packet);

fwrite($sock, "POST /wddxserver.php HTTP/1.0\r\n");
fwrite($sock, "Host: $remote_server\r\n");
fwrite($sock, "Content-type: application/x-www-form-urlencoded\r\n");
fwrite($sock, "Content-length: " . strlen($data) . "\r\n");
fwrite($sock, "Accept: */*\r\n");
fwrite($sock, "\r\n");
fwrite($sock, "$data\r\n");
fwrite($sock, "\r\n");

$headers = "";
while ($str = trim(fgets($sock, 4096)))
  $headers .= "$str\n";

$packet = "";
while (!feof($sock))
  $packet .= fgets($sock, 4096);
fclose($sock);
/* END POST Request */

/* Unserialize packet data, and output resulting data */
$arData = wddx_deserialize($packet);
if (is_array($arData)) {
   if (count($arData) > 0) {
      foreach ($arData AS $rownum=>$arRow) {
         foreach ($arRow AS $fieldname=>$fieldvalue) {
            print $fieldname.": ".$fieldvalue."\n";
         }
         print "\n";
      }
   } else {
      print "No Records Returned";
   }
} else {
   /* Some type of error happened */
   var_dump($arData);
}
?>

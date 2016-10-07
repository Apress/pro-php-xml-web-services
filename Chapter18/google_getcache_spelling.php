<?php
$key = "<insert license key here>";

try {
   $GoogleClient = new SoapClient('GoogleSearch.wsdl');

   /* Retrieve cached page for http://www.php.net/ and display first 500 chars */
   $cached = $GoogleClient->doGetCachedPage($key, 'http://www.php.net/');

   echo "Cache Retrieval Results: \n";
   if ($cached) {
      echo substr($cached, 0 , 500);
   } else {
      echo "No Cached Page Found";
   }
   echo "\n\n";

   /* Perform Spelling Suggestion */
   $orig = 'Pleeze Ceck my speling';
   $spelling = $GoogleClient->doSpellingSuggestion($key, $orig);

   echo "Spelling Suggection Results: \n";
   if ($spelling) {
      echo "   Origional Spelling: ".$orig."\n";
      echo "   Suggested Spelling: ".$spelling."\n";
   } else {
      echo "   No Suggested Alternatives Found\n";
   }
} catch (SOAPFault $e) {
   var_dump($e);
}
?>


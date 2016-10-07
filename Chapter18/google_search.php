<?php
/* Values to pass as parameters */
$key = "<insert license key here>";
$query = 'PHP 5 SOAP';
$startrec = 0;
$maxResults = 5;
$filter = FALSE;

try {
   $GoogleClient = new SoapClient('GoogleSearch.wsdl');

   $searchResults = $GoogleClient->doGoogleSearch($key, $query, $startrec, 
                                                  $maxResults, $filter, '', FALSE, 
                                                  '', '', '');
   if ($searchResults) {
      echo "Search Time: ".$searchResults->searchTime."\n\n";
      foreach ($searchResults->resultElements AS $result) {
         echo "Title: ".$result->title."\n";
         echo "URL: ".$result->URL."\n";
         echo "Summary: ".$result->snippet."\n";
         echo "Cache Size: ".$result->cachedSize."\n\n";
      }
   }
} catch (SOAPFault $e) {
   var_dump($e);
}
?>


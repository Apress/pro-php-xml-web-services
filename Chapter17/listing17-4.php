<?php
/* This is the application ID you registered with Yahoo */
$appid = "<your Yahoo! application id>";

/* URL to Web Search service */
$url = 'http://api.search.yahoo.com/WebSearchService/V1/webSearch';

/* The query is separate here because the terms must be encoded. */
$url .= '?query='.rawurlencode('php5 xml');

/* Complete the URL adding App ID, limit to 5 results and only English results */
$url .= "&appid=$appid&results=5&language=en";

$sxe = simplexml_load_file($url);

/* Check for number of results returned */
if ((int)$sxe['totalResultsReturned'] > 0) {
   /* Loop through each result and output title, url and modification date */
   foreach ($sxe->Result AS $result) {
      print 'Title: '.$result->Title."\n";
      print 'Url: '.$result->Url."\n";
      print 'Mod Date: '.date ('M d Y', (int)$result->ModificationDate)."\n\n";
   }
}
?>


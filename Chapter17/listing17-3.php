<?php
/* This is the application ID you registered with Yahoo */
$appid = "<your Yahoo! application id>";

/* URL to Web Search service */
$url = 'http://api.search.yahoo.com/WebSearchService/V1/webSearch';

/* The query is separate here because the terms must be encoded. */
$url .= '?query='.rawurlencode('php web services');

/* Complete the URL adding the App ID, limit to 1 result and only English results */
$url .= "&appid=$appid&results=1&language=en";

print file_get_contents($url);
?>


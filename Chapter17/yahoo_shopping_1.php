<?php
/* This is the application ID you registered with Yahoo */
$appid = "<your Yahoo! application id>";

/* URL to Product Search service */
$url = 'http://api.shopping.yahoo.com/ShoppingService/V1/productSearch';

/* The query is separate here because the terms must be encoded. */
$url .= '?query='.rawurlencode(' linksys ');

/* Complete the URL with App ID, limit to 1 result and start at second record */
$url .= "&appid=$appid&results=1&start=2";

print file_get_contents($url);
?>


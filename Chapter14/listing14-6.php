<?php
/* Require XML_RSS package */
require "XML/RSS.php";

/* Create RSS Parser */
$rss_parser = new XML_RSS("feed.rss");

/* Parse RSS Feed */
$rss_parser->parse();

/* Get and Display Channel Information */
$channel = $rss_parser->getChannelInfo();
echo 'Channel: '.$channel['title']."\n";
echo '   Link: '.$channel['link']."\n";
echo '   Description: '.$channel['description']."\n";
echo "-----------------------------------------\n\n";

/* Get and Display Items */
foreach ($rss_parser->getItems() as $value) {
   echo 'Item: '.$value['title']."\n";
   echo '   Link: '.$value['link']."\n\n";
}
?>


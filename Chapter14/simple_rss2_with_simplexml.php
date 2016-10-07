<?php
/* Define some RSS 2.0 and other compatible feeds */
$rssfeed = array();
/* The PHP RSS feeds are RSS version 0.93 */
$rssfeed['PHPGEN'] = 'http://news.php.net/group.php?group=php.general&format=rss';
/* The YAHOO RSS feeds are RSS version 2.0 */
$rssfeed['YAHOOTOPNEWS'] = 'http://rss.news.yahoo.com/rss/topstories';
/* The Planet PHP RSS feed is RSS version 0.91 */
$rssfeed['PLNTPHP'] = 'http://www.planet-php.org/rss/';
/* Apress new book list feed - RSS 2.0 */
$rssfeed['APRESSBOOKS'] = 'http://www.apress.com/rss/whatsnew.xml';


/* Loop through and process each defined feed */
foreach($rssfeed AS $name=>$url) {
   $rssParser = simplexml_load_file($url);

   /* Output the channel information */
   print $rssParser->channel->title."\n";
   print "   URL: ".$rssParser->channel->link."\n";
   print "   ".$rssParser->channel->description."\n\n";

   /* Iterate through the items, and output each one */
   foreach ($rssParser->channel->item AS $item) {
      print $item->title."\n";
      print $item->link."\n";
      print $item->pubDate."\n";
      print $item->description."\n\n";
   }
}
?>

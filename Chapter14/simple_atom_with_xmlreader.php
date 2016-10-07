<?php
$rssURL = 'http://www.planet-php.org/atom/';

function outputChannelInfo($channelTitle, $channelLink, $channelDesc)
{
   print "Title: $channelTitle\n";
   print "URL: $channelLink\n";
   print "Description: $channelDesc\n";
   print "-------------------------\n\n";
   $GLOBALS['printTitle'] = TRUE;
}

/* This function processes an entry element and its contents */
function processItem($rssParser)
{
   $content = "";
   $link = "";
   $title = "";
   $curnode = NULL;

   /* Keep processing the entry until the closing entry tag is encountered */
   while ($rssParser->read() && $rssParser->localName != "entry") {
      switch ($rssParser->nodeType) {
         case XMLREADER::ELEMENT:
            $curnode = NULL;
            switch ($rssParser->localName) {
               case "title":
               case "content":
                  $curnode = $rssParser->localName;
                  break;
               case "link":
                  $link = $rssParser->getAttribute('href');
            }
            break;
      case XMLREADER::TEXT:
      case XMLREADER::CDATA:
         if (! is_null($curnode)) {
            $$curnode = $rssParser->value;
         }
      }
   }
   print "  Title: $title\n";
   print "  URL: $link\n";
   print "  Description: $content\n\n";
}

/* Create a new XMLReader, and begin reading from the remote location */
$rssParser = new XMLReader();
$rssParser->open($rssURL);
$printTitle = FALSE;
$subtitle = "";
$link = "";
$description = "";
$curnode = NULL;
while ($rssParser->read()) {
   switch ($rssParser->nodeType) {
      case XMLREADER::ELEMENT:
         $curnode = NULL;
         switch ($rssParser->localName) {
            case "entry":
               if (! $printTitle) {
                  /* output the feed information before the first entry element */
                  outputChannelInfo($title, $link, $description);
               }
               /* If the entry is not empty, then process the contents */
               if (! $rssParser->isEmptyElement) {
                  processItem($rssParser);
               }
               break;
            case "title":
            case "subtitle":
               $curnode = $rssParser->localName;
               break;
            case "link":
               $link = $rssParser->getAttribute('href');
         }
         break;
      case XMLREADER::TEXT:
      case XMLREADER::CDATA:
         if (! is_null($curnode)) {
            $$curnode = $rssParser->value;
         }
   }
}
/* In the event the feed contained no entry elements, output the feed information */
if (! $printTitle) {
   outputChannelInfo($title, $link, $subtitle);
}
?>

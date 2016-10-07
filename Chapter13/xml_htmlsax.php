<?php
require_once('XML/XML_HTMLSax.php');

class myHTMLParser {
   function openHandler($parser, $name, $attrs) {
       print "<$name";
       foreach ($attrs AS $attname=>$attvalue) {
          print ' '.$attname.'="'.$attvalue.'"';
       }
       print ">\n";
   }

   function closeHandler($parser, $name) {
      print "</$name>";
   }

   function dataHandler($parser, $data) {
      print $data;
   }

   function piHandler($parser, $target, $data) {
      print "<?$target $data?>";
   }
}

/* Create parser and handler object */
$parser = new XML_HTMLSax();
$myHandler = new myHTMLParser();

/* Set the handler object */
$parser->set_object($myHandler);

/* Set options */
$parser->set_option('XML_OPTION_TRIM_DATA_NODES');

// Set the handlers
$parser->set_element_handler('openHandler','closeHandler');
$parser->set_data_handler('dataHandler');
$parser->set_pi_handler('piHandler');

/* Parse document by string */
$doc = file_get_contents("http://www.php.net/support.php");
$parser->parse($doc);
?>


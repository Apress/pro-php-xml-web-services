<?php
/* XML Data to be parsed */
$xml = '<root>
<element1 a="b">Hello World</element1>
<element2/>
</root>';

/* start element handler function */
function startElement($parser, $name, $attribs) {
   print "<$name";
   foreach ($attribs AS $attName=>$attValue) {
      print " $attName=".'"'.$attValue.'"';
   }
   print ">";
}

/* end element handler function */
function endElement($parser, $name) {
   print "</$name>";
}

/* cdata handler function */
function chandler($parser, $data) {
  print $data;
}

/* Create parser */
$xml_parser = xml_parser_create();

/* Set parser options */
xml_parser_set_option ($xml_parser, XML_OPTION_CASE_FOLDING, 0);

/* Register handlers */
xml_set_element_handler($xml_parser, "startElement", "endElement");
xml_set_character_data_handler ($xml_parser, "chandler");

/* Parse XML */
if (!xml_parse($xml_parser, $xml, 1)) {
   /* Gather Error information */
   die(sprintf("XML error: %s at line %d",
   xml_error_string(xml_get_error_code($xml_parser)),
   xml_get_current_line_number($xml_parser)));
}

/* Free parser */
xml_parser_free($xml_parser);
?>

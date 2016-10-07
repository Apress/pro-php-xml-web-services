<?php
class mySXE extends SimpleXMLElement {
   function nodeName() {
      $node = dom_import_simplexml($this);
      return $node->nodeName;
   }

   function addChildElement($name, $value=NULL) {
      $node = dom_import_simplexml($this);
      $child = $node->appendChild(new DOMElement($name, $value));
      return simplexml_import_dom($child, "mySXE");
   }
}

$books= new mySXE("<books/>");
/* Print the name of the document element */
print $books->nodeName()."\n";

/* Add book nodes to document */
$book = $books->addChildElement("book");
$book->addChildElement("title", "Title1");
$book->addChildElement("pages", 10);

$book = $books->addChildElement("book");
$book->addChildElement("title", "Title2");
$book->addChildElement("pages", 20);

/* Iterate through the books, and print titles */
foreach ($books->book AS $book) {
   print "Title: ".$book->title."\n";
}
?>

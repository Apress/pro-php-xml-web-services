<?php
$dom = DOMDocument::loadXML('<?xml version="1.0"?>
<!DOCTYPE courses [
   <!ELEMENT courses (course+)>
   <!ELEMENT course (title)>
   <!ELEMENT title (#PCDATA)>
]>
<courses>
   <course>
      <title>Algebra</title>
   </course>
</courses>');


$isvalid = $dom->validate();
var_dump($isvalid);

?>
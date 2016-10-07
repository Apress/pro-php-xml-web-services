<?php 
/* Create a new XMLWriter object, buffering output to memory for string access */
$writer = new XMLWriter();
$writer->openMemory();

/* Set indenting using three3 spaces, so output is formatted */
$writer->setIndent(TRUE);
$writer->setIndentString('   ');

/* Create the XML document */
$writer->startDocument();
$writer->startElement('root');
$writer->writeAttribute('att1', 'first');
$writer->writeElement('child1', 'some "random" content & text');
$writer->endElement();
$writer->endDocument();

/* Retrieve the current contents of the buffer */
$output = $writer->flush();

print $output;
?>


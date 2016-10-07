<?php 
$writer = new XMLWriter();
$writer->openMemory();
$writer->setIndent(TRUE);
$writer->startDocument();
$writer->startElement('root');

/* output buffer contents */
echo 'Data: '.$writer->flush(FALSE)."\n\n";

$writer->writeElement('child1', 'content');

/* output buffer contents, and clear buffer */
echo 'Data: '.$writer->flush()."\n\n";
$writer->endElement();
$writer->endDocument();

/* output buffer contents, and clear buffer */
echo 'Data: '.$writer->flush()."\n";
?>


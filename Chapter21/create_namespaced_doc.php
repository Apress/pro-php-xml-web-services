<?php 
$writer = new XMLWriter();
$writer->openMemory();
$writer->setIndent(TRUE);
$writer->startDocument();
$writer->startElement('root');

/* Create a namespaced Element */
$writer->startElementNS('ns1', 'child1', 'urn:ns1');
$writer->writeElementNS('ns2', 'child2', 'urn:ns2', 'child2 contents');
$writer->endDocument();

print $writer->flush();
?>


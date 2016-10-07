<?php 
/* Create a new writer, buffering output to memory for string access */
$writer = xmlwriter_open_memory();

/* Set indenting using three spaces, so output is formatted */
xmlwriter_set_indent($writer, TRUE);
xmlwriter_set_indent_string($writer, '   ');

/* Create the XML document */
xmlwriter_start_document($writer);
xmlwriter_start_element($writer, 'root');
xmlwriter_write_attribute($writer, 'att1', 'first');
xmlwriter_write_element($writer, 'child1', 'some "random" content & text');
xmlwriter_end_element($writer);
xmlwriter_end_document($writer);

/* Retrieve the current contents of the buffer */
print xmlwriter_flush($writer);
?>

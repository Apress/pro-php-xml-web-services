<?php
/* Filename for the XML data - must be read/writable by Web server */
$resource_filename = 'myresource.xml';

/* Generic error returned when problem encountered */
function get_error() {
   /* includes prologue as the value returned is sent directly to the client */
   return '<?xml version="1.0"?><error code="-1">Invalid Request</error>';
}

/* Load the XML document from file system, and make sure IDs are properly handled */
function getResource() {
   $doc = new DOMDocument();
   /* The following call uses the optional options parameter available 
     only in PHP 5.1 and higher */
   if ($doc->load($GLOBALS['resource_filename'], LIBXML_DTDATTR)) {
      return $doc;
   }
   return NULL;
}

/* Add a new p element using ID $id with the contents $value.
   If $id already exists in document do not add new content */
function addResource($id, $value) {
   if ($doc = getResource()) {
      if (($element = $doc->getElementById($id)) == NULL) {
         $element = $doc->documentElement->appendChild($doc->createElement('p',
                                                                           $value));
         $element->setAttribute('ID', $id);
         if ($doc->save($GLOBALS['resource_filename'])) {
            return $doc->saveXML();
         }
      }
   }
   return get_error();
}

/* Update or delete an existing p element based on $id.
   If $id does not exist in document return generic error */
function updateResource($id, $value, $isdel = FALSE) {
   if ($doc = getResource()) {
      if ($element = $doc->getElementById($id)) {
         if ($isdel) {
            $element->parentNode->removeChild($element);
         } else {
            while($element->firstChild) {
               $element->removeChild($element->firstChild);
            }
            $element->appendChild($doc->createTextNode($value));
         }
         if ($doc->save($GLOBALS['resource_filename'])) {
            return $doc->saveXML();
         }
      }
   }
   return get_error();
}

$action = '';

/* Set content type for XML */
header('Content-type: text/xml');

/* Determine action based on POST or GET */
if (isset($_POST) && isset($_POST['action']) && $_POST['action'] != 'doc.view') {
   $action = $_POST['action'];
} else if (isset($_GET) && isset($_GET['action']) &&
   $_GET['action'] == 'doc.view') {
   $action = 'doc.view';
}

/* Perform specified action as long as needed parameters have been passed */
if ($action == 'doc.add' && isset($_POST['id']) && isset($_POST['value'])) {
   echo addResource((int)$_POST['id'], $_POST['value']);
} else if ($action == 'doc.delete' && isset($_POST['id'])) {
   echo updateResource((int)$_POST['id'], NULL, TRUE);
} else if ($action == 'doc.update' && isset($_POST['id']) &&
   isset($_POST['value'])) {
   echo updateResource((int)$_POST['id'], $_POST['value']);
} else if ($action == 'doc.view') {
   /* The raw XML document could just be returned, 
      but here we ensure it is proper XML before sending.
      If it is not proper, it will not load into the DOMDocument */
   if ($doc = getResource()) {
      echo $doc->saveXML();
   } else {
      echo get_error();
   }
} else {
   echo get_error();
}
?>


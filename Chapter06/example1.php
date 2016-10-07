<?php
/* Path to PAD specification File */
$location = "http://www.padspec.org/pad_spec.xml";
/* Default PAD version - Version is read from Spec File */
$padVersion = "2.01";

function setPADInfo($doc, $version) {
   $node = $doc->documentElement;
   $node = $node->appendChild(new DOMElement("MASTER_PAD_VERSION_INFO"));
   $node->appendChild(new DOMElement("MASTER_PAD_VERSION", $version));
   $node->appendChild(new DOMElement("MASTER_PAD_EDITOR", "PHP"));
   $node->appendChild(new DOMElement("MASTER_PAD_INFO", "http://www.padspec.org/"));
}

function createField($doc, $node, $name) {
   if ($node == NULL) {
      $node = $doc->documentElement;
      if (! $node) {
         $node = $doc->appendChild(new DOMElement($name));
      }
      return $node;
   }
   foreach ($node->childNodes AS $child) {
      if ($child->nodeName == $name) {
         return $child;
      }
   }
   return $node->appendChild(new DOMElement($name));
}

if ($dom = DOMDocument::load($location)) {
   $padSet = FALSE;
   /* Create the new template output tree */
   $template = new DOMDocument("1.0", "UTF-8");

   $xpath = new DOMXPath($dom);
   /* Find PAD Version element */
   $verNode = $xpath->query("PAD_Spec_Version");
   if ($verNode && $verNode->length == 1) {
      /* Retrieve template version */
      $padVersion = $verNode->item(0)->nodeValue;
   }
   
   /* Query and loop through all elements named Field */
   $fields = $xpath->query("//Field");
   foreach ($fields as $field) {
      /* Retrieve element named Path within current Field element */
      $path = $xpath->query("Path", $field);

      if ($path->length == 1) {
         $node = NULL;

         /* Get value of Path element */
         $xmlnodes = trim($path->item(0)->nodeValue);

         /* Split Path by / separator */
         $arPath = explode("/", $xmlnodes);

         /* Loop through path to create specified element
            Parent elements are created as needed based on Path */
         foreach ($arPath AS $key=>$value) {
            /* IF PAD information not set and Field refers to
               PAD information then create it */
            if (! $padSet && $value == "MASTER_PAD_VERSION_INFO") {
               setPADInfo($template, $padVersion);
               $padSet = TRUE;
               break;
            }

            /* Path begins with parent so returned $node is 
               parent for next node within local foreach loop */
            $node=createField($template, $node, $value);
         }
      }
   }
   
   /* Save the generated XML Tree to padtemplate.xml file */
   $template->formatOutput = TRUE;
   print $template->save("padtemplate.xml");
}
?>

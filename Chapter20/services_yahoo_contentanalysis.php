<?php
require_once "Services/Yahoo/ContentAnalysis.php";

try {
   /* Instantiating object rather than static call to avoid E_STRICT message */
   $service_yahoo = new Services_Yahoo_ContentAnalysis();
   $search = $service_yahoo->factory("spellingSuggestion");

   $search->setQuery("PHP 5 XnL");

   $results = $search->submit();

   foreach ($results as $result) {
      echo $result . "\n";
   }
} catch (Services_Yahoo_Exception $e) {
   echo "Error: " . $e->getMessage() . "\n";
   foreach ($e->getErrors() as $error) {
      echo "   " . $error . "\n";
   }
}
?>


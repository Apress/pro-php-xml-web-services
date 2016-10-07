<?php
require_once "Services/Yahoo/Search.php";

try {
   /* Instantiating object rather than static call to avoid E_STRICT message */
   $service_yahoo = new Services_Yahoo_Search();
   $search = $service_yahoo->factory("web");

   $search->setQuery("php5 xml");
   $search->setResultNumber(5);

   $results = $search->submit();

   if ($results->getTotalResultsReturned() > 0) {
      foreach ($results AS $info) {
         print 'Title: '.$info['Title']."\n";
         print 'Url: '.$info['Url']."\n";
         print 'Mod Date: '.date ('M d Y', (int)$info['ModificationDate'])."\n\n";
      }
   }
} catch (Services_Yahoo_Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    foreach ($e->getErrors() as $error) {
        echo "   " . $error . "\n";
    }
}
?>


<?php
require_once "Services/Google.php";

/* Google license key */
$key = '<your Google license key>';

/* Create instance, passing license key as argument */
$google = new Services_Google($key);

$google->queryOptions['language'] = 'lang_fr';
$google->queryOptions['limit'] = 3; /* Set to make the search work */

$google->search("PHP XML");

foreach($google as $key => $result) {
   echo $result->title."\n";
}

?>

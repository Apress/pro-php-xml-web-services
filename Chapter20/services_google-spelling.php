<?php
require_once "Services/Google.php";

/* Google license key */
$key = '<your Google license key>';

/* Create instance, passing license key as argument */
$google = new Services_Google($key);

/* Output the resulting suggested spelling */
echo $google->spellingSuggestion('PHP xnl')."\n";
?>


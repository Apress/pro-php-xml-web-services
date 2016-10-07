<?php
require_once 'Services/Technorati.php';

$key = '<your API key here>';

/* Instantiating object rather than static call to avoid E_STRICT message */
$technorati = new Services_Technorati($key);

/* Check the stats on our API Key usage */
$keyinfo = $technorati->keyInfo();
var_dump($keyinfo);

/* Set limit of results to a max of 2 */
$options = array('limit'=>2);

$cosmos = $technorati->cosmos('www.php.net', $options);
var_dump($cosmos);

$search = $technorati->search('PHP 5 XML', $options);
var_dump($search);

$outbound = $technorati->outbound('www.planet-php.org');
var_dump($outbound);

$blogInfo = $technorati->blogInfo('www.planet-php.org');
var_dump($blogInfo);

$topTags = $technorati->topTags($options);
var_dump($topTags);

$options = array('limit'=>3);
$blogPostTags = $technorati->blogPostTags('http://blog.bitflux.ch/', $options);
var_dump($blogPostTags);
?>


<?php
require_once 'Services/AmazonECS4.php';

/* Your Amazon access key */
$accesskey = '<insert your Access Key ID>';

/* Create the object without an aAssociates ID */
$amazon = new Services_AmazonECS4($accesskey);

$options = array();
$options['Keywords'] = 'linksys';

/* array()Services_AmazonECS4::ItemSearch(string SearchIndex, [array() $options]) */
$result = $amazon->ItemSearch('Electronics', $options);

var_dump($result);
?>


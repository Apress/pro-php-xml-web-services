<?php
require_once 'Services/Delicious.php';

$userid = '<your del.icio.us userid>';
$password = '<your del.icio.us password>';

$svcDelicious = new Services_Delicious($userid, $password);

$posts = $svcDelicious->getRecentPosts('php', 25);
var_dump($posts);
?>


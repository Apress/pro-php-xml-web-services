<?php
require_once 'XML/Tree.php';

$tree = new XML_Tree();

/* Create document element, and add lang attribute */
$book = $tree->addRoot('book');
$book->setAttribute("lang", "en");

/* create and add bookinfo element */
$binfo = $book->addChild('bookinfo');

/* create title element, and add to tree */
$title = new XML_Tree_Node("title", "Sample Book");
$binfo->addChild($title);

/* Create author element and its children */
$author = $binfo->addChild("author");
$fname = $author->addChild("firstname");
$fname->setContent("Rob");
$author->addChild("surname", "Richards");

/* Create chapter element and id attribute, and add to tree */
$catts = array("id"=>"navigation");
$chapter = new XML_Tree_node("chapter", NULL, $catts);
$book->addChild($chapter);

/* Create and add title and para elements */
$chapter->addChild("title", "Navigating The Tree");
$strContent = "This chapter explains how to navigate a tree";
$chapter->addChild("para", $strContent);

/* Print the resulting XML document */
print $tree->dump();
?>

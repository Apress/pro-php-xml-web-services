<?php
/* Create SDO_DAS_XML object */
$xmldas = SDO_DAS_XML::create("sdoschema.xsd");

/* Load the XML document */
$xmldo = $xmldas->loadFromFile("courses.xml");

$courses = $xmldo->getRootDataObject();

/********************
 *   Reading Data   *
 ********************/

/* Output the courses */
foreach ($courses->course AS $course) {
   print "Title: ".$course->title."\n";
   print "Course ID: ".$course->cid."\n\n";
}

print $courses->course[1]->title."\n";

try {
   print $courses->course[1]->notinschema."\n";
} catch (Exception $e) {
  var_dump($e);
}

/********************
 *   Writing Data   *
 ********************/

$courses->course[1]->title = 'Intro to French';

$course = $courses->createDataObject('course');

$course->cid = 'c3';
$course->title = 'French II';
$course->description = 'Intermediate French';
$course->credits = '3.0';

$xmldas->saveDocumentToFile($xmldo, 'courses.xml');

print file_get_contents('courses.xml');

?>

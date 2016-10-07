<?php
/* Set the xsl namespace url for re-use */
$xslns = "http://www.w3.org/1999/XSL/Transform";

/* Create the document for the style sheet */
$stylesheet = new domDocument;

/* Create the stylesheet node */
$root = $stylesheet->createElementNS($xslns, "xsl:stylesheet");
$stylesheet->appendChild($root);
$root->setAttribute("version", "1.0");

/* Create the output method node */
$output = $stylesheet->createElementNS($xslns, "xsl:output");
$output->setAttribute("method", "html");
$root->appendChild($output);


/* Create the main template which matches on the document element */
$template= $stylesheet->createElementNS($xslns, "xsl:template");
$template->setAttribute("match", "/");
$root->appendChild($template);

$html = $template->appendChild(new domElement("html"));
$body = $html->appendChild(new domElement("body"));

/* Call another template matching on /sites/site elements */
$subtemplate = $stylesheet->createElementNS($xslns, "xsl:apply-templates");
$body->appendChild($subtemplate);
$subtemplate->setAttribute("select", "/sites/site");

/* Create the template for matching /sites/site elements */
$template= $stylesheet->createElementNS($xslns, "xsl:template");
$template->setAttribute("match", "/sites/site");
$root->appendChild($template);

$paragraph = $template->appendChild(new domElement("p"));

/* Get the value of the name */
$xslvalueof = $stylesheet->createElementNS($xslns, "xsl:value-of");
$xslvalueof->setAttribute("select", "./name");
$paragraph->appendChild($xslvalueof);

/* Add a colon in the final output separating name and url */
$paragraph->appendChild(new domText(" : "));

/* Get the value of the url */
$xslvalueof = $stylesheet->createElementNS($xslns, "xsl:value-of");
$xslvalueof->setAttribute("select", "./url");
$paragraph->appendChild($xslvalueof);

/* Output the stylesheet using formatting */
$stylesheet->formatOutput = TRUE;
print $stylesheet->saveXML();
?>

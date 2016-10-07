<?php
/* Begin Code from example2.php in Chapter 6 to create style sheet */
$xslns = "http://www.w3.org/1999/XSL/Transform";
$stylesheet = new domDocument;
$root = $stylesheet->createElementNS($xslns, "xsl:stylesheet");
$stylesheet->appendChild($root);
$root->setAttribute("version", "1.0");
$output = $stylesheet->createElementNS($xslns, "xsl:output");
$output->setAttribute("method", "html");
$root->appendChild($output);
$template= $stylesheet->createElementNS($xslns, "xsl:template");
$template->setAttribute("match", "/");
$root->appendChild($template);
$html = $template->appendChild(new domElement("html"));
$body = $html->appendChild(new domElement("body"));
$subtemplate = $stylesheet->createElementNS($xslns, "xsl:apply-templates");
$body->appendChild($subtemplate);
$subtemplate->setAttribute("select", "/sites/site");
$template= $stylesheet->createElementNS($xslns, "xsl:template");
$template->setAttribute("match", "/sites/site");
$root->appendChild($template);
$paragraph = $template->appendChild(new domElement("p"));
$xslvalueof = $stylesheet->createElementNS($xslns, "xsl:value-of");
$xslvalueof->setAttribute("select", "./name");
$paragraph->appendChild($xslvalueof);
$paragraph->appendChild(new domText(" : "));
$xslvalueof = $stylesheet->createElementNS($xslns, "xsl:value-of");
$xslvalueof->setAttribute("select", "./url");
$paragraph->appendChild($xslvalueof);
/* END Code from example2.php in Chapter 6 to create style sheet */


$xml = <<<EOF
<sites>
    <site>
        <name>Libxml</name>
        <url>http://www.xmlsoft.org</url>
    </site>
    <site>
        <name>W3C DOM Level 3 Specifications</name>
        <url>www.w3.org/TR/DOM-Level-3-Core/</url>
    </site>
</sites>
EOF;

$dom = new DOMDocument();
$dom->loadXML($xml);

$proc = new xsltprocessor();

$proc->importStylesheet($stylesheet);

print $proc->transformToXML($dom);
?>
<?xml version="1.0"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
                xmlns:php="http://php.net/xsl" version="1.0">
  <xsl:output method="xml" indent="yes" />

   <xsl:template match="/">
      <xsl:element name="channels">
         <xsl:apply-templates select="/sites/site"/>
      </xsl:element>
   </xsl:template>

   <xsl:template match="site">
      <xsl:variable name="siteurl" select="url" />
      <xsl:apply-templates select="php:functionString('retrieveRSS', 
                                                      $siteurl)/channel">
         <xsl:with-param name="sitename" select="name" />
      </xsl:apply-templates>
   </xsl:template>

   <xsl:template match="channel">
      <xsl:element name="channel">
         <xsl:element name="title">
            <xsl:copy-of select="$sitename" />
         </xsl:element>
         <xsl:copy-of select="link" />
         <xsl:apply-templates select="item"/>
      </xsl:element>
   </xsl:template>

   <xsl:template match="item">
      <xsl:element name="item">
         <xsl:copy-of select="title" />
         <xsl:copy-of select="link" />
         <xsl:copy-of select="pubDate" />
         <xsl:element name="timestamp">
            <xsl:value-of select="php:functionString('strtotime', pubDate)" />
         </xsl:element>
      </xsl:element>
   </xsl:template>

</xsl:stylesheet>

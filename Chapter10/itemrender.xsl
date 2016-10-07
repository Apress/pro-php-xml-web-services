<?xml version="1.0"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
   <xsl:param name="sortparam" select="datetime" />
   <xsl:output method="html"/>

   <xsl:template match="/">
      <table>
         <xsl:apply-templates select="//channel/item">
            <xsl:sort select="../title[$sortparam='channel']" order="ascending" />
            <xsl:sort select="./title[$sortparam='title']" order="ascending"
                      case-order="lower-first" />
            <xsl:sort select="./timestamp" order="descending" />
         </xsl:apply-templates>
      </table>
   </xsl:template>

   <xsl:template match="channel">
      <xsl:element name="channel">
         <xsl:copy-of select="title" />
         <xsl:copy-of select="link" />
         <xsl:apply-templates select="item"/>
      </xsl:element>
   </xsl:template>

   <xsl:template match="item">
      <tr>
         <td colspan="3">
            <a>
               <xsl:attribute name="href">
                  <xsl:value-of select="link" />
               </xsl:attribute>
               <xsl:value-of select="title"/>
            </a>
         </td>
      </tr><tr>
         <!-- Insert some non breaking spaces. 
              Rather than add DTD for nbsp numeric codes are used instead. -->
         <td>&#160;&#160;&#160;&#160;&#160;</td>
         <td>Channel: 
            <a>
               <xsl:attribute name="href">
                  <xsl:value-of select="../link" />
               </xsl:attribute>
               <xsl:value-of select="../title"/>
            </a>
         </td>
         <td>Published: <xsl:copy-of select="pubDate" /></td>
      </tr>
   </xsl:template>

</xsl:stylesheet>

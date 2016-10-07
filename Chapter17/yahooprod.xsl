<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns:prod="urn:yahoo:prods" version="1.0">
<!-- urn:yahoo:prods namespace added with prefix prod matching the default namespace
     of result document from the Yahoo Product Search Service -->
   <xsl:output method="html"/>

   <xsl:template match="prod:Thumbnail">
      <br />
      <img>
         <xsl:attribute name="src">
            <xsl:value-of select="prod:Url"/>
         </xsl:attribute>
         <xsl:attribute name="height">
            <xsl:value-of select="prod:Height"/>
         </xsl:attribute>
         <xsl:attribute name="width">
            <xsl:value-of select="prod:Width"/>
         </xsl:attribute></img>
   </xsl:template>

   <xsl:template match="prod:Catalog">
      <p><b>Catalog</b><br />
      <xsl:apply-templates select="prod:Thumbnail"/><br />
      Product: <a>
         <xsl:attribute name="href">
            <xsl:value-of select="prod:Url"/>
         </xsl:attribute>
         <xsl:value-of select="prod:ProductName"/>
      </a><br />
      Price Range: <xsl:value-of select="prod:PriceFrom"/> - 
                   <xsl:value-of select="prod:PriceTo"/>
      </p>
   </xsl:template>
   
   <xsl:template match="prod:Offer">
      <p><b>Offer</b><br />
      Product: <a>
         <xsl:attribute name="href">
            <xsl:value-of select="prod:Url"/>
         </xsl:attribute>
         <xsl:value-of select="prod:ProductName"/>
      </a><br />
      Merchant: <xsl:value-of select="prod:Merchant/prod:Name"/><br />
      Price: <xsl:value-of select="prod:Price"/>
      </p>
   </xsl:template>

   <!-- Entry point -->
   <xsl:template match="/">
      <html>
         <body>
            <!-- Apply templates on document pulled from url defined 
                 in passed in DOMDocument.
            We are only interested in selecting the Result elements -->
            <xsl:apply-templates
                 select="document(./url)/prod:ResultSet/prod:Result"/>
         </body>
      </html>
   </xsl:template>
</xsl:stylesheet>


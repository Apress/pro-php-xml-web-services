<?php
/* The configuration file storing the sites to pull RSS data from.
   It must be readable by the Web server */
$site_config = 'siteconfig.xml';

/* Template used to render the cached RSS */
$render_xsl = 'itemrender.xsl';

/* This file stores the summarize RSS information.
   It must be read/writable by the Web server */
$rsscache = 'rsscache.xml';

/* Template used to build the RSS cache */
$rsscache_xsl = 'rsscache.xsl';

/* function called from the $rsscache_xsl template */
function retrieveRSS($url) {
   $doc = new DOMDocument();
   if ($doc->load($url)) {
      return $doc->documentElement;
   }
   return 0;
}

/* Generic function to transform XML data using XSL extension */
function genericProcess($xmlfile, $xslfile, $params=NULL, $outputfile=NULL) {
   $doc = new DOMDocument();
   $doc->load($xmlfile);

   $xsl = new DOMDocument();
   $xsl->load($xslfile);

   $proc = new xsltprocessor();
   $proc->registerPHPFunctions();
   $proc->importStylesheet($xsl);

   if (is_array($params)) {
      foreach ($params AS $key=>$value) {
         $proc->setParameter(NULL, $key, $value);
      }
   }

   if ($outputfile == NULL) {
      if ($outdoc = $proc->transformToDoc($doc)) {
         $outdoc->formatOutput = TRUE;
         return $outdoc->saveXML();
      }
   } else {
      return $proc->transformToURI($doc, $outputfile); 
   }
}

/* Build the RSS Cache file */
function buildCache() {
   genericProcess($GLOBALS['site_config'], $GLOBALS['rsscache_xsl'], NULL,
                  $GLOBALS['rsscache']);
}

$xslparams = NULL;
$cacheBuilt = FALSE;
$sorted = NULL;

/* Perform actions based on HTMLl form submissions */
if (isset($_POST['buildcache']) && ! empty($_POST['buildcache'])) {
   buildCache();
} elseif (isset($_POST['sortit']) && ! empty($_POST['sortit']) &&
          isset($_POST['sort']) && ! empty($_POST['sort'])) {
   $sorted = $_POST['sort'];
   $xslparams = array('sortparam'=>$_POST['sort']);
}

if (file_exists($rsscache)) {
   $cacheBuilt = TRUE;
}

?>
<html>
   <body>
      <b>RSS Items:</b><br>
      <form method="post">
      <table>
         <tr>
            <td><input type="submit" name="buildcache" value="Update Cache">
                &nbsp;&nbsp;&nbsp;&nbsp;</td>
<?php if ($cacheBuilt) { ?>
            <td>
               <select name="sort">
                  <option value="">Published Date</option>
                  <option value="channel" <?php if ($sorted == "channel") 
                                               print "selected"; ?>>Channel</option>
                  <option value="title" <?php if ($sorted == "title") 
                                            print "selected"; ?>>Item Title</option>
               </select>&nbsp;&nbsp;
               <input type="submit" name="sortit" value="Sort">
            </td>
<?php } ?>
         </tr>
      </table>
      </form><br><br>
      <?php
      if ($cacheBuilt) {
         print genericProcess($rsscache, $render_xsl, $xslparams);
      } else {
         print "Cache not built. Please update Cache.";
      } ?>
   </body>
</html>

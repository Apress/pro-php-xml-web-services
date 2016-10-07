<?php
/* Generate SHA1 hash */
$sha1hash = sha1_file('xmlsec.xml');

/* Generate MD5 hash */
$md5hash = md5_file('xmlsec.xml');

/* Print resulting hashes */
print $sha1hash."\n";
print $md5hash."\n";


/* Create and Verify Integrity */
if (sha1_file('xmlsec.xml') == $sha1hash) {
   /* Open and modify the XML document */
   $dom = new DOMDocument();
   $dom->load('xmlsec.xml');
   $root = $dom->documentElement;
   $root->appendChild($dom->createElement('data', 'More data'));
   $dom->save('xmlsec.xml');
   
   /* Create and store a new hash for the next time document is accessed */
   $sha1hash = sha1_file('xmlsec.xml');
   print 'New Hash: '.$sha1hash."\n";
} else {
   print 'File has been altered!';
}
?>
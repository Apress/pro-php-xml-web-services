<?php
header('Content-type: application/xhtml+xml');
echo '<?xml version="1.0"?>';
?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN"   
                      "http://www.wapforum.org/DTD/xhtml-mobile10.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">  
<head>
   <title>XHTML Mobile Example</title>
</head>
<body>
   <p>Select a category from the pull-down or an anchor link.</p>
   <form action="catselect.php" method="POST">
   Select a category: 
      <select name="category">
         <option value="1">Audio &amp; Video</option>
         <option value="2">Camera &amp; Photo</option>
         <option value="3">Computers</option>
      </select>
      <input type="submit" value="Go" />
   </form>
   <br /><br />
   <a href="catsel.php?category=4&amp;subcat=1">Electronics/Phones</a>
   <br /><br />
</body>
</html>

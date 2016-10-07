<?php include('pearxmlrpclib.php'); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
                      "http://www.w3.org/TR/html4/loose.dtd">
<html>
<body>
<p><b>PEAR Package Information</b></p>

<form name="pear_search" method="post">
   Package Name: <input type="text" name="pkg_name" 
                        value="<?php echo $cur_package; ?>">
    &nbsp;&nbsp;
   <input type="submit" name="submit" value="Search">
</form>

<?php
/* If we have results and it is an array, then output the key/value pairs */
if ($results && is_array($results)) {
?>
<table border="0">
   <tr>
      <th colspan="2">Package Information for <?php echo $cur_package; ?></th>
   </tr>
<?php
   foreach($results AS $key=>$value) {
      /* Skip output of empty and complex values */
      if (empty($value) || is_array($value))
         continue;
?>
   <tr>
      <td align="right"><?php echo $key; ?>:</td>
      <td align="left"><?php echo $value; ?></td>
   </tr>
<?php } /* End foreach */
} /* End if */
?>
</table>
</body>
</html>


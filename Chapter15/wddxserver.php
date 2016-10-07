<?php
/* If the database does not exist, then create it and populate it with some data */
if (! file_exists('wddxdb')) {
   if ($dbhandle = sqlite_open('wddxdb', 0666)) {
      sqlite_query($dbhandle, 'CREATE TABLE wddx (id int, name varchar(15))');
      for ($x=1; $x< 11; $x++) {
         sqlite_query($dbhandle, 
                      "INSERT INTO wddx VALUES (".$x.", 'Data Num: ".$x."')");
      }
      sqlite_close($dbhandle);
   }
}

/* Function to retrieve data from database and return the results in a 
   serialized WDDX packet. Upon failure return a NULL value in the packet */
function getDBData($recid) {
   if (is_numeric($recid) && $dbhandle = sqlite_open('wddxdb')) {

      $query = sqlite_query($dbhandle,
                            'SELECT id, name FROM wddx where id='.$recid);
      $result = sqlite_fetch_all($query, SQLITE_ASSOC);
      return wddx_serialize_value($result);
   } else {
      return wddx_serialize_value(NULL);
   }
}

/* Requests are only accepted from a POST with the data set in the 
   packet variable. */
if (isset($_POST['packet'])) {
   $wddx_packet = $_POST['packet'];
   /* retrieve data based on the requested recid, and return resulting packet */
   if ($wddx_packet && $arData = wddx_deserialize($wddx_packet)) {
      if (is_array($arData) && array_key_exists('recid', $arData)) {
         print getDBData((int)$arData['recid']);
         exit;
      }
   }
}

/* On bad requests send a NULL value in the packet */
print wddx_serialize_value(NULL);
?>


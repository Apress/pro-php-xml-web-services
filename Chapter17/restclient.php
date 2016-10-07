<?php
/* Define remote server and path to script on remote server */
$server = 'http://localhost';
$path = '/restserver.php';

/* Function to make POST requests using PHP streams */
function make_post_request($url, $data) {
   $opts = array(
      'http'=>array('method'=>"POST", 'content'=>$data, 
      'header'=>"Content-Type: application/x-www-form-urlencoded\r\n")
   );

   $context = stream_context_create($opts);
   return file_get_contents($url, FALSE, $context);
}

/* Example Get Resource */
$url = $server.$path.'?action=doc.view';

$dom = new DOMDocument();
$dom->load($url);
print $dom->saveXML()."\n";

/* Example Add Resource */
/* Select a new ID and request a new p tag be added */
$id = 5;
$value = 'Some Text';
$data = 'action=doc.add&id='.$id.'&value='.rawurlencode($value);
$url = $server.$path;
echo "Results After adding New Item:\n";
print make_post_request($url, $data)."\n";

/* Example Update Resource */
$value = 'New Modified Text';
$data = 'action=doc.update&id='.$id.'&value='.rawurlencode($value);
$url = $server.$path;
echo "Results After Editing Existing Item:\n";
print make_post_request($url, $data)."\n";

/* Example Delete Resource */
$data = 'action=doc.delete&id='.$id;
$url = $server.$path;
echo "Results After Deleting Item:\n";
print make_post_request($url, $data)."\n";
?>


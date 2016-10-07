<?php

function call_using_sockets($remote_server, $remote_server_port,
                            $remote_path, $request) {
/* Code for this function found in Listing 16-1. */
}

/* Initialize variables */
$results = NULL;
$cur_package = '';
$pear_server = 'pear.php.net';
$pear_server_port = 80;
$pear_rpc_page = '/xmlrpc.php';

/* If form posted, then request the package information from PEAR
   Invalid submissions are not being checked in this example */
if (! empty($_POST['submit'])) {
   $cur_package = (string)$_POST['pkg_name'];
   $request_xml = xmlrpc_encode_request('package.info', array($cur_package));

   /* call_using_curl may be substituted here */
   $retval = call_using_sockets($pear_server, $pear_server_port, 
                                $pear_rpc_page, $request_xml);
   $results = xmlrpc_decode($retval);
}
?>

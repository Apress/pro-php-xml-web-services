<?php
/* UserID and Password */
$userID = <userID for registry>;
$cred = <password for registry>;

/* Create The Client to the publishing service and authenticate */
try {
   $sPublish = new SoapClient('publish_v2.wsdl', array('trace' => 1));
   $authToken = $sPublish->get_authToken(array("generic"=>"2.0", "userID"=>$userID,
                                               "cred"=>$cred));
   $authInfo = $authToken->authInfo;
} catch (SoapFault $e) {
   var_dump($e);
   exit;
}

try {
   /* Connect to the inquiry service */
   $sClient = new SoapClient('inquire_v2.wsdl');
   /* Retrieve the businessDetail record for the entity */
   $bizDetail = $sClient->get_businessDetail(array("generic"=>"2.0",
                          "businessKey"=>" e1a5c990-6e3d-11da-c5d9-0002a58b4eaf"));

   /* Get the businessEntity from the response */
   $businessEntity = $bizDetail->businessEntity;
 
   /* Change the name of the businessEntity */
   $businessEntity->name->_ = 'Acme XML Inc.';

   /* Save the updated businessEntity using the publisher service */
   $bizDetail = $sPublish->save_business(array("generic"=>"2.0", 
                                               "authInfo"=>$authInfo,
                                               "businessEntity"=>$businessEntity));
} catch (SoapFault $e) {
   var_dump($e);
}
?>

<?php

/* UserID and Password */
$userID = <userID for registry>;
$cred = <password for registry>;

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
   /* Create the businessEntity structure */
   $businessEntity = array("businessKey"=>"", 
                           "name"=>'Acme Inc.', 
                           "description"=>"Acme Inc's Telephone Directory");

   /* Save the businessEntity structure */
   $bizDetail = $sPublish->save_business(array("generic"=>"2.0", 
                                               "authInfo"=>$authInfo,
                                               "businessEntity"=>$businessEntity));
   var_dump($bizDetail);

} catch (SoapFault $e) {
   var_dump($e);
   exit;
}

$businessKey = $bizDetail->businessEntity->businessKey;

try {
   /* Create the businessService structure */
   $businessService = array("name"=>"Acme Inc's Telephone Directory", 
                            "description"=>"Acme Inc's Telephone Directory Web Serivce",
                            "businessKey"=>$businessKey,
                            "serviceKey"=>"");

   /* Save the businessEntity structure */
   $svcDetail = $sPublish->save_service(array("generic"=>"2.0", 
                                              "authInfo"=>$authInfo, 
                                              "businessService"=>$businessService));
   var_dump($svcDetail);

} catch (SoapFault $e) {
   var_dump($e);
   exit;
}

$serviceKey = $svcDetail->businessService->serviceKey;


try {
   /* Create the tModelInstanceDetail structure */
   $tModelInstanceDetails = array("tModelInstanceInfo"=>
                   array("tModelKey"=>"UUID:68DE9E80-AD09-469D-8A37-088422BFBC36"));

   /* Create the bindingTemplate structure */	
   $bindingTemplate = array("description"=>"Acme Inc's Telephone Directory Web Serivce",
      "accessPoint"=>array("_"=>"http://localhost:8080/TelephoneDirectoryWebProject/webApplication/wsdl/Directory-service.wsdl","URLType"=>"http"),
      "tModelInstanceDetails"=>$tModelInstanceDetails, 
      "serviceKey"=>$serviceKey,
      "bindingKey"=>"");

   /* Save the bindingTemplate structure */
   $bindDetl = $sPublish->save_binding(array("generic"=>"2.0",
                                             "authInfo"=>$authInfo, 
                                             "bindingTemplate"=>$bindingTemplate));
   var_dump($bindDetl);

} catch (SoapFault $e) {
   var_dump($e);
   exit;
}
?>

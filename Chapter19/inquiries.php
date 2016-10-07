<?php
function outputBusiness($bizInfo) {
   print "Name: ".$bizInfo->name->_."\n";
   print "Business Key: ".$bizInfo->businessKey."\n";
   if (isset($bizInfo->description)) {
      print "Desc: ".$bizInfo->description->_."\n";
   }

   /* Output serviceInfo information only if one serviceInfo element is present */
   if (isset($bizInfo->serviceInfos->serviceInfo) && 
       ! is_array($bizInfo->serviceInfos->serviceInfo)) {
      print "Service Name: ".$bizInfo->serviceInfos->serviceInfo->name->_."\n";
      print "Service Key: ".$bizInfo->serviceInfos->serviceInfo->serviceKey."\n";
   }
   print "\n";
}

$sClient = new SoapClient('inquire_v2.wsdl');

try {
   $bizList = $sClient->find_business(array("generic"=>"2.0", "name"=>"Acme%",
                                  "maxRows"=>5, 
                                  "findQualifiers"=>"sortByNameAsc,sortByDateAsc"));
   if ($bizInfos = $bizList->businessInfos) {
      if (isset($bizInfos->businessInfo)) {
         if (is_array($bizInfos->businessInfo)) {
            foreach($bizInfos->businessInfo AS $bizInfo) {
               outputBusiness($bizInfo);
            }
         } else {
            outputBusiness($bizInfos->businessInfo);
         }
      } else {
         print "No Records Found";
      }
   }
} catch (SoapFault $e) {
   var_dump($e);
}


<?php
function outputTemplate($bindingTemplate) {
   if (isset($bindingTemplate->description)) {
      print "Desc: ".$bindingTemplate->description->_."\n";
   }
   if (isset($bindingTemplate->accessPoint)) {
      print "Access Point: ".$bindingTemplate->accessPoint->_."\n";
      print "Access Point Type: ".$bindingTemplate->accessPoint->URLType."\n";
   } else {
      print "Hosting Redirector Binding Key: ".
            $bindingTemplate->hostingRedirector->bindingKey."\n";
   }
   if (isset($bindingTemplate->tModelInstanceDetails)&& 
       isset($bindingTemplate->tModelInstanceDetails->tModelInstanceInfo)) {
      $modelDetails = $bindingTemplate->tModelInstanceDetails;
      print "tModel Key: ".$modelDetails->tModelInstanceInfo->tModelKey."\n";
   }
   print "\n";
}

try {
   $sClient = new SoapClient('inquire_v2.wsdl');
   $serviceDetail = $sClient->get_serviceDetail(array("generic"=>"2.0",
                            "serviceKey"=>"639d6ce0-52c4-11da-90ff-0002a58b4eaf"));
   if (isset($serviceDetail->businessService)) {
      $bizService = $serviceDetail->businessService;
      if (isset($bizService->bindingTemplates)) {
         if (isset($bizService->bindingTemplates->bindingTemplate)) {
            if (is_array($bizService->bindingTemplates->bindingTemplate)) {
               $bindingTemplates = $bizService->bindingTemplates;
               foreach ($bindingTemplates->bindingTemplate AS $bindingTemplate) {
                  outputTemplate($bindingTemplate);
               }
            } else {
               outputTemplate($bizService->bindingTemplates->bindingTemplate);
            }
         } else {
            print "No bindingTemplate elements found\n";
         }
      } else {
         print "bindingTemplates element not found\n";
      }
   }
} catch (SoapFault $e) {
   var_dump($e);
}
?>

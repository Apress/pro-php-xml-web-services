<?php
/* System status - TRUE indicates normal operation / 
                   FALSE indicates down for maintenance */
$SYS_STATUS = TRUE;

function getPeopleByFirstLastName($getPeopleByFirstLastName) {
   /* If system is down throw SOAP fault */
   if (isset($GLOBALS['SYS_STATUS']) && $GLOBALS['SYS_STATUS'] == FALSE) {
      $details = array("SysMessage"=>"Sys Error", "RetryInMinutes"=>60);
      throw new SoapFault("SYSError", "System Unavailable", "urn:ExampleAPI",
                          $details, "sysmaint");
   }

   /* Initialize the Person Records */
   $people = array(array('id'=>1, 'firstName'=>'John', 'lastName'=>'Smith'), 
                   array('id'=>2, 'firstName'=>'Jane', 'lastName'=>'Doe'));

   $firstSearch = str_replace('*', '([a-z]*)', $getPeopleByFirstLastName->first);
   $lastSearch = str_replace('*', '([a-z]*)', $getPeopleByFirstLastName->last);
   
   $retval = array();
   
   foreach($people AS $person) {
      /* Check if match on first name */
      if (empty($firstSearch) || preg_match('/^'.$firstSearch.'$/i',
                                            $person['firstName'])) 
      {
         /* Check if match on last name */
         if (empty($lastSearch) || preg_match('/^'.$lastSearch.'$/i',
                                              $person['lastName']))
         {
            /* Add matching records as an encoded SoapVar */
            $retval[] = new SoapVar($person, SOAP_ENC_ARRAY, "Person",
                                    "urn:ExampleAPI");
         }
      }
   }

   return $retval;  
}

/* Create the server using WSDL and specify the actor URI */
$sServer = new SoapServer("exampleapi.wsdl", array('actor'=>'urn:ExampleAPI'));

/* Register the getPeopleByFirstLastName function */
$sServer->addFunction("getPeopleByFirstLastName");

/* Handle the SOAP request */
$sServer->handle();
?>


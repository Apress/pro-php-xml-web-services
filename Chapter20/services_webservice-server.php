<?php
include_once('Services/Webservice.php');

/* Generic function to provide search and record retrieval functionality */
function people_search($id, $lastName=NULL) {
   $arPeople = array(1=>array('lastName'=>'Doe', 'firstName'=>'Jane'),
                     2=>array('lastName'=>'Doe', 'firstName'=>'John'),
                     3=>array('lastName'=>'Smith', 'firstName'=>'Joe'));
 
   if (is_null($id)) {
      if (! empty($lastName)) {
         $retval = array();
         foreach ($arPeople AS $key=>$value) {
            if (stripos($value['lastName'], $lastName) !== false) {
               $retval[] = $key;
            }
         }
         return $retval;
      }
   } else if (is_numeric($id) && array_key_exists($id, $arPeople)) {
      return $arPeople[$id];
   }
   return NULL;
}

/* A specific record for a Person */
class Person
{
    public function __construct($id)
    {
        $retval =  people_search($id);
        if (! is_null($retval)) {
            $this->id = $id;
            $this->firstName = $retval['firstName'];
            $this->lastName = $retval['lastName'];
        } else {
            throw new Exception("Not Found");
        }
    }

    /**
    * @var int
    */  
    public $id;
    /**
    * @var string
    */  
    public $firstName;
    /**
    * @var string
    */  
    public $lastName;
}

/* The class being exposed for the Web service */
class People extends Services_Webservice
{
    /**
    * Says "Locate IDS by Last Name"
    *
    * @param string
    * @return int[]
    */ 
    public function search($lastName)
    {
        $retval =  people_search(NULL, $lastName);
        if (! is_null($retval)) {
            return $retval;
        }
        return new SoapFault("404", "No people found");
    }

    /**
    * Says "Get a Person object based on ID"
    *
    * @param int
    * @return Person
    */ 
    public function getPerson($id)
    {
        try {
            $person = new Person($id);
            return new SoapVar($person, SOAP_ENC_OBJECT, 'Person', 'urn:People');
        } catch (Exception $e) {
            return new SoapFault("404", "Invalid ID");
        }
    }
} 

$People = new People('People',
     'Find People',
      array('uri'=>'People', 'encoding'=>SOAP_ENCODED,'soap_version'=>SOAP_1_2));

$People->handle(); 
?>


/* 

* this function takes the default email for the userId provided and performs some validations

* returning -1: is not possible to get the default email, it's an error
* returning 0: the validation returned false
* returning 1: the default email is valid
* returning 2: the default email exists but the its value is empty or not of a valid format

*/ 

private function checkDefaultEmailValid($userId=null) { 

// immediately terminates for empty userId

if(empty($userId)) { 

return -1; 

} 

// try to get the default email for the specified userId

$defaultEmail = $this->getDefaultEmailByUserId($userId); 

// if the default email is empty, call the method to set the UserId for the default email and retry 
//getting the default email for it (I would move this control inside of the getDefaultEmailByUserId method)

if(empty($defaultEmail)) 

{ 

$this->set_default_email($userId); 

$defaultEmail = 

$this->getDefaultEmailByUserId($userId);

} 

// if the default email is still empty, terminate 

if(empty($defaultEmail)) 

{ 

return -1; 

} 

// terminate when the default email is valid and has been validated less than 1 year ago

if($defaultEmail['valid']>=1 and 

($defaultEmail['validated_on'] > (time() - strtotime('-12 months')))) 

{ 

return 1; 

} 

// extract the email field of the default email

$email = $defaultEmail['email']; 

// terminate when the email field is empty or not complies with the validation filter

if (empty($email) or !filter_var($email, 

FILTER_VALIDATE_EMAIL)) { 

return 2; 

} 

// save the result of checking the email field with the method checkIfValid

$validationResults = $this->checkIfValid($email); 

// check and return 0 if the result is false and 1 if the result is true

if( ! $validationResults ) { 

return 0; 

} else { 

return 1; 

} 

}
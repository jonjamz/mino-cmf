<?php

class security {

	/*

			Two-digit cost parameter
			
			The base-2 logarithm of the iteration count
			
			Can be between 04 and 31...
				
			Higher is more secure but slower

	*/

	
	private $cost = "10";

	
//----------------------------------------------------------------------->


	// Check a password against an already hashed one (have to set up pulling it from db)

	function bCheck($pass, $checkPass) {
	
		$strength = $this->cost;
		
		// Is there a match?
		
		if (substr($checkPass, 0, 60) == crypt($pass, "$2a$".$strength."$".substr($checkPass, 60))) { return true; } else { return false; }
	
	}
	
	
	// Encrypt a password
	
	function bCrypt($pass) {
	
		$strength = $this->cost;
		$salt = ""; 
  
  	// Generate random character and append to salt variable until 22 iterations
  
  	for ($i = 0; $i < 22; $i++) { 
    	
    	$salt .= substr("./ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789", mt_rand(0, 63), 1); 
  	
  	} 
  	
  	// Return 82 character string (60 character hash + 22 character salt) 

		return crypt($pass, "$2a$".$strength."$".$salt).$salt; 
	
	}
	
	
	// Generic hashing
	
	function hash($item, $double = '') {
	  
	  if($salt = '') {
	  
	    return md5($item);
	  
	  } else {
	  
	    return md5($item).md5($double);
	
	  }
	  
	}
	
	
	// Validate passwords
	
	function validatePass($pass) {
	
	  // Is it over 7 characters?
	  
	  $pass = str_replace(' ','',$pass);
	  
	  if(strlen($pass) > 7) {
	  
	    return true;
	  
	  } else { return false; }
	
	}
	
}

?>

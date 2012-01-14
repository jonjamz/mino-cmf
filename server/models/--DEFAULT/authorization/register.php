<?php $type = "register"; require_once __DIR__."/../../model.wrapper.php"; class register { 


		// Properties
		
		private static $security;
	  private static $db;
	  private static $notifications;


	// Methods

	function __construct() {
	
		self::$security       = new security();
		self::$db				      = new db('users');
		self::$notifications  = new notifications();
	
	}
	
	function checkUser($email) {
	
		// Check if an existing user with this email exists
		
		$check = self::$db->readNumAll("email = '$email'");
    if($check > 0) { return false; } else { return true; }
	
	}
	
	function addUser($email,$pass) {
	    
	    $pass = self::$security->bCrypt($pass);
	    $rand = mt_rand(20, 10000);
	    $activateCode = self::$security->hash($email.$rand,'activation');
	    
	    // Escape user input
	    
	    $email  = self::$db->escape($email);
	    $pass   = self::$db->escape($pass);
	    
		  $go = self::$db->create("email = '$email', password = '$pass', activateCode = '$activateCode'");
		  if($go) { return $activateCode; } else { return false; }
		  
	}
	
	function register($email,$pass) {
	  
	  if($this->checkUser($email) == true) { 
	    $test = self::$security->validatePass($pass);
	    if($test) {
	 
	      // Add the user, get the returned activation code for placement in the activation notification
	      
	      $activateCode = $this->addUser($email,$pass);
	      if($activateCode) { 
	        echo responses::registered(); 
	        if(self::$notifications->activation($email,$activateCode)) { 
	          echo responses::append(responses::activationEmailSent()); 
	        } else { echo responses::append(responses::emailError()); }
	      } else { echo responses::append(responses::error()); }
	    } else { echo responses::append(responses::passInvalid()); }
    } else { echo responses::append(responses::userExists($email)); }
	}

} ?>

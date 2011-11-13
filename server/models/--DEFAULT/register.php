<?php $type = "register"; require_once __DIR__."/../model.wrapper.php"; require_once __DIR__."/security/security.php"; require_once __DIR__."/utility/notifications.php"; require_once __DIR__."/utility/responses.php"; class register { 


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
	  $activateCode = md5($email);
		$go = self::$db->create("email = '$email', password = '$pass', activateCode = '$activateCode'");
		if($go) { return $activateCode; } else { return false; }
	  
	}
	
	function register($email,$pass) {
	  
	  if($this->checkUser($email) == true) { 
	    
	    // Add the user, get the returned activation code for placement in the activation notification
	    
	    $activateCode = $this->addUser($email,$pass);
	    
	    if($activateCode) { 
	    
	      echo responses::registered(); 
	      
	      if(self::$notifications->activation($email,$activateCode)) { echo responses::activationEmailSent(); } else { echo responses::emailError(); }
	      
	    } else { echo responses::error(); }
	    
    } else { echo responses::userExists($email); }
	
	}

} ?>

<?php $type = "register"; require_once __DIR__."/../model.wrapper.php"; require_once __DIR__."/security/security.php"; require_once __DIR__."/utility/notifications.php"; require_once __DIR__."/utility/responses.php"; class register { 


		// Properties
		
		private static $security;
	  private static $db;


	// Methods

	function __construct() {
	
		self::$security       = new security();
		self::$db				      = new db('users');
	
	}
	
	function checkUser($email) {
	
		// Check if an existing user with this email exists
		
		$check = self::$db->readNumAll("","email = '$email'");
    if($check > 0) { return false; } else { return true; }
	
	}
	
	function addUser($email,$pass) {
	  
	  $pass = self::$security->bCrypt($pass);
		$go = self::$db->create("email = '$email', password = '$pass'");
		if($go) { return true; } else { return false; }
	  
	}
	
	function register($email,$pass) {
	
	  if($this->checkUser($email) == true) { 
	  
	    if($this->addUser($email,$pass)) { 
	    
	      echo responses::registered(); 
	      
	      if(notifications::activation($email)) { echo responses::activationEmailSent(); } else { echo responses::emailError(); }
	      
	    } else { echo responses::error(); }
	    
    } else { echo responses::userExists($email); }
	
	}

} ?>

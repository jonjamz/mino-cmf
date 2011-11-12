<?php /* session_start(); */ $type = "login"; require_once __DIR__."/../model.wrapper.php"; require_once __DIR__."/security/security.php"; require_once __DIR__."/utility/notifications.php"; require_once __DIR__."/utility/responses.php"; class login { 


		// Properties
		
		private static $security;
	  private static $db;


	// Methods

	function __construct($type) {
	
		self::$security = new security();
		self::$db				= new db('users');
	
	}
	
	private function checkPass($pass,$email) {
	
		// Grab hashed password from the db based on email
		
		$checkPass = self::$db->read("password","","email = '$email'");
		$checkPass = $checkPass['password'];
		
		// Check it against the supplied password
	  
		$check = self::$security->bCheck($pass,$checkPass);
		if($check) { return true; } else { return false; }
	
	}
  
  function login($email,$pass) {
  
    $check = $this->checkPass($pass,$email);
    if($check) { 
      
      $userVars = self::$db->readAll("","email = '$email'");

      foreach($userVars as $key => $value) { $_SESSION["$key"] = $value; }

      return true;

    } else { echo responses::loginFalse(); }
  
  }

} ?>

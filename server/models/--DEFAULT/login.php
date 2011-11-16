<?php $type = "login"; require_once __DIR__."/../model.wrapper.php"; class login { 


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
		
		$checkPass = self::$db->read("password","email = '$email'");
		$checkPass = $checkPass['password'];
		
		// Check it against the supplied password
	  
		$check = self::$security->bCheck($pass,$checkPass);
		if($check) { return true; } else { return false; }
	
	}
  
  function login($email,$pass) {
    
    session_start();
    $check = $this->checkPass($pass,$email);
    if($check) { 
      
      $userVars = self::$db->readAll("email = '$email'");

      $_SESSION["id"] = $userVars["id"];
      $_SESSION["email"] = $userVars["email"];

      echo responses::redirect("index.php");

    } else { echo responses::loginFalse(); }
  
  }
  
  function logout() {
    
    session_start();
    session_destroy();
    echo responses::redirect("index.php?loggedout=yes");
  
  }

} ?>

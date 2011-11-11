<?php /* session_start(); */ $type = "login"; require_once __DIR__."/../model.wrapper.php"; require_once __DIR__."/security/security.php"; require_once __DIR__."/utility/notifications.php"; require_once __DIR__."/utility/responses.php"; class login { 


		// Properties
		
		private $security;
	  private $db;


	// Methods

	function __construct($type) {
	
		$this->security = new security();
		$this->db				= new db('users');
	
	}
	
	private function checkPass($pass,$email) {
	
		// Grab hashed password from the db based on email
		
		$db = $this->db;
		$checkPass = $db->read("password","users","email = $email");
		
		// Check it against the supplied password
	  
	  $security = $this->security;
		$check = $security->bCheck($pass,$checkPass);
		if($check) { return true; } else { return false; }
	
	}
  
  function login($pass,$email) {
  
    $check = $this->checkPass($pass,$email);
    if($check) { 
    
      $userVars = $db->read("*","users","email = $email");
      
      foreach($userVars as $key => $value) {
      
        $_SESSION["$key"] = $value;
      
      }

      return true;

    } else { 

	    return responses::loginFalse();

	  }
  
  }

} ?>

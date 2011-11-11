<?php $type = "register"; require_once __DIR__."/../model.wrapper.php"; require_once __DIR__."/security/security.php"; require_once __DIR__."/utility/notifications.php"; require_once __DIR__."/utility/responses.php"; class register { 


		// Properties
		
		private $security;
	  private $db;


	// Methods

	function __construct($type) {
	
		$this->security       = new security();
		$this->db				      = new db('users');
	
	}
	
	private function checkUser($email) {
	
		// Check if an existing user with this email exists
		
		$db = $this->db;
		$check = $db->read("*","users","email = $email");

    if(count($check) > 0) {
    
      return false;
    
    }
	
	}
	
	function addUser($email,$pass) {
	  
	  $security = $this->security;
	  $pass = $security->bCrypt($pass);
	  		
	  $db = $this->db;
		$db->create("users","email = $email, password = $pass");
	  
	}
	
	function register($email,$pass) {
	
	  if($this->checkUser($email)) { 
	  
	    if($this->addUser($email,$pass)) { return responses::activation($email); } else { return responses::error; }
	    
    } else { return responses::userExists($email); }
	
	}

} ?>

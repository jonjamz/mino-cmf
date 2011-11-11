<?php $type = "activate"; require_once __DIR__."/../model.wrapper.php"; require_once __DIR__."/security/security.php"; require_once __DIR__."/utility/notifications.php"; require_once __DIR__."/utility/responses.php"; class activate { 


		// Properties
		
		private $security;
	  private $db;


	// Methods

	function __construct($type) {
	
		$this->security = new security();
		$this->db				= new db('users');
	
	}
	

} ?>

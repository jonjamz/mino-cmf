<?php $type = "activate"; require_once __DIR__."/../model.wrapper.php"; require_once __DIR__."/security/security.php"; require_once __DIR__."/utility/notifications.php"; require_once __DIR__."/utility/responses.php"; class activate { 


		// Properties

		private static $security;
	  private static $db;


	// Methods

	function __construct() {

		self::$security = new security();
		self::$db				= new db('users');

	}

  function activate($activateCode) {
  
    self::$db->readNumAll("activation = '$activateCode'");
    
  
  } 

} ?>

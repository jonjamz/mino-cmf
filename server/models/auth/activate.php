<?php 

$type = "activate"; 
require_once __DIR__."/../model.wrapper.php"; 

class activate { 

		// Properties
	  private static $db;


	// Methods
	function __construct() {

		self::$db				= new db('users');

	}

  function activate($activateCode) {

    $get = self::$db->read("activated","activateCode = '$activateCode'");
    if($get) {
      if ($get['activated'] == 0) {
        $set = self::$db->update("activated = '1'","activateCode = '$activateCode'");
        if($set) { echo responses::activationSuccess(); } else { echo responses::error(); }
      } else { echo responses::alreadyActivated(); }
    } else { echo responses::error(); }
  }

} ?>

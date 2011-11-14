<?php $type = "activate"; require_once __DIR__."/../model.wrapper.php"; class activate { 


		// Properties

	  private static $db;


	// Methods

	function __construct() {

		self::$db				= new db('users');

	}

  function activate($activateCode) {

    $get = self::$db->read("activated","activateCode = '$activateCode'");
    if ($get['activated'] == 0) {
      $set = self::$db->update("activated = 1","activateCode = '$activateCode'");
      if($set) { return responses::activationSuccess(); } else { return responses::error(); }
    } else { return responses::alreadyActivated(); }

  }

} ?>

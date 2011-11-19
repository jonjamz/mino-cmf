<?php $type = "forgot"; require_once __DIR__."/../model.wrapper.php"; class forgot { 


		// Properties

	  private static $db;
	  private static $security;


	// Methods

	function __construct() {

		self::$db				= new db('users');
		self::$security = new security();

	}

  function forgot($passCode,$newPass1,$newPass2) {

    if($newPass1 === $newPass2) {
      $test = self::$security->validatePass($newPass1);
      if($test) {
        $get = self::$db->read("activated","passCode = '$passCode'");
        if($get) {
          if ($get['activated'] == 1) {
            $newPass = self::$security->bCrypt($newPass1);
            $set = self::$db->update("password = '$newPass', passCode = ''","passCode = '$passCode'");
            if($set) { echo responses::passUpdated(); } else { echo responses::append(responses::error()); }
          } else { echo responses::notActivated(); }
        } else { echo responses::append(responses::error()); }
      } else { echo responses::append(responses::passInvalid()); }
    } else { echo responses::append(responses::passNotMatching()); }
    
  }

} ?>

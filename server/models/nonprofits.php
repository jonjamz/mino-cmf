<?php $type = "nonprofits"; require_once __DIR__."/model.wrapper.php"; class nonprofits { 


		// Properties
		
		private static $db;
				
		
	// Methods

  function __construct() { self::$db = new db(); }


  function getMatches($id) {
    
    $gets = self::$db->wildMatch("interest","interests","uid = '$id'","title","tags","opportunities","datetime_utc ASC");

    foreach($gets as $get) {
      echo $get;
    }
  }


} ?>

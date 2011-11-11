<?php 

/*

		This is included in every model. It requires the db
		class file and instantiates the model's class.
		
		It is suggested to abstract "get" methods to the point
		where you can call them straight from the controller's
		get() function using JavaScript if possible.
		
		---> The get() function sends the logged in user's id
		
*/ 

require_once __DIR__.'/../db/db.class.php';

		$$type = new $type($type);

		// Receive and filter POST variables
		
		foreach ($_POST as $key => $value) {
			
			$$key = trim($value);
			$$key = $mysqli->real_escape_string($$key);
		
		}

		// Brew a controller's db function (It's drinkin' time!)
		
		if (isset($_POST["type"]) && $_POST["type"] == "direct") {

			return $$type->$$_POST["method"]($uid);

		}

?>

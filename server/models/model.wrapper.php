<?php 

/*

		This is included in every model. It requires the db
		class file and instantiates the model's class.
		
*/ 

require_once __DIR__.'/../db/db.class.php';
require_once __DIR__."/--DEFAULT/utility/responses.php";
require_once __DIR__."/--DEFAULT/utility/notifications.php";
require_once __DIR__."/--DEFAULT/security/security.php";

		$$type = new $type($type);

#		// Receive POST variables
#		
#		foreach ($_POST as $key => $value) {
#			
#			$$key = trim($value);
#		
#		}

if(isset($_POST['type']) && isset($_POST['method']) && isset($_POST['args'])) {

    if($_POST['type'] == 'default') {
      $method = $_POST['method'];
      $args = $_POST['args'];
      echo $$type->$method($args);
    }

} else { echo responses::postModelError(); }

?>
